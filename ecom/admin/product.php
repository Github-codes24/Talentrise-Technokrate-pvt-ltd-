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
                                    <h6><i class="fa-solid fa-layer-group"></i> Products</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <button type="button" class="btn btn-info my-2" data-toggle="modal"
                                data-target="#addNewProductModal" name="openModalBtn" id="openModalBtn">
                                <i class="fa-solid fa-plus"></i> Add New
                            </button>

                            <div class="modal fade" id="addNewProductModal" tabindex="-1" role="dialog"
                                aria-labelledby="addNewProductModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title" id="addNewProductModalLabel">Add New Product
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form id="productForm" method="POST" enctype="multipart/form-data">
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
                                                    <select class="form-control" id="subCategoryName"
                                                        name="sub_category_name">

                                                    </select>
                                                    <span class="text-danger error" id="subCategoryNameError"></span>
                                                </div>
                                                <div class="form-group">
                                                    <label for="productName">Product Name:</label>
                                                    <input type="text" class="form-control" id="productName"
                                                        name="product_name">
                                                    <span class="text-danger error" id="productNameError"></span>
                                                </div>
                                                <div class="form-group" style="display: none;" id="imageContainer">
                                                    <img src="" alt="ProductImage" width="50px" height="50px">
                                                </div>
                                                <div class="form-group">
                                                    <label for="productImage">Product Image:</label>
                                                    <input type="file" class="form-control" id="productImage"
                                                        name="product_image" accept="image/*">
                                                    <span class="text-danger error" id="productImageError"></span>
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
                                    <h6>Add Product</h6>
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
            </div>
            <?php require_once ('include/footer/footer.php'); ?>
        </div>
    </div>
    <?php require_once ('include/base/scripts.php'); ?>

    <script src="js/multiple_checkbox.js"></script>
    <script src="js/products.js"></script>
    <script>
        $(document).ready(function () {
            /* code for delete button start */
            $(document).on("click", ".deleteBtn", function () {
                let product_id = $(this).val();
                let row = $(this).closest("tr");

                showConfirm(
                    "Are you sure you want to delete this product?",
                    () => {
                        let process = "DELETE_DATA";

                        const postData = {
                            id: product_id,
                            process: process,
                        };

                        ajaxHandler.postJson(
                            "ajax/product.php?process=DELETE_DATA",
                            postData,
                            function (response) {
                                if (response.status == "success") {
                                    // Apply fade-up animation
                                    row.addClass("fade-up");

                                    // Wait for the animation to complete (500ms) before removing the row
                                    setTimeout(() => {
                                        row.remove();
                                        showAlert(`${response.message}`, "success");
                                    }, 500);

                                    setTimeout(() => {
                                        location.reload();
                                    }, 1000);
                                } else {
                                    showAlert(`${response.message}`, "error");
                                }
                            },
                            function (error) {
                                // Handle error response
                                console.error("An error occurred:", error);
                                showAlert("An error occurred While deleting the record", "error");
                            }
                        );
                    },
                    () => {
                        console.log("Delete canceled");
                    }
                );
            });

            /* code for delete button end */

            /* =========code for enabled and disabled restore all button start========= */
            $(document).on("change", "#checkAllCheckbox", function () {
                $(".checkbox").prop("checked", $(this).prop("checked"));
                toggleButtonState("#productTable", "#deleteAllBtn");
            });

            // Handle change event on dynamically generated .checkbox elements using event delegation
            $(document).on("change", ".checkbox", function () {
                checkAllCheckboxStatus();
                toggleButtonState("#productTable", "#deleteAllBtn");
            });
            /* =========code for enabled and disabled restore all button end========= */
            /* code for delete multiples items start */
            $(document).on("click", "#deleteAllBtn", function () {
                let table = $("#productTable");
                let checkedValues = getCheckedCheckboxValues(table);

                showConfirm(
                    "Are you sure you want to delete these products?",
                    () => {
                        let process = "DELETE_ALL_DATA";

                        const postData = {
                            id: checkedValues,
                            process: process,
                        };

                        ajaxHandler.postJson(
                            "ajax/product.php?process=DELETE_ALL_DATA",
                            postData,
                            function (response) {
                                if (response.status == "success") {
                                    // Apply fade-up animation to each selected row
                                    checkedValues.forEach((value) => {
                                        let row = table
                                            .find(`.checkbox[value="${value}"]`)
                                            .closest("tr");
                                        row.addClass("fade-up");

                                        // Wait for the animation to complete (500ms) before removing the row
                                        setTimeout(() => {
                                            row.remove();
                                        }, 500); // Duration of the fade-up animation
                                    });
                                    showAlert(`${response.message}`, "success");
                                    setTimeout(() => {
                                        location.reload();
                                    }, 1000);
                                } else {
                                    showAlert(`${response.message}`, "error");
                                }
                            },
                            function (error) {
                                // Handle error response
                                console.error("An error occurred:", error);
                                showAlert(
                                    "An error occurred while deleting the records",
                                    "error"
                                );
                            }
                        );
                    },
                    () => {
                        console.log("Delete canceled");
                    }
                );
            });
            /* code for delete multiples items end */
        });
    </script>
    <script src="js/filter.js"></script>
</body>

</html>