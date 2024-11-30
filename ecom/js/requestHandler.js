class AjaxRequest {
  constructor() {
    // Initialize any properties here
  }

  // Method to make a GET request
  get(url, successCallback, errorCallback) {
    $.ajax({
      url: url,
      type: "GET",
      success: function (response) {
        if (successCallback) {
          successCallback(response);
        }
      },
      error: function (xhr, status, error) {
        if (errorCallback) {
          errorCallback(xhr, status, error);
        }
      },
    });
  }

  // Method to make a POST request
  post(url, data, successCallback, errorCallback) {
    $.ajax({
      url: url,
      type: "POST",
      data: data,
      success: function (response) {
        if (successCallback) {
          successCallback(response);
        }
      },
      error: function (xhr, status, error) {
        if (errorCallback) {
          errorCallback(xhr, status, error);
        }
      },
    });
  }

  // Method to make a PUT request
  put(url, data, successCallback, errorCallback) {
    $.ajax({
      url: url,
      type: "PUT",
      data: data,
      success: function (response) {
        if (successCallback) {
          successCallback(response);
        }
      },
      error: function (xhr, status, error) {
        if (errorCallback) {
          errorCallback(xhr, status, error);
        }
      },
    });
  }

  // Method to make a DELETE request
  delete(url, successCallback, errorCallback) {
    $.ajax({
      url: url,
      type: "DELETE",
      success: function (response) {
        if (successCallback) {
          successCallback(response);
        }
      },
      error: function (xhr, status, error) {
        if (errorCallback) {
          errorCallback(xhr, status, error);
        }
      },
    });
  }

  async getJson(url, successCallback, errorCallback) {
    try {
      const response = await $.ajax({
        url: url,
        type: "GET",
        dataType: "json",
      });
      if (successCallback) {
        successCallback(response);
      }
    } catch (error) {
      if (errorCallback) {
        errorCallback(error);
      }
    }
  }

  // Method to make a POST request
  async postJson(url, data, successCallback, errorCallback) {
    try {
      const response = await $.ajax({
        url: url,
        type: "POST",
        data: data,
        dataType: "json",
      });
      if (successCallback) {
        successCallback(response);
      }
    } catch (error) {
      if (errorCallback) {
        errorCallback(error);
      }
    }
  }
}
