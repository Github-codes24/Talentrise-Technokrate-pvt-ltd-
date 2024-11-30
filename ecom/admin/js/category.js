/* generate table  */
function generateTable(data) {
  // Clear existing table body
  $("#categoryTable tbody").empty();

  // Iterate over data to create rows
  $.each(data, function (index, item) {
    let row = "<tr>";
    row += `<td class="text-center"><input type="checkbox" class="row-checkbox checkbox" value="${item.category_id}" style="width: 20px; height: 20px; cursor: pointer;"></td>`;
    row += `<td class="text-center">${index + 1}</td>`;
    row += `<td class="text-center"><img src="images/products/categories/thumb-50/${item.category_image}" alt="${item.category_name}" style="width: 50px; height: 50px;"></td>`;
    row += `<td>${item.category_name}</td>`;
    row += `<td>${item.category_short_name}</td>`;
    row += `<td class="text-center">${formatDate(item.created_at)}</td>`;
    row += `<td class="text-center">${formatDate(item.updated_at)}</td>`;
    row += "<td class='text-center d-flex'>";
    row += `<button class="btn btn-info btn-sm mx-1 editBtn" value="${item.category_id}" data-category="${item.category_name}" data-categorySName = "${item.category_short_name}" data-catImage="${item.category_image}"><i class="fa-solid fa-pen-to-square"></i></button> `;
    row += `<button class="btn btn-danger btn-sm mx-1 deleteBtn" value="${item.category_id}"><i class="fa-solid fa-trash"></i></button>`;
    row += "</td>";
    row += "</tr>";

    $("#categoryTable tbody").append(row);
  });

  // Initialize or reinitialize DataTable after data is populated
  if ($.fn.DataTable.isDataTable("#categoryTable")) {
    $("#categoryTable").DataTable().clear().destroy();
  }

  $("#categoryTable").DataTable({
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

    $("#categoryTable tbody").html(
      `<tr><td class="text-center" colspan="8">Please wait...${spinner}</td></tr>`
    );

    ajaxHandler.postJson(
      "ajax/category.php",
      data,
      function (response) {
        if (response.length > 0) {
          generateTable(response);
        } else {
          $("#categoryTable tbody").html(
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

  /* validate add catgeory form start */
  const categoryName = document.getElementById("categoryName");
  const categoryShortName = document.getElementById("categoryShortName");
  const categoryImage = document.getElementById("categoryImage");
  const addCategoryButon = document.getElementById("addBtn");
  const categoryNameError = document.getElementById("categoryNameError");
  const categoryShortNameError = document.getElementById(
    "categoryShortNameError"
  );
  const categoryImageError = document.getElementById("categoryImageError");

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
  categoryName.addEventListener("keyup", () =>
    validateField(categoryName, categoryNameError, "Category name is required")
  );
  categoryShortName.addEventListener("keyup", () =>
    validateField(
      categoryShortName,
      categoryShortNameError,
      "Short name is required"
    )
  );

  // Add change event listener to the image field
  categoryImage.addEventListener("change", () => {
    const allowedExtensions = ["jpg", "jpeg", "png"];
    const fileName = categoryImage.value;
    if (fileName) {
      const extension = fileName.split(".").pop().toLowerCase();
      if (!allowedExtensions.includes(extension)) {
        categoryImage.classList.add("border-danger");
        categoryImageError.textContent =
          "Invalid image format. Only JPG, JPEG, and PNG allowed.";
      } else {
        categoryImage.classList.remove("border-danger");
        categoryImageError.textContent = "";
      }
    }
  });

  // Add submit event listener to the form
  addCategoryButon.addEventListener("click", () => {
    // Perform validation and update isValid flag
    isValid =
      validateField(
        categoryName,
        categoryNameError,
        "Category name is required"
      ) &&
      validateField(
        categoryShortName,
        categoryShortNameError,
        "Short name is required"
      ) &&
      validateField(
        categoryImage,
        categoryImageError,
        "Category image is required"
      );

    if (isValid) {
      let category_name = $("#categoryName").val();
      let category_sname = $("#categoryShortName").val();
      let category_image = $("#categoryImage")[0].files[0]; // Get the file object

      const formData = new FormData();
      formData.append("category", category_name);
      formData.append("category_sname", category_sname);
      formData.append("image", category_image);
      formData.append("process", "INSERT_DATA");

      let spinner =
        '<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden"></span></div>';

      $("#addBtn").prop("disabled", true).html(`Please wait...${spinner}`);

      $.ajax({
        url: "ajax/category.php",
        type: "POST",
        data: formData,
        contentType: false, // Prevent jQuery from setting Content-Type header
        processData: false, // Prevent jQuery from processing the data
        success: function (response) {
          $("#addBtn").prop("disabled", false).html("Add category");

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
          $("#addBtn").prop("disabled", false).html("Add category");

          showAlert("Something went wrong!", "error");
          // console.error("Error:", error);
        },
      });
    } else {
      showAlert("Please fix errors before submitting the form.", "error");
    }
  });

  /* validate add catgeory form end */

  /* code for edit button start */
  $(document).on("click", ".editBtn", function () {
    $("#saveBtn").show();
    $("#addBtn").hide();
    $("#addNewCategoryModalLabel").html("Edit Category");
    $("#addNewCategoryModal").modal("show");

    let category = $(this).attr("data-category");
    let category_sname = $(this).attr("data-categorySName");
    let categoryImage = $(this).attr("data-catimage");
    let category_id = $(this).val();

    $("#categoryName").val(category);
    $("#categoryShortName").val(category_sname);
    $("#imageContainer").show();
    $("#imageContainer img").attr(
      "src",
      `images/products/categories/thumb-50/${categoryImage}`
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

    $('#categoryName').val('');
    $("#categoryShortName").val('');
    $('#categoryImage').val('');
  });

  /* code for add button end */

  /* code for update button start */
  $(document).on("click", "#saveBtn", function () {
    let category_name = $("#categoryName").val();
    let category_sname = $("#categoryShortName").val();
    let category_image = $("#categoryImage")[0].files[0]; // Get the file object
    let categoryId = $("#saveBtn").val();

    const formData = new FormData();
    formData.append("category", category_name);
    formData.append("category_sname", category_sname);
    formData.append("image", category_image);
    formData.append("category_id", categoryId);

    formData.append("process", "UPDATE_DATA");

    let spinner =
      '<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden"></span></div>';

    $("#saveBtn").prop("disabled", true).html(`Please wait...${spinner}`);

    $.ajax({
      url: "ajax/category.php",
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
      "Are you sure you want to delete this category?",
      () => {
        let process = "DELETE_DATA";

        const postData = {
          id: category_id,
          process: process,
        };

        ajaxHandler.postJson(
          "ajax/category.php",
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
    toggleButtonState("#categoryTable", "#deleteAllBtn");
  });

  $(document).on("change", ".checkbox", function () {
    checkAllCheckboxStatus();
    toggleButtonState("#categoryTable", "#deleteAllBtn");
  });
  /* =========code for enabled and disabled restore all button end========= */
  /* code for delete multiples items start */
  $(document).on("click", "#deleteAllBtn", function () {
    let table = $("#categoryTable");
    let checkedValues = getCheckedCheckboxValues(table);

    showConfirm(
      "Are you sure you want to delete these categories?",
      () => {
        let process = "DELETE_ALL_DATA";

        const postData = {
          id: checkedValues,
          process: process,
        };

        ajaxHandler.postJson(
          "ajax/category.php",
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
                showAlert(`${response.message}`, "success");         
                setTimeout(() => {
                  row.remove();        
                }, 500); // Duration of the fade-up animation
                setTimeout(() => {
                  location.reload();               
                }, 1000);
              });
             
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
