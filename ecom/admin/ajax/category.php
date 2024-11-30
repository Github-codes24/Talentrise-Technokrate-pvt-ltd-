<?php
@session_start();
require_once ('../../config/connection.inc.php');
require_once ('../include/resizers/image_resizer.php');
// require_once ('../include/resizers/resizer_functions.php');

header('Content-type: application/json');

$process = escapeString($_POST['process']);
$response = [];

if ($process == 'GET_DATA') {
    $catQuery = executeQuery("SELECT * FROM categories WHERE status = 1 AND is_deleted = 0 ORDER BY category_id DESC");

    if (numRows($catQuery) > 0) {
        while ($catRow = fetchObject($catQuery)) {
            array_push($response, $catRow);
        }
    }
} else if ($process == 'INSERT_DATA') {
    $category = escapeString(addslashes($_POST['category']));
    $category_sname = escapeString(addslashes($_POST['category_sname']));
    $image = $_FILES['image'];

    if (isset($image) && $image['error'] == 0) {
        $image = $_FILES['image'];
    } else {
        $image = null;
    }

    $catQuery = executeQuery("SELECT category_name,category_short_name FROM categories WHERE category_name = '$category' AND category_short_name = '$category_sname' AND is_deleted = 0");

    if (numRows($catQuery) > 0) {
        $response['status'] = 'warning';
        $response['message'] = 'Add new category name, it is already exist.';
    } else {
        $target_dir = "../images/products/categories/";
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
                $savePath = "../images/products/categories/thumb-{$size}/" . $new_name;

                // Ensure the directory exists
                if (!file_exists("../images/products/categories/thumb-{$size}/")) {
                    mkdir("../images/products/categories/thumb-{$size}/", 0777, true);
                }

                // Save the resized image
                $resizeObj->saveImage($savePath, 100); // Assuming image quality of 100
            }
            $insertQuery = executeQuery("INSERT INTO categories (category_name,category_short_name,category_image) VALUES ('$category','$category_sname','$new_name')");

            if ($insertQuery) {
                $response["status"] = "success";
                $response["message"] = "New category added successfully!";
            } else {
                $response["status"] = "error";
                $response["message"] = "Error occured while inserting the data!";
            }
        }
    }
} else if ($process == "UPDATE_DATA") {
    $category = escapeString(addslashes($_POST['category']));
    $category_sname = escapeString(addslashes($_POST['category_sname']));
    $category_id = escapeString($_POST['category_id']);

    if (!empty($_FILES['image'])) {
        $image = $_FILES['image'];

        // Fetch previous image name from the database
        $prevImageQuery = executeQuery("SELECT category_image FROM categories WHERE category_name = '$category' AND category_short_name = '$category_sname' AND category_id = $category_id");

        if (numRows($prevImageQuery) > 0) {
            $prevImageRow = fetchAssoc($prevImageQuery);
            $prevImage = $prevImageRow['category_image'];


            // New image is uploaded
            $target_dir = "../images/products/categories/";
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
                    $savePath = "../images/products/categories/thumb-{$size}/" . $new_name;

                    // Ensure the directory exists
                    if (!file_exists("../images/products/categories/thumb-{$size}/")) {
                        mkdir("../images/products/categories/thumb-{$size}/", 0777, true);
                    }

                    // Save the resized image
                    $resizeObj->saveImage($savePath, 100); // Assuming image quality of 100
                }

                // Delete previous image from all thumb folders
                $thumbDirs = glob($target_dir . "thumb-*", GLOB_ONLYDIR);
                foreach ($thumbDirs as $thumbDir) {
                    unlink($thumbDir . "/" . $prevImage);
                }

                // Update the category data with new image
                $updateQuery = executeQuery("UPDATE categories SET category_name = '$category', category_short_name = '$category_sname', category_image = '$new_name',updated_at = NOW() WHERE category_id = $category_id");

                if ($updateQuery) {
                    $response["status"] = "success";
                    $response["message"] = "Category updated successfully!";
                } else {
                    $response["status"] = "error";
                    $response["message"] = "Error occurred while updating the category!";
                }

            } else {
                $response["status"] = "error";
                $response["message"] = "Error occured while uploading the image.";
            }
        }
    } else {
        // No new image uploaded, update category data only
        $updateQuery = executeQuery("UPDATE categories SET category_name = '$category', category_short_name = '$category_sname',updated_at = NOW() WHERE category_id = $category_id");

        if ($updateQuery) {
            $response["status"] = "success";
            $response["message"] = "Category updated successfully!";
        } else {
            $response["status"] = "error";
            $response["message"] = "Error occurred while updating the category!";
        }
    }
} else if ($process == 'DELETE_DATA') {
    $id = escapeString($_POST['id']);

    $query = executeQuery("UPDATE categories SET status = 0 WHERE category_id = $id");

    if ($query) {
        $response['status'] = 'success';
        $response['message'] = 'Category deleted successfully.';
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
            $updateQuery = "UPDATE categories SET status = 0 WHERE category_id = '$escapedId'";
            $result = executeQuery($updateQuery);

            if (!$result) {
                throw new Exception('Query failed: ' . mysqli_error($conn));
            }
        }

        $response['status'] = 'success';
        $response['message'] = 'Categories has been deleted successfully!';
    } catch (Exception $e) {
        $response['message'] = 'An error occurred: ' . $e->getMessage();
    }
}
echo json_encode($response);
closeDB();
?>