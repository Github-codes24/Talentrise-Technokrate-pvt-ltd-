<?php
require_once ('../config/connection.inc.php');
require_once ('auth.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $site_name; ?> | Sub Categories</title>
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
                                    <h6><i class="fa-solid fa-layer-group"></i> Sub Categories</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <button type="button" class="btn btn-info my-2" data-toggle="modal"
                                data-target="#addNewCategoryModal" name="openModalBtn" id="openModalBtn">
                                <i class="fa-solid fa-plus"></i> Add New
                            </button>

                            <div class="modal fade" id="addNewCategoryModal" tabindex="-1" role="dialog"
                                aria-labelledby="addNewCategoryModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title" id="addNewCategoryModalLabel">Add New Sub Category
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form id="categoryForm" method="POST" enctype="multipart/form-data">
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="categoryName">Category Name:</label>
                                                    <select class="form-control" name="category_name" id="categoryName">
                                                        <option value="" selected disabled>Select</option>
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
                                                    <label for="subCategoryName">Sub category Name:</label>
                                                    <input type="text" class="form-control" id="subCategoryName"
                                                        name="sub_category_name">
                                                    <span class="text-danger error" id="subCategoryNameError"></span>
                                                </div>
                                                <div class="form-group" style="display: none;" id="imageContainer">
                                                    <img src="" alt="SubcategorytImage" width="50px" height="50px">
                                                </div>
                                                <div class="form-group">
                                                    <label for="subCategoryImage">Sub Category Image:</label>
                                                    <input type="file" class="form-control" id="subCategoryImage"
                                                        name="sub_category_image" accept="image/*">
                                                    <span class="text-danger error" id="subCategoryImageError"></span>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-info" name="addBtn"
                                                    id="addBtn">Submit</button>
                                                <button type="button" class="btn btn-info" name="saveBtn"
                                                    style="display: none;" id="saveBtn">Save
                                                    changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>


                            <div class="card">
                                <div class="card-header">
                                    <h6>Add Sub Category</h6>
                                </div>
                                <div class="card-body" style="overflow: auto;">
                                    <table id="subCategoryTable" class="table display table-responsive-md"
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
                                                    <label for="">Sub Catgeory Image</label>
                                                </td>
                                                <td>
                                                    <label for="">Sub Category Name</label>
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
                                        <tbody id="categoryTable">

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
            </div>
            <?php require_once ('include/footer/footer.php'); ?>
        </div>
    </div>
    <?php require_once ('include/base/scripts.php'); ?>

    <script src="js/multiple_checkbox.js"></script>
    <script src="js/subCategory.js"></script>
</body>

</html>