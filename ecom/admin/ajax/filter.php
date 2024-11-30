<?php
@session_start();
require_once ('../../config/connection.inc.php');
require_once ('../include/resizers/image_resizer.php');
// require_once ('../include/resizers/resizer_functions.php');

header('Content-type: application/json');

$process = escapeString($_POST['process']);

if ($process == "GET_SUB_CAT") {
    $response_data = [];
    $category = $_POST["category"];
    $sub_category = isset($_POST["sub_category"]) ? $_POST["sub_category"] : '';

    $query = executeQuery("SELECT subcategory_id, subcategory_name FROM subcategories WHERE category_id = '$category' AND status = 1 AND is_deleted = 0");

    if (numRows($query) > 0) {
        while ($row = fetchObject($query)) {
            $response[] = $row;
        }
    }

    // If a sub-category is provided, add it as a separate field
    $response_data = [
        "subcategories" => $response,
        "selected_sub_category" => $sub_category
    ];
    echo json_encode($response_data);
} else if ($process == "GET_PRODUCT") {
    $response_data = [];
    $category = isset($_POST["category"]) ? intval($_POST["category"]) : 0;
    $sub_category = isset($_POST["sub_category"]) ? intval($_POST["sub_category"]) : 0;
    $product = isset($_POST["product_id"]) ? intval($_POST["product_id"]) : '';

    // Initialize the response array
    $response = [];

    if ($category > 0 && $sub_category > 0) {
        $query = executeQuery("SELECT product_id, product_name FROM products WHERE category_id = $category AND subcategory_id = $sub_category AND status = 1 AND is_deleted = 0");

        if (numRows($query) > 0) {
            while ($row = fetchObject($query)) {
                $response[] = $row;
            }
        }
    }

    // Prepare the response data
    $response_data = [
        "products" => $response,
        "selected_product" => $product
    ];

    echo json_encode($response_data);
}else if ($process == "GET_SPECIFICATION") {
    $response_data = [];
    $category = isset($_POST["category"]) ? intval($_POST["category"]) : 0;
    $sub_category = isset($_POST["sub_category"]) ? intval($_POST["sub_category"]) : 0;
    $product = isset($_POST["product_id"]) ? intval($_POST["product_id"]) : 0;
    $specification_id = isset($_POST["specification_id"]) ? intval($_POST["specification_id"]) : '';

    // Initialize the response array
    $response = [];

    if ($category > 0 && $sub_category > 0) {
        $query = executeQuery("SELECT list_id, list_name FROM product_specification_lists WHERE category_id = $category AND subcategory_id = $sub_category AND product_id = $product AND status = 1 AND is_deleted = 0");

        if (numRows($query) > 0) {
            while ($row = fetchObject($query)) {
                $response[] = $row;
            }
        }
    }

    // Prepare the response data
    $response_data = [
        "specification" => $response,
        "selected_specification" => $product
    ];

    echo json_encode($response_data);
}
closeDB();
?>