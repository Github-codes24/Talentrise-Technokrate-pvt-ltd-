<?php
@session_start();
require_once ('../../config/connection.inc.php');
require_once ('../include/resizers/image_resizer.php');
// require_once ('../include/resizers/resizer_functions.php');

header('Content-type: application/json');

$process = $_GET['process'];
$response = [];

// Check the process value
if ($process === "GET_DATA") {
    $limit = isset($_GET['length']) ? intval($_GET['length']) : 10; // number of records per page
    $start = isset($_GET['start']) ? intval($_GET['start']) : 0;  // starting record number
    $draw = isset($_GET['draw']) ? intval($_GET['draw']) : 1;    // for DataTables' draw counter
    $searchValue = isset($_GET['search']['value']) ? escapeString(addslashes($_GET['search']['value'])) : ''; // Search parameter

    // Base query
    $query = "SELECT cat.category_name, sbcat.subcategory_name, p.product_id, p.product_image, p.product_name, p.category_id, p.subcategory_id, p.created_at, p.updated_at 
          FROM products p
          INNER JOIN categories cat ON p.category_id = cat.category_id
          INNER JOIN subcategories sbcat ON p.subcategory_id = sbcat.subcategory_id
          WHERE p.status = 1 AND p.is_deleted = 0";

    // Filtering
    if (!empty($searchValue)) {
        $query .= " AND (cat.category_name LIKE '%" . $searchValue . "%' OR sbcat.subcategory_name LIKE '%" . $searchValue . "%' OR p.product_name LIKE '%" . $searchValue . "%')";
    }

    // Total records without filtering
    $totalQuery = "SELECT COUNT(*) AS total FROM products p WHERE p.status = 1 AND p.is_deleted = 0";
    $totalResult = executeQuery($totalQuery);
    $totalRecords = fetchObject($totalResult)->total;

    // Total records with filtering
    $filteredQuery = "SELECT COUNT(*) AS total FROM ($query) AS temp";
    $filteredResult = executeQuery($filteredQuery);
    $filteredRecords = fetchObject($filteredResult)->total;

    // Handle ordering
    $orderColumn = isset($_GET['order'][0]['column']) ? intval($_GET['order'][0]['column']) : 0;
    $orderDir = isset($_GET['order'][0]['dir']) ? $_GET['order'][0]['dir'] : 'DESC';
    $orderColumns = ['p.product_id', 'cat.category_name', 'sbcat.subcategory_name', 'p.product_image', 'p.product_name', 'p.created_at', 'p.updated_at'];
    $orderBy = isset($orderColumns[$orderColumn]) ? $orderColumns[$orderColumn] : $orderColumns[0];
    $query .= " ORDER BY $orderBy $orderDir";

    // Fetch records with limit and offset
    $query .= " LIMIT $start, $limit";
    $dataResult = executeQuery($query);
    $data = [];

    if (numRows($dataResult) > 0) {
        while ($row = fetchObject($dataResult)) {
            $data[] = $row;
        }
    }

    // Prepare the response
    $response = [
        "draw" => $draw,
        "recordsTotal" => $totalRecords,
        "recordsFiltered" => $filteredRecords,
        "data" => $data
    ];
} else if ($process == "INSERT_PRODUCT_DATA") {
    $category = escapeString($_POST['category_id']);
    $sub_category = escapeString($_POST['sub_category_id']);
    $productName = escapeString(addslashes($_POST['product_name']));
    $image = $_FILES['image'];

    // Check if the image is set and there is no error
    if (isset($image) && $image['error'] == 0) {
        $image = $_FILES['image'];
    } else {
        $image = null;
    }

    // Check if the product name already exists for the selected category
    $productQuery = executeQuery("SELECT product_id, product_name FROM products WHERE category_id = '$category' AND subcategory_id = '$sub_category' AND product_name = '$productName' AND is_deleted = 0");

    if (numRows($productQuery) > 0) {
        $response['status'] = 'warning';
        $response['message'] = 'A product with the same name already exists in this category. Please use a different name.';
    } else {
        $target_dir = "../images/products/product_images/";
        $name = rand(10000, 1000000);
        $extension = pathinfo($image["name"], PATHINFO_EXTENSION);
        $new_name = $name . "." . $extension;
        $target_file = $target_dir . $new_name;

        // Move uploaded file to target directory
        if (move_uploaded_file($image["tmp_name"], $target_file)) {
            // Create an instance of the Resize class
            $resizeObj = new Resize($target_file);

            // Array of sizes to resize the image to
            $sizes = [50, 100, 150, 300];

            foreach ($sizes as $size) {
                // Resize the image
                $resizeObj->resizeImage($size, $size, 'exact');

                // Define the path to save the resized image
                $savePath = "../images/products/product_images/thumb-{$size}/" . $new_name;

                // Ensure the directory exists
                if (!file_exists("../images/products/product_images/thumb-{$size}/")) {
                    mkdir("../images/products/product_images/thumb-{$size}/", 0777, true);
                }

                // Save the resized image
                $resizeObj->saveImage($savePath, 100); // Assuming image quality of 100
            }
            $insertQuery = executeQuery("INSERT INTO products (category_id,subcategory_id, product_name, product_image) VALUES ('$category','$sub_category','$productName','$new_name')");

            if ($insertQuery) {
                $response["status"] = "success";
                $response["message"] = "New product added successfully!";
            } else {
                $response["status"] = "error";
                $response["message"] = "Error occurred while inserting the product data!";
            }
        }
    }
} else if ($process == "UPDATE_DATA") {
    $category_id = escapeString(addslashes($_POST['category_id']));
    $sub_category_id = escapeString(addslashes($_POST['sub_category_id']));
    $product_name = escapeString(addslashes($_POST['product_name']));
    $product_id = escapeString($_POST['product_id']); // Assuming product_id is sent in the request

    if (!empty($_FILES['image'])) {
        $image = $_FILES['image'];

        // Fetch previous image name from the database
        $prevImageQuery = executeQuery("SELECT product_image FROM products WHERE product_id = '$product_id'");

        if (numRows($prevImageQuery) > 0) {
            $prevImageRow = fetchAssoc($prevImageQuery);
            $prevImage = $prevImageRow['product_image'];

            // New image is uploaded
            $target_dir = "../images/products/product_images/";
            $name = rand(10000, 1000000);
            $extension = pathinfo($image["name"], PATHINFO_EXTENSION);
            $new_name = $name . "." . $extension;
            $target_file = $target_dir . $new_name;

            // Move uploaded file to target directory
            if (move_uploaded_file($image["tmp_name"], $target_file)) {
                // Create an instance of the Resize class
                $resizeObj = new Resize($target_file);

                // Array of sizes to resize the image to
                $sizes = [50, 100, 150, 300];

                foreach ($sizes as $size) {
                    // Resize the image
                    $resizeObj->resizeImage($size, $size, 'exact');

                    // Define the path to save the resized image
                    $savePath = "../images/products/product_images/thumb-{$size}/" . $new_name;

                    // Ensure the directory exists
                    if (!file_exists("../images/products/product_images/thumb-{$size}/")) {
                        mkdir("../images/products/product_images/thumb-{$size}/", 0777, true);
                    }

                    // Save the resized image
                    $resizeObj->saveImage($savePath, 100); // Assuming image quality of 100
                }

                // Delete previous image from all thumb folders
                $thumbDirs = glob($target_dir . "thumb-*", GLOB_ONLYDIR);
                foreach ($thumbDirs as $thumbDir) {
                    unlink($thumbDir . "/" . $prevImage);
                }

                // Update the product data with new image
                $updateQuery = executeQuery("UPDATE products SET category_id = '$category_id', subcategory_id = '$sub_category_id', product_name = '$product_name', product_image = '$new_name', updated_at = NOW() WHERE product_id = '$product_id'");

                if ($updateQuery) {
                    $response["status"] = "success";
                    $response["message"] = "Product updated successfully!";
                } else {
                    $response["status"] = "error";
                    $response["message"] = "Error occurred while updating the product!";
                }

            } else {
                $response["status"] = "error";
                $response["message"] = "Error occurred while uploading the image.";
            }
        } else {
            $response["status"] = "error";
            $response["message"] = "Product not found.";
        }
    } else {
        // Update product details without changing the image
        $updateQuery = executeQuery("UPDATE products SET category_id = '$category_id', subcategory_id = '$sub_category_id', product_name = '$product_name', updated_at = NOW() WHERE product_id = '$product_id'");

        if ($updateQuery) {
            $response["status"] = "success";
            $response["message"] = "Product updated successfully!";
        } else {
            $response["status"] = "error";
            $response["message"] = "Error occurred while updating the product!";
        }
    }
} else if ($process == "DELETE_DATA") {
    $id = escapeString($_POST['id']);

    $query = executeQuery("UPDATE products SET status = 0 WHERE product_id = $id");

    if ($query) {
        $response['status'] = 'success';
        $response['message'] = 'Product deleted successfully.';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Error occured while deleting the record.';
    }
} else if ($process == 'DELETE_ALL_DATA') {
    $ids = $_POST['id'];

    // Initialize response
    $response = [
        'status' => 'error',
        'message' => 'An error occurred while updating the records.'
    ];

    try {
        // Loop through each ID and execute the update query
        foreach ($ids as $id) {
            $escapedId = escapeString($id);
            $updateQuery = "UPDATE products SET status = 0 WHERE product_id = '$escapedId'";
            $result = executeQuery($updateQuery);

            if (!$result) {
                throw new Exception('Query failed: ' . mysqli_error($conn));
            }
        }

        $response['status'] = 'success';
        $response['message'] = 'Product has been deleted successfully!';
    } catch (Exception $e) {
        $response['message'] = 'An error occurred: ' . $e->getMessage();
    }
}
// Return JSON response
echo json_encode($response);
closeDB();
?>