const specCategoryName = document.getElementById("categoryName");
const specSubCategoryName = document.getElementById("subCategoryName");
const productName = document.getElementById("productName");
const specificationName = document.getElementById("specificationName");
const specificationDetails = document.getElementById("specificationDetails");
const addSpecButton = document.getElementById("addBtn");
const specCategoryNameError = document.getElementById("categoryNameError");
const specSubCategoryNameError = document.getElementById(
  "subCategoryNameError"
);
const productNameError = document.getElementById("productNameError");
const specificationNameError = document.getElementById(
  "specificationNameError"
);
const specificationDetailsError = document.getElementById(
  "specificationDetailsError"
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
specificationName.addEventListener("change", () =>
  validateSpecField(
    specificationName,
    specificationNameError,
    "Specification name is required"
  )
);
specificationDetails.addEventListener("keyup", () =>
  validateSpecField(
    specificationDetails,
    specificationDetailsError,
    "Specification details are required"
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
      specificationName,
      specificationNameError,
      "Specification name is required"
    ) &&
    validateSpecField(
      specificationDetails,
      specificationDetailsError,
      "Specification details are required"
    );

  if (isSpecValid) {
    let categoryId = $("#categoryName").val();
    let subCategoryId = $("#subCategoryName").val();
    let productNameVal = $("#productName").val();
    let specificationNameVal = $("#specificationName").val();
    let specificationDetailsVal = $("#specificationDetails").val();

    const formData = new FormData();
    formData.append("category_id", categoryId);
    formData.append("subcategory_id", subCategoryId);
    formData.append("product_name", productNameVal);
    formData.append("specification_name", specificationNameVal);
    formData.append("specification_details", specificationDetailsVal);
    formData.append("process", "INSERT_DATA");

    let spinner =
      '<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden"></span></div>';

    $("#addBtn").prop("disabled", true).html(`Please wait...${spinner}`);

    $.ajax({
      url: "ajax/specification_details.php?process=INSERT_DATA",
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
      },
    });
  } else {
    showAlert("Please fix errors before submitting the form.", "error");
  }
});

$(document).ready(function () {
  $("#productTable").DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url: "ajax/specification_details.php?process=GET_DATA",
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
          return `<input type="checkbox" class="row-checkbox checkbox" value="${row.detail_id}" style="width: 20px; height: 20px; cursor: pointer;">`;
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
      { data: "details_name", className: "text-center" }, // Added list_details column
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
          return `<button class="btn btn-info btn-sm mx-1 editBtn" value="${row.detail_id}" data-category="${row.category_id}" data-subcategory="${row.subcategory_id}" data-image="${row.product_image}" data-product="${row.product_id}" data-specification="${row.list_name}" data-details="${row.details_name}"><i class="fa-solid fa-pen-to-square"></i></button> 
                          <button class="btn btn-danger btn-sm mx-1 deleteBtn" value="${row.detail_id}"><i class="fa-solid fa-trash"></i></button>`;
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
});
