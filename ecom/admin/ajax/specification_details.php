<?php
@session_start();
require_once ('../../config/connection.inc.php');

header('Content-type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_GET['process'] == 'INSERT_DATA') {
    $response = [];

    $category_id = escapeString($_POST['category_id']);
    $subcategory_id = escapeString($_POST['subcategory_id']);
    $product_id = escapeString($_POST['product_name']);
    $specification_name = escapeString(addslashes($_POST['specification_name']));
    $specification_details = escapeString(addslashes($_POST['specification_details']));

    // Check if the specification name already exists for the selected category, subcategory, and product
    $specificationQuery = executeQuery("SELECT detail_id, detail_name FROM product_specification_details WHERE category_id = '$category_id' AND subcategory_id = '$subcategory_id' AND product_id = '$product_id' AND specification_id = '$specification_name' AND detail_name = '$specification_details' AND status = 1 AND is_deleted = 0");

    if (numRows($specificationQuery) > 0) {
        $response['status'] = 'warning';
        $response['message'] = 'A specification with the same name already exists in this category and product. Please use a different name.';
    } else {
        $insertQuery = executeQuery("INSERT INTO product_specification_details (category_id, subcategory_id, product_id, specification_id,detail_name) VALUES ('$category_id', '$subcategory_id', '$product_id', '$specification_name', '$specification_details')");

        if ($insertQuery) {
            $response["status"] = "success";
            $response["message"] = "New specification detail added successfully!";
        } else {
            $response["status"] = "error";
            $response["message"] = "Error occurred while inserting the specification data!";
        }
    }

    echo json_encode($response);
} else if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_GET['process'] == 'GET_DATA') {
    $response = [];
    $limit = isset($_GET['length']) ? intval($_GET['length']) : 10; // number of records per page
    $start = isset($_GET['start']) ? intval($_GET['start']) : 0;  // starting record number
    $draw = isset($_GET['draw']) ? intval($_GET['draw']) : 1;    // for DataTables' draw counter
    $searchValue = isset($_GET['search']['value']) ? escapeString(addslashes($_GET['search']['value'])) : ''; // Search parameter

    $query = "SELECT 
        cat.category_name, 
        sbcat.subcategory_name, 
        p.product_name, 
        p.product_image, 
        s.list_name,
        sd.category_id, 
        sd.subcategory_id, 
        sd.product_id,
        sd.specification_id,
        sd.detail_id,
        sd.detail_name, 
        sd.created_at, 
        sd.updated_at 
      FROM product_specification_details sd
      INNER JOIN categories cat ON sd.category_id = cat.category_id
      INNER JOIN subcategories sbcat ON sd.subcategory_id = sbcat.subcategory_id
      INNER JOIN products p ON sd.product_id = p.product_id
      INNER JOIN product_specification_lists s ON sd.specification_id = s.list_id
      WHERE sd.status = 1 AND sd.is_deleted = 0";

    // Filtering
    if (!empty($searchValue)) {
        $query .= " AND (cat.category_name LIKE '%" . $searchValue . "%' OR 
                         sbcat.subcategory_name LIKE '%" . $searchValue . "%' OR 
                         p.product_name LIKE '%" . $searchValue . "%' OR 
                         s.list_name LIKE '%" . $searchValue . "%' OR 
                         sd.detail_name LIKE '%" . $searchValue . "%')";
    }

    // Total records without filtering
    $totalQuery = "SELECT COUNT(*) AS total FROM product_specification_details sd WHERE sd.status = 1 AND sd.is_deleted = 0";
    $totalResult = executeQuery($totalQuery);
    $totalRecords = fetchObject($totalResult)->total;

    // Total records with filtering
    $filteredQuery = "SELECT COUNT(*) AS total FROM ($query) AS temp";
    $filteredResult = executeQuery($filteredQuery);
    $filteredRecords = fetchObject($filteredResult)->total;

    // Handle ordering
    $orderColumn = isset($_GET['order'][0]['column']) ? intval($_GET['order'][0]['column']) : 0;
    $orderDir = isset($_GET['order'][0]['dir']) ? $_GET['order'][0]['dir'] : 'DESC';
    $orderColumns = ['sd.detail_id', 'cat.category_name', 'sbcat.subcategory_name', 'p.product_name', 'p.product_image', 's.list_name', 'sd.detail_name', 'sd.created_at', 'sd.updated_at'];
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
    echo json_encode($response);
} else if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_GET['process'] == 'GET_DATA') {

}
?>