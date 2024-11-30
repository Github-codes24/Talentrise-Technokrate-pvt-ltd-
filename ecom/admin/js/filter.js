$(document).ready(function () {
  const ajaxHandler = new AjaxRequest();

  $("#categoryName").on("change", function () {
    let catId = $("#categoryName").val();

    const data = {
      category: catId,
      process: "GET_SUB_CAT",
    };

    let spinner =
      '<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden"></span></div>';

    $("#subCategoryName")
      .prop("disabled", true)
      .html(`<option>Please wait...${spinner}</option>`);

    ajaxHandler.postJson(
      "ajax/filter.php",
      data,
      function (response) {
        if (response.subcategories && response.subcategories.length > 0) {
          let optionsHtml =
            '<option value="" selected disabled>Select</option>';
          let selectedSubCategory = response.selected_sub_category || "";

          response.subcategories.forEach(function (item) {
            let isSelected =
              item.subcategory_id == selectedSubCategory ? "selected" : "";
            optionsHtml += `<option value="${
              item.subcategory_id
            }" ${isSelected}>${item.subcategory_name.replace(
              /\\/g,
              ""
            )}</option>`;
          });

          $("#subCategoryName").prop("disabled", false).html(optionsHtml);
        } else {
          $("#subCategoryName").prop("disabled", false).html("Select");
        }
      },
      function (error) {
        showAlert("Something went wrong!", "error");
      }
    );
  });

  /* sub category name start */
  $(document).on("change", "#subCategoryName", function () {
    let catId = $("#categoryName").val();
    let subCatId = $("#subCategoryName").val();

    const data = {
      category: catId,
      sub_category: subCatId,
      process: "GET_PRODUCT",
    };

    let spinner =
      '<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden"></span></div>';

    $("#productName")
      .prop("disabled", true)
      .html(`<option>Please wait...${spinner}</option>`);

    ajaxHandler.postJson(
      "ajax/filter.php",
      data,
      function (response) {
        if (response.products && response.products.length > 0) {
          let optionsHtml =
            '<option value="" selected disabled>Select</option>';
          let selectedProduct = response.selected_product || "";

          response.products.forEach(function (item) {
            let isSelected =
              item.product_id == selectedProduct ? "selected" : "";
            optionsHtml += `<option value="${
              item.product_id
            }" ${isSelected}>${item.product_name.replace(/\\/g, "")}</option>`;
          });

          $("#productName").prop("disabled", false).html(optionsHtml);
        } else {
          $("#productName").prop("disabled", false).html("Select");
        }
      },
      function (error) {
        $("#productName").prop("disabled", false).html("Select");
        showAlert("Something went wrong!", "error");
      }
    );
  });

  /* sub category name end */

  /* product name start */
  $(document).on("change", "#productName", function () {
    let catId = $("#categoryName").val();
    let subCatId = $("#subCategoryName").val();
    let productId = $("#productName").val();

    const data = {
      category: catId,
      sub_category: subCatId,
      product_id: productId,
      process: "GET_SPECIFICATION",
    };

    let spinner =
      '<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden"></span></div>';

    $("#specificationName")
      .prop("disabled", true)
      .html(`<option>Please wait...${spinner}</option>`);

    ajaxHandler.postJson(
      "ajax/filter.php",
      data,
      function (response) {
        if (response.specification && response.specification.length > 0) {
          let optionsHtml =
            '<option value="" selected disabled>Select</option>';
          let selectedSpecification = response.selected_specification || "";

          response.specification.forEach(function (item) {
            let isSelected =
              item.specification_id == selectedSpecification ? "selected" : "";
            optionsHtml += `<option value="${
              item.list_id
            }" ${isSelected}>${item.list_name.replace(/\\/g, "")}</option>`;
          });

          $("#specificationName").prop("disabled", false).html(optionsHtml);
        } else {
          $("#specificationName").prop("disabled", false).html("Select");
        }
      },
      function (error) {
        $("#specificationName").prop("disabled", false).html("Select");
        showAlert("Something went wrong!", "error");
      }
    );
  });

  /* product name end */
});
