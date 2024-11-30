<?php
@session_start();
require_once ('../../config/connection.inc.php');
require_once ('../include/resizers/image_resizer.php');
// require_once ('../include/resizers/resizer_functions.php');

header('Content-type: application/json');

$process = escapeString($_POST['process']);
$response = [];

if ($process == 'GET_DATA') {
    $catQuery = executeQuery("SELECT sbcat.*,cat.category_name FROM subcategories sbcat
    INNER JOIN
    categories cat
    ON sbcat.category_id = cat.category_id
    WHERE sbcat.status = 1 AND sbcat.is_deleted = 0 ORDER BY sbcat.subcategory_id DESC");

    if (numRows($catQuery) > 0) {
        while ($catRow = fetchObject($catQuery)) {
            array_push($response, $catRow);
        }
    }
} else if ($process == 'INSERT_SUBCATEGORY_DATA') {
    $category = escapeString($_POST['cat_id']);
    $sub_cat_name = escapeString(addslashes($_POST['sub_cat_name']));
    $image = $_FILES['image'];

    if (isset($image) && $image['error'] == 0) {
        $image = $_FILES['image'];
    } else {
        $image = null;
    }

    $catQuery = executeQuery("SELECT category_id,subcategory_name FROM subcategories WHERE category_id = '$category' AND subcategory_name = '$sub_cat_name' AND is_deleted = 0");

    if (numRows($catQuery) > 0) {
        $response['status'] = 'warning';
        $response['message'] = 'Add new sub category name, it is already exist.';
    } else {
        $target_dir = "../images/products/sub_categories/";
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
                $savePath = "../images/products/sub_categories/thumb-{$size}/" . $new_name;

                // Ensure the directory exists
                if (!file_exists("../images/products/sub_categories/thumb-{$size}/")) {
                    mkdir("../images/products/sub_categories/thumb-{$size}/", 0777, true);
                }

                // Save the resized image
                $resizeObj->saveImage($savePath, 100); // Assuming image quality of 100
            }
            $insertQuery = executeQuery("INSERT INTO subcategories (category_id,subcategory_name,sub_category_image) VALUES ('$category','$sub_cat_name','$new_name')");

            if ($insertQuery) {
                $response["status"] = "success";
                $response["message"] = "New Sub category added successfully!";
            } else {
                $response["status"] = "error";
                $response["message"] = "Error occured while inserting the data!";
            }
        }
    }
} else if ($process == "UPDATE_DATA") {
    $category = escapeString($_POST['cat_id']);
    $sub_cat_name = escapeString(addslashes($_POST['sub_cat_name']));    
    $id = escapeString($_POST['id']);

    if (!empty($_FILES['image'])) {
        $image = $_FILES['image'];

        // Fetch previous image name from the database
        $prevImageQuery = executeQuery("SELECT sub_category_image FROM subcategories WHERE category_id = '$category' AND subcategory_name = '$sub_cat_name' AND subcategory_id = $id");

        if (numRows($prevImageQuery) > 0) {
            $prevImageRow = fetchAssoc($prevImageQuery);
            $prevImage = $prevImageRow['sub_category_image'];


            // New image is uploaded
            $target_dir = "../images/products/sub_categories/";
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
                    $savePath = "../images/products/sub_categories/thumb-{$size}/" . $new_name;

                    // Ensure the directory exists
                    if (!file_exists("../images/products/sub_categories/thumb-{$size}/")) {
                        mkdir("../images/products/sub_categories/thumb-{$size}/", 0777, true);
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
                $updateQuery = executeQuery("UPDATE subcategories SET category_id = '$category', subcategory_name = '$sub_cat_name', sub_category_image = '$new_name',updated_at = NOW() WHERE subcategory_id = $id");

                if ($updateQuery) {
                    $response["status"] = "success";
                    $response["message"] = "Sub Category updated successfully!";
                } else {
                    $response["status"] = "error";
                    $response["message"] = "Error occurred while updating the sub category!";
                }

            } else {
                $response["status"] = "error";
                $response["message"] = "Error occured while uploading the image.";
            }
        }
    } else {
        // No new image uploaded, update category data only
        $updateQuery = executeQuery("UPDATE subcategories SET subcategory_name = '$sub_cat_name', category_id = '$category',updated_at = NOW() WHERE subcategory_id = $id");

        if ($updateQuery) {
            $response["status"] = "success";
            $response["message"] = "Sub Category updated successfully!";
        } else {
            $response["status"] = "error";
            $response["message"] = "Error occurred while updating the category!";
        }
    }
} else if ($process == 'DELETE_DATA') {
    $id = escapeString($_POST['id']);

    $query = executeQuery("UPDATE subcategories SET status = 0 WHERE subcategory_id = $id");

    if ($query) {
        $response['status'] = 'success';
        $response['message'] = 'Sub Category deleted successfully.';
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
            $updateQuery = "UPDATE subcategories SET status = 0 WHERE subcategory_id = '$escapedId'";
            $result = executeQuery($updateQuery);

            if (!$result) {
                throw new Exception('Query failed: ' . mysqli_error($conn));
            }
        }

        $response['status'] = 'success';
        $response['message'] = 'Sub Categories has been deleted successfully!';
    } catch (Exception $e) {
        $response['message'] = 'An error occurred: ' . $e->getMessage();
    }
}
echo json_encode($response);
closeDB();
?>