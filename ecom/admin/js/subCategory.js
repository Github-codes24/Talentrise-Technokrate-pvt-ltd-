/* generate table  */
function generateTable(data) {
  // Clear existing table body
  $("#subCategoryTable tbody").empty();

  // Iterate over data to create rows
  $.each(data, function (index, item) {
    let row = "<tr>";
    row += `<td class="text-center"><input type="checkbox" class="row-checkbox checkbox" value="${item.subcategory_id}" style="width: 20px; height: 20px; cursor: pointer;"></td>`;
    row += `<td class="text-center">${index + 1}</td>`;
    row += `<td class="text-center">${item.category_name.replace(
      /\\/g,
      ""
    )}</td>`;
    row += `<td class="text-center"><img src="images/products/sub_categories/thumb-50/${item.sub_category_image}" alt="${item.subcategory_name}" style="width: 50px; height: 50px;"></td>`;
    row += `<td>${item.subcategory_name.replace(/\\/g, "")}</td>`;
    row += `<td class="text-center">${formatDate(item.created_at)}</td>`;
    row += `<td class="text-center">${formatDate(item.updated_at)}</td>`;
    row += "<td class='text-center d-flex'>";
    row += `<button class="btn btn-info btn-sm mx-1 editBtn" value="${
      item.subcategory_id
    }" data-category="${
      item.category_id
    }" data-categorySName = "${item.subcategory_name.replace(
      /\\/g,
      ""
    )}" data-catImage="${
      item.sub_category_image
    }"><i class="fa-solid fa-pen-to-square"></i></button> `;
    row += `<button class="btn btn-danger btn-sm mx-1 deleteBtn" value="${item.subcategory_id}"><i class="fa-solid fa-trash"></i></button>`;
    row += "</td>";
    row += "</tr>";

    $("#subCategoryTable tbody").append(row);
  });

  // Initialize or reinitialize DataTable after data is populated
  if ($.fn.DataTable.isDataTable("#subCategoryTable")) {
    $("#subCategoryTable").DataTable().clear().destroy();
  }

  $("#subCategoryTable").DataTable({
    processing: true,
    serverSide: false,
    searching: true,
    paging: true,
    info: true,
    autoWidth: false,
  });
}

$(document).ready(function () {
  const ajaxHandler = new AjaxRequest();

  function loadData() {
    const data = {
      process: "GET_DATA",
    };

    let spinner =
      '<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden"></span></div>';

    $("#subCategoryTable tbody").html(
      `<tr><td class="text-center" colspan="8">Please wait...${spinner}</td></tr>`
    );

    ajaxHandler.postJson(
      "ajax/sub_category.php",
      data,
      function (response) {
        if (response.length > 0) {
          generateTable(response);
        } else {
          $("#subCategoryTable tbody").html(
            `<tr><td class="text-center" colspan="8">Sorry, No Data Available!😢</td></tr>`
          );
          showAlert("Failed to load data!", "error");
        }
      },
      function (error) {
        showAlert("Something went wrong!", "error");
        // console.error("Error:", error);
      }
    );
  }
  loadData();

  /* validate sub category form start */
  /* validate add subcategory form start */
  const subCategoryForm = document.getElementById("categoryForm");
  const categoryName = document.getElementById("categoryName");
  const subCategoryName = document.getElementById("subCategoryName");
  const subCategoryImage = document.getElementById("subCategoryImage");
  const addSubCategoryButton = document.getElementById("addBtn");
  const saveSubCategoryButton = document.getElementById("saveBtn");
  const categoryNameError = document.getElementById("categoryNameError");
  const subCategoryNameError = document.getElementById("subCategoryNameError");
  const subCategoryImageError = document.getElementById(
    "subCategoryImageError"
  );

  let isValidate = false;

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

  // Add keyup event listeners to all input fields
  categoryName.addEventListener("change", () =>
    validateField(categoryName, categoryNameError, "Category name is required")
  );
  subCategoryName.addEventListener("keyup", () =>
    validateField(
      subCategoryName,
      subCategoryNameError,
      "Subcategory name is required"
    )
  );

  // Add change event listener to the image field
  subCategoryImage.addEventListener("change", () => {
    const allowedExtensions = ["jpg", "jpeg", "png"];
    const fileName = subCategoryImage.value;
    if (fileName) {
      const extension = fileName.split(".").pop().toLowerCase();
      if (!allowedExtensions.includes(extension)) {
        subCategoryImage.classList.add("border-danger");
        subCategoryImageError.textContent =
          "Invalid image format. Only JPG, JPEG, and PNG allowed.";
      } else {
        subCategoryImage.classList.remove("border-danger");
        subCategoryImageError.textContent = "";
      }
    }
  });

  // Add submit event listener to the form
  addSubCategoryButton.addEventListener("click", () => {
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
        subCategoryImage,
        subCategoryImageError,
        "Subcategory image is required"
      );

    if (isValid) {
      let categoryId = $("#categoryName").val();
      let subCategoryName = $("#subCategoryName").val();
      let subCategoryImage = $("#subCategoryImage")[0].files[0]; // Get the file object

      const formData = new FormData();
      formData.append("cat_id", categoryId);
      formData.append("sub_cat_name", subCategoryName);
      formData.append("image", subCategoryImage);
      formData.append("process", "INSERT_SUBCATEGORY_DATA");

      let spinner =
        '<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden"></span></div>';

      $("#addBtn").prop("disabled", true).html(`Please wait...${spinner}`);

      $.ajax({
        url: "ajax/sub_category.php",
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

  /* validate sub category form end */

  /* code for edit button start */
  $(document).on("click", ".editBtn", function () {
    $("#saveBtn").show();
    $("#addBtn").hide();
    $("#addNewCategoryModalLabel").html("Edit Sub Category");
    $("#addNewCategoryModal").modal("show");

    let category = $(this).attr("data-category");
    let subCategory = $(this).attr("data-categorySName");
    let subCategoryImage = $(this).attr("data-catimage");
    let category_id = $(this).val();

    $("#categoryName").val(category);
    $("#subCategoryName").val(subCategory);
    $("#imageContainer").show();
    $("#imageContainer img").attr(
      "src",
      `images/products/sub_categories/thumb-50/${subCategoryImage}`
    );
    $("#saveBtn").val(category_id);
  });

  /* code for edit button end */

  /* code for add button start */
  $(document).on("click", "#openModalBtn", function () {
    $("#addBtn").show();
    $("#saveBtn").hide();
    $("#addNewCategoryModalLabel").html("Add New Category");
    $("#imageContainer").hide();

    $("#categoryName").val("");
    $("#subCategoryName").val("");
    $("#subCategoryImage").val("");
  });

  /* code for add button end */

  /* code for update button start */
  $(document).on("click", "#saveBtn", function () {
    let categoryId = $("#categoryName").val();
    let subCategoryName = $("#subCategoryName").val();
    let subCategoryImage = $("#subCategoryImage")[0].files[0]; // Get the file object

    let subCategoryId = $("#saveBtn").val();

    const formData = new FormData();
    formData.append("cat_id", categoryId);
    formData.append("sub_cat_name", subCategoryName);
    formData.append("image", subCategoryImage);
    formData.append("id", subCategoryId);

    formData.append("process", "UPDATE_DATA");

    let spinner =
      '<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden"></span></div>';

    $("#saveBtn").prop("disabled", true).html(`Please wait...${spinner}`);

    $.ajax({
      url: "ajax/sub_category.php",
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

  /* code for delete button start */
  $(document).on("click", ".deleteBtn", function () {
    let category_id = $(this).val();
    let row = $(this).closest("tr");

    showConfirm(
      "Are you sure you want to delete this sub category?",
      () => {
        let process = "DELETE_DATA";

        const postData = {
          id: category_id,
          process: process,
        };

        ajaxHandler.postJson(
          "ajax/sub_category.php",
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
  $("#checkAllCheckbox").on("change", function () {
    $(".checkbox").prop("checked", $(this).prop("checked"));
    toggleButtonState("#subCategoryTable", "#deleteAllBtn");
  });

  $(document).on("change", ".checkbox", function () {
    checkAllCheckboxStatus();
    toggleButtonState("#subCategoryTable", "#deleteAllBtn");
  });
  /* =========code for enabled and disabled restore all button end========= */
  /* code for delete multiples items start */
  $(document).on("click", "#deleteAllBtn", function () {
    let table = $("#subCategoryTable");
    let checkedValues = getCheckedCheckboxValues(table);

    showConfirm(
      "Are you sure you want to delete these sub categories?",
      () => {
        let process = "DELETE_ALL_DATA";

        const postData = {
          id: checkedValues,
          process: process,
        };

        ajaxHandler.postJson(
          "ajax/sub_category.php",
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
