const ajaxHandler = new AjaxRequest();

document.addEventListener("DOMContentLoaded", function () {
  const usernameInput = document.getElementById("username");
  const passwordInput = document.getElementById("password");
  const usernameError = document.getElementById("usernameError");
  const passwordError = document.getElementById("passwordError");
  const form = document.getElementById("loginForm");

  function validateUsername() {
    if (usernameInput.value === "") {
      usernameError.textContent = "Username is required";
      usernameInput.classList.add("error");
      usernameInput.style.border = "1px solid red";
      return false;
    } else {
      usernameError.textContent = "";
      usernameInput.classList.remove("error");
      usernameInput.style.border = "1px solid gray";
      return true;
    }
  }

  function validatePassword() {
    if (passwordInput.value === "") {
      passwordError.textContent = "Password is required";
      passwordInput.classList.add("error");
      passwordInput.style.border = "1px solid red";
      return false;
    } else {
      passwordError.textContent = "";
      passwordInput.classList.remove("error");
      passwordInput.style.border = "1px solid gray";
      return true;
    }
  }

  usernameInput.addEventListener("keyup", validateUsername);
  passwordInput.addEventListener("keyup", validatePassword);

  form.addEventListener("click", function () {
    const isUsernameValid = validateUsername();
    const isPasswordValid = validatePassword();

    if (isUsernameValid && isPasswordValid) {
      const data = {
        username: usernameInput.value,
        password: passwordInput.value,
      };

      let spinner =
        '<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden"></span></div>';

      $("#loginBtn").prop("disabled", true).html(`Logging in...${spinner}`);

      ajaxHandler.postJson(
        "ajax/login.php",
        data,
        function (response) {
          $("#loginBtn").prop("disabled", false).html("Log in");

          // $("#error-container").empty();

          if (response.status == "success") {
            window.location.href = "index.php";
          } else {
            alert(`${response.message}`);
          }
        },
        function (error) {
          $("#loginBtn").prop("disabled", false).html("Log in");
          alert("Error: Something went wrong!");
          console.error("Error:", error);
        }
      );
    }
  });
});
