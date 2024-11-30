<?php
require_once ('../config/connection.inc.php');
require_once ('auth.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $site_name; ?> | Products</title>
    <?php require_once ('include/base/links.php'); ?>
    <style>
        .error {
            color: red !important;
            font-size: 12px !important;
        }
    </style>
</head>

<body class="font-montserrat">
    <?php require_once ('include/loader/page_loader.php'); ?>

    <div id="main_content">
        <!-- small bottom sidebar -->
        <?php require_once ('include/sidebar/small-bottom-sidebar.php'); ?>
        <!-- /small bottom sidebar -->

        <!-- setting sidebar -->
        <?php require_once ('include/sidebar/setting-sidebar.php'); ?>
        <!-- /setting sidebar -->

        <!-- profile sidebar -->
        <?php require_once ('include/sidebar/profile-sidebar.php'); ?>
        <!-- /profile sidebar -->

        <!-- sidebar -->
        <?php require_once ('include/sidebar/main-sidebar.php'); ?>
        <!-- /sidebar -->

        <div class="page">
            <!-- header -->
            <?php require_once ('include/header/header.php'); ?>
            <!-- /header -->
            <!-- alert -->
            <?php require_once ('../assets/custom_alert/alert.php'); ?>
            <!-- /alert -->

            <div class="section-body mt-3">
                <div class="container-fluid">
                    <div class="row clearfix">
                        <div class="col-lg-12">
                            <div class="card" style="overflow: auto;">
                                <div class="card-body">
                                    <h6><i class="fa-solid fa-list"></i> Specification Details</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <button type="button" class="btn btn-info my-2" data-toggle="modal"
                                data-target="#addNewSpecializationModal" id="openModalBtn">
                                <i class="fa-solid fa-plus"></i> Add New details
                            </button>

                            <div class="modal fade" id="addNewSpecializationModal" tabindex="-1" role="dialog"
                                aria-labelledby="addNewSpecializationModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title" id="addNewSpecializationModalLabel">Add New
                                                Specification</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="specializationForm" method="POST">
                                                <div class="form-group">
                                                    <label for="categoryName">Category:</label>
                                                    <select class="form-control" name="category_name" id="categoryName">
                                                        <option value="" selected disabled>Select Category</option>
                                                        <?php
                                                        $query = executeQuery("SELECT category_name,category_id FROM categories WHERE status = 1 AND is_deleted = 0");

                                                        if (numRows($query) > 0) {
                                                            while ($row = fetchObject($query)) {
                                                                echo '<option value="' . $row->category_id . '">' . $row->category_name . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                    <span class="text-danger error" id="categoryNameError"></span>
                                                </div>
                                                <div class="form-group">
                                                    <label for="subCategoryName">Subcategory:</label>
                                                    <select class="form-control" id="subCategoryName"
                                                        name="sub_category_name">
                                                        <option value="" selected disabled>Select Subcategory</option>
                                                        <!-- Options will be populated dynamically based on the selected category -->
                                                    </select>
                                                    <span class="text-danger error" id="subCategoryNameError"></span>
                                                </div>
                                                <div class="form-group">
                                                    <label for="productName">Product:</label>
                                                    <select class="form-control" id="productName" name="product_name">
                                                        <option value="" selected disabled>Select Product</option>
                                                        <!-- Options will be populated dynamically based on the selected subcategory -->
                                                    </select>
                                                    <span class="text-danger error" id="productNameError"></span>
                                                </div>
                                                <div class="form-group">
                                                    <label for="specificationName">Specification:</label>
                                                    <select class="form-control" id="specificationName"
                                                        name="specification_name">
                                                        <option value="" selected disabled>Select Specification</option>
                                                        <!-- Options will be populated dynamically based on the selected product -->
                                                    </select>
                                                    <span class="text-danger error" id="specificationNameError"></span>
                                                </div>
                                                <div class="form-group">
                                                    <label for="specificationDetails">Specification Details:</label>
                                                    <input type="text" class="form-control" id="specificationDetails"
                                                        name="specification_details">
                                                    <span class="text-danger error"
                                                        id="specificationDetailsError"></span>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-info" name="addBtn"
                                                        id="addBtn">Submit</button>
                                                    <button type="button" class="btn btn-info" name="saveBtn"
                                                        style="display: none;" id="saveBtn">Save changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h6>Add Specification Details</h6>
                            </div>
                            <div class="card-body" style="overflow: auto;">
                                <table id="productTable" class="table display table-responsive-md"
                                    style="white-space: nowrap;">
                                    <thead>
                                        <tr>
                                            <td>
                                                <label for="">
                                                    <input type="checkbox"
                                                        style="width: 20px; height: 20px; cursor: pointer;"
                                                        name="checkAllCheckbox" id="checkAllCheckbox">
                                                </label>
                                            </td>
                                            <td>
                                                <label for="">Sl. No.</label>
                                            </td>
                                            <td>
                                                <label for="">Category Name</label>
                                            </td>
                                            <td>
                                                <label for="">Sub Catgeory Name</label>
                                            </td>
                                            <td>
                                                <label for="">Product Image</label>
                                            </td>
                                            <td>
                                                <label for="">Product name</label>
                                            </td>
                                            <td>
                                                <label for="">Specification</label>
                                            </td>
                                            <td>
                                                <label for="">Specification detail</label>
                                            </td>
                                            <td>
                                                <label for="">Created at</label>
                                            </td>
                                            <td>
                                                <label for="">Updated at</label>
                                            </td>
                                            <td>
                                                <label for="">Action</label>
                                            </td>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <button class="btn btn-danger font-weight-bold" type="button" name="deleteAllBtn"
                                    id="deleteAllBtn" disabled><i class="fa-solid fa-trash me-2"></i>
                                    Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php require_once ('include/footer/footer.php'); ?>
        </div>
    </div>
    </div>
    <?php require_once ('include/base/scripts.php'); ?>

    <script src="js/multiple_checkbox.js"></script>
    <script src="js/specification_details.js"></script>
    <script src="js/filter.js"></script>
</body>

</html>