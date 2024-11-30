const ajaxHandler = new AjaxRequest();

$(document).ready(function () {
  /* code for insert data start */
  /* validate add specialization form start */
  const specCategoryName = document.getElementById("categoryName");
  const specSubCategoryName = document.getElementById("subCategoryName");
  const productName = document.getElementById("productName");
  const specializationName = document.getElementById("specializationName");
  const addSpecButton = document.getElementById("addBtn");
  const specCategoryNameError = document.getElementById("categoryNameError");
  const specSubCategoryNameError = document.getElementById(
    "subCategoryNameError"
  );
  const productNameError = document.getElementById("productNameError");
  const specializationNameError = document.getElementById(
    "specializationNameError"
  );

  let isSpecValid = false;

  // Function to validate a field and display/hide error message
  function validateSpecField(field, errorElement, errorMessage) {
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

  // Add change event listeners to all input fields
  specCategoryName.addEventListener("change", () =>
    validateSpecField(
      specCategoryName,
      specCategoryNameError,
      "Category name is required"
    )
  );
  specSubCategoryName.addEventListener("change", () =>
    validateSpecField(
      specSubCategoryName,
      specSubCategoryNameError,
      "Subcategory name is required"
    )
  );
  productName.addEventListener("change", () =>
    validateSpecField(productName, productNameError, "Product name is required")
  );
  specializationName.addEventListener("keyup", () =>
    validateSpecField(
      specializationName,
      specializationNameError,
      "Specialization name is required"
    )
  );

  // Add submit event listener to the form
  addSpecButton.addEventListener("click", () => {
    // Perform validation and update isSpecValid flag
    isSpecValid =
      validateSpecField(
        specCategoryName,
        specCategoryNameError,
        "Category name is required"
      ) &&
      validateSpecField(
        specSubCategoryName,
        specSubCategoryNameError,
        "Subcategory name is required"
      ) &&
      validateSpecField(
        productName,
        productNameError,
        "Product name is required"
      ) &&
      validateSpecField(
        specializationName,
        specializationNameError,
        "Specialization name is required"
      );

    if (isSpecValid) {
      let categoryId = $("#categoryName").val();
      let subCategoryId = $("#subCategoryName").val();
      let productNameVal = $("#productName").val();
      let specializationNameVal = $("#specializationName").val();

      const formData = new FormData();
      formData.append("category_id", categoryId);
      formData.append("subcategory_id", subCategoryId);
      formData.append("product_name", productNameVal);
      formData.append("specialization_name", specializationNameVal);
      formData.append("process", "INSERT_SPECIALIZATION_DATA");

      let spinner =
        '<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden"></span></div>';

      $("#addBtn").prop("disabled", true).html(`Please wait...${spinner}`);

      $.ajax({
        url: "ajax/specification_list.php?process=INSERT_SPECIALIZATION_DATA",
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

  /* code for insert data end */

  /* code for fetch data start */

  $("#productTable").DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url: "ajax/specification_list.php",
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
          return `<input type="checkbox" class="row-checkbox checkbox" value="${row.list_id}" style="width: 20px; height: 20px; cursor: pointer;">`;
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
      { data: "list_name", className: "text-center" },
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
          return `<button class="btn btn-info btn-sm mx-1 editBtn" value="${row.list_id}" data-category="${row.category_id}" data-subcategory="${row.subcategory_id}" data-image="${row.product_image}" data-product="${row.product_id}" data-specification="${row.list_name}"><i class="fa-solid fa-pen-to-square"></i></button> 
                    <button class="btn btn-danger btn-sm mx-1 deleteBtn" value="${row.list_id}"><i class="fa-solid fa-trash"></i></button>`;
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

  function reloadTable() {
    $("#productTable").DataTable().ajax.reload();
  }

  /* code for fetch data end */

  /* code for add button start */
  $(document).on("click", "#openModalBtn", function () {
    $("#addBtn").show();
    $("#saveBtn").hide();
    $("#addNewSpecializationModalLabel").html("Add New Specification");

    $("#categoryName").val("");
    $("#subCategoryName").val("");
    $("#productName").val("");
    $("#specializationName").val("");
  });

  /* code for add button end */

  /* code for edit button start */
  $(document).on("click", ".editBtn", function () {
    $("#saveBtn").show();
    $("#addBtn").hide();
    $("#addNewSpecializationModalLabel").html("Edit Specification");
    $("#addNewSpecializationModal").modal("show");

    let category = $(this).attr("data-category");
    let subCategory = $(this).attr("data-subcategory");
    let product = $(this).attr("data-product");
    let specification = $(this).attr("data-specification");

    let list_id = $(this).val();

    /* code for fetch sub category */
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

    /* code for fetch product name */
    const productData = {
      category: category,
      sub_category: subCategory,
      product_id: product,
      process: "GET_PRODUCT",
    };

    $("#productName")
      .prop("disabled", true)
      .html(`<option>Please wait...${spinner}</option>`);

    ajaxHandler.postJson(
      "ajax/filter.php",
      productData,
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
          $("#productName")
            .prop("disabled", false)
            .html(
              '<option value="" selected disabled>No products available</option>'
            );
        }
      },
      function (error) {
        $("#productName")
          .prop("disabled", false)
          .html('<option value="" selected disabled>Select</option>');
        showAlert("Something went wrong!", "error");
      }
    );

    $("#categoryName").val(category);
    $("#subCategoryName").val(subCategory);
    $("#productName").val(product);
    $("#specializationName").val(specification);

    $("#saveBtn").val(list_id);
  });

  /* code for edit button end */

  /* code for save or update button start */
  $(document).on("click", "#saveBtn", function () {
    let categoryId = $("#categoryName").val();
    let subCategoryId = $("#subCategoryName").val();
    let productName = $("#productName").val();
    let specializationName = $("#specializationName").val();

    let list_id = $(this).val();

    const formData = new FormData();
    formData.append("category_id", categoryId);
    formData.append("sub_category_id", subCategoryId);
    formData.append("product_id", productName);
    formData.append("specialization_name", specializationName);
    formData.append("list_id", list_id);

    let spinner =
      '<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden"></span></div>';

    $("#saveBtn").prop("disabled", true).html(`Please wait...${spinner}`);

    $.ajax({
      url: "ajax/specification_list.php?process=UPDATE_DATA",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
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

  /* code for save or update button end */

  /* code for delete button start */
  $(document).on("click", ".deleteBtn", function () {
    let list_id = $(this).val();
    let row = $(this).closest("tr");

    showConfirm(
      "Are you sure you want to delete this product?",
      () => {
        let process = "DELETE_DATA";

        const postData = {
          id: list_id,
          process: process,
        };

        ajaxHandler.postJson(
          "ajax/specification_list.php?process=DELETE_DATA",
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
          "ajax/specification_list.php?process=DELETE_ALL_DATA",
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
            showAlert("An error occurred while deleting the records", "error");
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
