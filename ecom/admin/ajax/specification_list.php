<?php
@session_start();
require_once ('../../config/connection.inc.php');

header('Content-type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_GET['process'] == 'INSERT_SPECIALIZATION_DATA') {
    $response = [];

    $category_id = escapeString($_POST['category_id']);
    $subcategory_id = escapeString($_POST['subcategory_id']);
    $product_id = escapeString($_POST['product_name']);
    $specialization_name = escapeString(addslashes($_POST['specialization_name']));

    // Check if the specialization name already exists for the selected category and product
    $specializationQuery = executeQuery("SELECT list_id, list_name FROM product_specification_lists WHERE category_id = '$category_id' AND subcategory_id = '$subcategory_id' AND product_id = '$product_id' AND list_name = '$specialization_name' AND is_deleted = 0");

    if (numRows($specializationQuery) > 0) {
        $response['status'] = 'warning';
        $response['message'] = 'A specialization with the same name already exists in this category and product. Please use a different name.';
    } else {
        $insertQuery = executeQuery("INSERT INTO product_specification_lists (category_id, subcategory_id, product_id, list_name) VALUES ('$category_id', '$subcategory_id', '$product_id', '$specialization_name')");

        if ($insertQuery) {
            $response["status"] = "success";
            $response["message"] = "New specialization added successfully!";
        } else {
            $response["status"] = "error";
            $response["message"] = "Error occurred while inserting the specialization data!";
        }
    }

    echo json_encode($response);
} else if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['process'] == 'GET_DATA') {

    $limit = isset($_GET['length']) ? intval($_GET['length']) : 10; // number of records per page
    $start = isset($_GET['start']) ? intval($_GET['start']) : 0;  // starting record number
    $draw = isset($_GET['draw']) ? intval($_GET['draw']) : 1;    // for DataTables' draw counter
    $searchValue = isset($_GET['search']['value']) ? escapeString(addslashes($_GET['search']['value'])) : ''; // Search parameter

    $query = "SELECT 
            cat.category_name, 
            sbcat.subcategory_name, 
            p.product_name, 
            p.product_image,            
            s.category_id, 
            s.subcategory_id, 
            s.product_id,
            s.list_id,
            s.list_name, 
            s.created_at, 
            s.updated_at 
          FROM product_specification_lists s
          INNER JOIN categories cat ON s.category_id = cat.category_id
          INNER JOIN subcategories sbcat ON s.subcategory_id = sbcat.subcategory_id
          INNER JOIN products p ON s.product_id = p.product_id
          WHERE s.status = 1 AND s.is_deleted = 0";

    // Filtering
    if (!empty($searchValue)) {
        $query .= " AND (cat.category_name LIKE '%" . $searchValue . "%' OR 
                     sbcat.subcategory_name LIKE '%" . $searchValue . "%' OR 
                     p.product_name LIKE '%" . $searchValue . "%' OR 
                     s.list_name LIKE '%" . $searchValue . "%')";
    }

    // Total records without filtering
    $totalQuery = "SELECT COUNT(*) AS total FROM product_specification_lists s WHERE s.status = 1 AND s.is_deleted = 0";
    $totalResult = executeQuery($totalQuery);
    $totalRecords = fetchObject($totalResult)->total;

    // Total records with filtering
    $filteredQuery = "SELECT COUNT(*) AS total FROM ($query) AS temp";
    $filteredResult = executeQuery($filteredQuery);
    $filteredRecords = fetchObject($filteredResult)->total;

    // Handle ordering
    $orderColumn = isset($_GET['order'][0]['column']) ? intval($_GET['order'][0]['column']) : 0;
    $orderDir = isset($_GET['order'][0]['dir']) ? $_GET['order'][0]['dir'] : 'DESC';
    $orderColumns = ['s.product_id', 'cat.category_name', 'sbcat.subcategory_name', 'p.product_name', 'p.product_image', 's.list_name', 's.created_at', 's.updated_at'];
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

    header('Content-Type: application/json');
    echo json_encode($response);
} else if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_GET['process'] == 'UPDATE_DATA') {

    $category_id = escapeString(addslashes($_POST['category_id']));
    $sub_category_id = escapeString(addslashes($_POST['sub_category_id']));
    $product_id = escapeString($_POST['product_id']);
    $list_id = escapeString($_POST['list_id']);

    // Initialize response array
    $response = [];

    // Update product details
    $updateQuery = executeQuery("UPDATE product_specification_lists SET category_id = '$category_id', subcategory_id = '$sub_category_id', product_id = '$product_id', updated_at = NOW() WHERE list_id = '$list_id'");

    if ($updateQuery) {
        $response["status"] = "success";
        $response["message"] = "Specification updated successfully!";
    } else {
        $response["status"] = "error";
        $response["message"] = "Error occurred while updating the product!";
    }

    // Output JSON response
    echo json_encode($response);
} else if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_GET['process'] == 'DELETE_DATA') {
    $id = escapeString($_POST['id']);
    $response = [];

    $query = executeQuery("UPDATE product_specification_lists SET status = 0 WHERE list_id = $id");

    if ($query) {
        $response['status'] = 'success';
        $response['message'] = 'Product deleted successfully.';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Error occured while deleting the record.';
    }
    echo json_encode($response);
} else if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_GET['process'] == 'DELETE_ALL_DATA') {
    $ids = $_POST['id'];
    $response = [];
    // Initialize response
    $response = [
        'status' => 'error',
        'message' => 'An error occurred while updating the records.'
    ];

    try {
        // Loop through each ID and execute the update query
        foreach ($ids as $id) {
            $escapedId = escapeString($id);
            $updateQuery = "UPDATE product_specification_lists SET status = 0 WHERE list_id = '$escapedId'";
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
    echo json_encode($response);
}
?>