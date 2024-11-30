/* ========code for multiple select checkbox start========= */
// Function to check or uncheck all checkboxes when #checkAll is changed
$("#checkAllCheckbox").on("change", function () {
  $(".checkbox").prop("checked", $(this).prop("checked"));
  toggleButtonState("#transactions_table", "#deleteAllBtn");
});

// Function to check the state of the #checkAll checkbox
function checkAllCheckboxStatus() {
  if (
    $(".checkbox:checked").length === $(".checkbox").length &&
    $(".checkbox").length > 0
  ) {
    $("#checkAllCheckbox").prop("checked", true);    
  } else {
    $("#checkAllCheckbox").prop("checked", false);    
  }  
}

// Event listener for individual checkboxes
$(document).on("change", ".checkbox", function () {
  checkAllCheckboxStatus();
  toggleButtonState("#transactions_table", "#deleteAllBtn");
});

// Initial check on page load to set the state of the #checkAll checkbox
checkAllCheckboxStatus();
/* ========code for multiple select checkbox end========= */

/* =========get checked checkbox value start======== */
// Function to get the values of checked checkboxes within a specific table
function getCheckedCheckboxValues(table) {
  let checkedValues = [];
  $(table)
    .find(".checkbox:checked")
    .each(function () {
      checkedValues.push($(this).val());
    });
  return checkedValues;
}
/* =========get checked checkbox value end======== */

// Function to toggle the button state based on checkbox state
function toggleButtonState(tableId, buttonId) {
  if ($(tableId).find(".checkbox:checked").length > 0) {
    $(buttonId).prop("disabled", false);
  } else {
    $(buttonId).prop("disabled", true);
  }
}

