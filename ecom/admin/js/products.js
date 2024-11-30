const ajaxHandler = new AjaxRequest();

function reloadTable() {
  $("#productTable").DataTable().ajax.reload();
}

$(document).ready(function () {
  $("#productTable").DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url: "ajax/product.php",
      type: "GET",
      data: function (d) {
        d.process = "GET_DATA";
      },
      dataSrc: function (json) {
        return json.data;
      },
    },
    pageLength: 10,
    lengthMenu: [5, 10, 20, 50, 100, 200, 500],
    dom: "Bfrtip",
    responsive: true,
    buttons: ["copy", "csv", "excel", "pdf", "print"],
    language: {
      processing: "Loading data, please wait...", // Custom processing message
    },
    columns: [
      {
        data: "product_id",
        className: "text-center",
        render: function (data, type, row) {
          return `<input type="checkbox" class="row-checkbox checkbox" value="${data}" style="width: 20px; height: 20px; cursor: pointer;">`;
        },
      },
      {
        data: null,
        className: "text-center",
        render: function (data, type, row, meta) {
          return meta.row + 1;
        },
      },
      { data: "category_name", className: "text-center" },
      { data: "subcategory_name", className: "text-center" },
      {
        data: "product_image",
        className: "text-center",
        render: function (data, type, row) {
          return `<img src="images/products/product_images/thumb-50/${data}" alt="${row.product_name}" style="width: 50px; height: 50px;">`;
        },
      },
      { data: "product_name", className: "text-center" },
      {
        data: "created_at",
        className: "text-center",
        render: function (data) {
          return formatDate(data);
        },
      },
      {
        data: "updated_at",
        className: "text-center",
        render: function (data) {
          return formatDate(data);
        },
      },
      {
        data: null,
        className: "text-center d-flex",
        render: function (data, type, row) {
          return `<button class="btn btn-info btn-sm mx-1 editBtn" value="${row.product_id}" data-category="${row.category_id}" data-subcategory="${row.subcategory_id}" data-image="${row.product_image}" data-product="${row.product_name}"><i class="fa-solid fa-pen-to-square"></i></button> 
                <button class="btn btn-danger btn-sm mx-1 deleteBtn" value="${row.product_id}"><i class="fa-solid fa-trash"></i></button>`;
        },
      },
    ],
    order: [[0, "desc"]], // Default order by product_id in descending order
    paging: true,
    lengthChange: false,
    searching: true,
    ordering: true,
    info: true,
    autoWidth: false,
  });

  // If you have filter forms
  $("#purposeFilter").on("submit", function (e) {
    e.preventDefault();
    reloadTable();
  });

  $("#dateform").on("submit", function (e) {
    e.preventDefault();
    reloadTable();
  });

  /* code for insert data start */

  // validate product form start
  const productForm = document.getElementById("productForm");
  const categoryName = document.getElementById("categoryName");
  const subCategoryName = document.getElementById("subCategoryName");
  const productName = document.getElementById("productName");
  const productImage = document.getElementById("productImage");
  const addProductButton = document.getElementById("addBtn");
  const categoryNameError = document.getElementById("categoryNameError");
  const subCategoryNameError = document.getElementById("subCategoryNameError");
  const productNameError = document.getElementById("productNameError");
  const productImageError = document.getElementById("productImageError");

  // Function to validate a field and display/hide error message
  function validateField(field, errorElement, errorMessage) {
    if (field.value.trim() === "") {
      field.classList.add("border-danger");
      errorElement.textContent = errorMessage;
      return false;
    } else {
      field.classList.remove("border-danger");
      errorElement.textContent = "";
      return true;
    }
  }

  // Add change event listeners to category and subcategory fields
  categoryName.addEventListener("change", () =>
    validateField(categoryName, categoryNameError, "Category name is required")
  );
  subCategoryName.addEventListener("change", () =>
    validateField(
      subCategoryName,
      subCategoryNameError,
      "Subcategory name is required"
    )
  );

  // Add keyup event listeners to product name field
  productName.addEventListener("keyup", () =>
    validateField(productName, productNameError, "Product name is required")
  );

  // Add change event listener to the product image field
  productImage.addEventListener("change", () => {
    const allowedExtensions = ["jpg", "jpeg", "png"];
    const fileName = productImage.value;
    if (fileName) {
      const extension = fileName.split(".").pop().toLowerCase();
      if (!allowedExtensions.includes(extension)) {
        productImage.classList.add("border-danger");
        productImageError.textContent =
          "Invalid image format. Only JPG, JPEG, and PNG allowed.";
      } else {
        productImage.classList.remove("border-danger");
        productImageError.textContent = "";
      }
    }
  });

  // Add submit event listener to the form
  addProductButton.addEventListener("click", () => {
    // Perform validation and update isValid flag
    isValid =
      validateField(
        categoryName,
        categoryNameError,
        "Category name is required"
      ) &&
      validateField(
        subCategoryName,
        subCategoryNameError,
        "Subcategory name is required"
      ) &&
      validateField(
        productName,
        productNameError,
        "Product name is required"
      ) &&
      validateField(
        productImage,
        productImageError,
        "Product image is required"
      );

    if (isValid) {
      let categoryId = $("#categoryName").val();
      let subCategoryId = $("#subCategoryName").val();
      let productName = $("#productName").val();
      let productImage = $("#productImage")[0].files[0]; // Get the file object

      const formData = new FormData();
      formData.append("category_id", categoryId);
      formData.append("sub_category_id", subCategoryId);
      formData.append("product_name", productName);
      formData.append("image", productImage);
      // formData.append("process", "INSERT_PRODUCT_DATA");

      let spinner =
        '<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden"></span></div>';

      $("#addBtn").prop("disabled", true).html(`Please wait...${spinner}`);

      $.ajax({
        url: "ajax/product.php?process=INSERT_PRODUCT_DATA",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
          $("#addBtn").prop("disabled", false).html("Submit");

          if (response.status == "success") {
            showAlert(`${response.message}`, `${response.status}`);
            setTimeout(function () {
              location.reload();
            }, 1000);
          } else {
            showAlert(`${response.message}`, `${response.status}`);
          }
        },
        error: function (error) {
          $("#addBtn").prop("disabled", false).html("Submit");

          showAlert("Something went wrong!", "error");
          // console.error("Error:", error);
        },
      });
    } else {
      showAlert("Please fix errors before submitting the form.", "error");
    }
  });

  // validate product form end

  /* code for insert data end  */

  /* code for edit button start */
  $(document).on("click", ".editBtn", function () {
    $("#saveBtn").show();
    $("#addBtn").hide();
    $("#addNewProductModalLabel").html("Edit Sub Category");
    $("#addNewProductModal").modal("show");

    let category = $(this).attr("data-category");
    let subCategory = $(this).attr("data-subcategory");
    let product_name = $(this).attr("data-product");
    let product_image = $(this).attr("data-image");
    let product_id = $(this).val();

    $("#categoryName").val(category);
    $("#subCategoryName").val(subCategory);
    $("#productName").val(product_name);
    $("#imageContainer").show();
    $("#imageContainer img").attr(
      "src",
      `images/products/product_images/thumb-50/${product_image}`
    );
    $("#saveBtn").val(product_id);

    const data = {
      category: category,
      sub_category: subCategory,
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
          $("#subCategoryName")
            .prop("disabled", false)
            .html('<option value="" selected disabled>Select</option>');
        }
      },
      function (error) {
        showAlert("Something went wrong!", "error");
      }
    );
  });
  /* code for edit button end */

  /* code for add button start */
  $(document).on("click", "#openModalBtn", function () {
    $("#addBtn").show();
    $("#saveBtn").hide();
    $("#addNewProductModalLabel").html("Add New Category");

    $("#categoryName").val("");
    $("#subCategoryName").html("");
    $("#productName").val("");
    $("#productImage").val("");
    $("#imageContainer").hide();
  });

  /* code for add button end */

  /* code for update button start */
  $(document).on("click", "#saveBtn", function () {
    let categoryId = $("#categoryName").val();
    let subCategoryId = $("#subCategoryName").val();
    let productName = $("#productName").val();
    let productImage = $("#productImage")[0].files[0]; // Get the file object
    let productId = $("#saveBtn").val();

    const formData = new FormData();
    formData.append("category_id", categoryId);
    formData.append("sub_category_id", subCategoryId);
    formData.append("product_name", productName);
    formData.append("image", productImage);
    formData.append("product_id", productId);

    let spinner =
      '<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden"></span></div>';

    $("#saveBtn").prop("disabled", true).html(`Please wait...${spinner}`);

    $.ajax({
      url: "ajax/product.php?process=UPDATE_DATA",
      type: "POST",
      data: formData,
      contentType: false, // Prevent jQuery from setting Content-Type header
      processData: false, // Prevent jQuery from processing the data
      success: function (response) {
        $("#saveBtn").prop("disabled", false).html("Save changes");

        if (response.status == "success") {
          showAlert(`${response.message}`, `${response.status}`);
          setTimeout(function () {
            location.reload();
          }, 1000);
        } else {
          showAlert(`${response.message}`, `${response.status}`);
        }
      },
      error: function (error) {
        $("#saveBtn").prop("disabled", false).html("Save changes");

        showAlert("Something went wrong!", "error");
      },
    });
    });
  /* code for update button end */
 
});
