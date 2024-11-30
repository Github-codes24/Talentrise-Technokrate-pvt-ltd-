$(document).ready(function () {
  const ajaxHandler = new AjaxRequest();

  $("#saveBtn").on("click", function () {
    let site_name = $("#siteName").val();
    let site_email = $("#siteEmail").val();
    let site_logo = $("#siteLogo").val();

    const data = {
      site_name: $("#siteName").val(),
      site_email: $("#siteEmail").val(),
      site_logo: $("#siteLogo").val(), // Assuming you want to send the file path
      site_facebook_url: $("#siteFacebookUrl").val(),
      site_instagram_url: $("#siteInstagramUrl").val(),
      site_linkedin_url: $("#siteLinkedinUrl").val(),
      site_twitter_url: $("#siteTwitterUrl").val(),
      site_contact_number: $("#siteContactNumber").val(),
      site_whatsapp_number: $("#siteWhatsappNumber").val(),
      id: $("#saveBtn").val(),
    };

    if (site_name && site_email && site_logo) {
      let spinner =
        '<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden"></span></div>';

      $("#saveBtn").prop("disabled", true).html(`Please wait...${spinner}`);

      ajaxHandler.postJson(
        "ajax/app_settings.php",
        data,
        function (response) {
          $("#saveBtn").prop("disabled", false).html("Save changes");

          // $("#error-container").empty();

          if (response.status == "success") {
            showAlert(`${response.message}`, `${response.status}`);
            setTimeout(function () {
              location.reload();
            }, 1000);
          } else {
            showAlert(`${response.message}`, `${response.status}`);
          }
        },
        function (error) {
          $("#saveBtn").prop("disabled", false).html("Save changes");
          showAlert("Error: Something went wrong!", "error");
          console.error("Error:", error);
        }
      );
    } else {
      showAlert("Please fill all the required fields.", "warning");
    }
  });
});
