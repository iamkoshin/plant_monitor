loadData();
btnAction = "Insert";




// Modal Show
$("#addNewBtn").on("click", function () {
  $("#userModal").modal("show");
});

// Submit
$("#userForm").on("submit", function (event) {
  event.preventDefault();

  let username_error = validateUsername($("#username").val());
  if (username_error) {
    DisplayMessage("error", username_error);
    return;
  }

  let password_error = validatePassword($("#password").val());
  if (password_error) {
    DisplayMessage("error", password_error);
    return;
  }

  //form_data xogta formka oo dhan buu haya isago isticmalaya name instead of id
  let form_data = new FormData($("#userForm")[0]);


  if (btnAction == "Insert") {
    form_data.append("action", "register_user");
  } else {
    form_data.append("action", "update_user");
  }

  $.ajax({
    method: "POST",
    dataType: "JSON",
    url: "../api/users.php",
    data: form_data,
    contentType: false,
    processData: false,
    success: function (data) {
      console.log("Full Response:", data);
      let status = data.status;
      let response = data.data;

      if (status) {
        DisplayMessage("success", response);
        btnAction = "Insert";
        loadData();
      } else {
        DisplayMessage("error", response);
      }
    },
    error: function (data) {},
  });
});

// Same rules as validate_username() in config/validation.php
function validateUsername(username) {
  username = (username || "").trim();

  if (username == "") {
    return "Username is required";
  }
  if (username.length < 3) {
    return "Username must be at least 3 characters";
  }
  if (username.length > 50) {
    return "Username must not be longer than 50 characters";
  }
  if (!/^[A-Za-z0-9._]+$/.test(username)) {
    return "Username can only contain letters, numbers, dots (.) and underscores (_)";
  }

  return null;
}

// Same rules as validate_password() in config/validation.php
function validatePassword(password) {
  password = password || "";

  if (password == "") {
    return "Password is required";
  }
  if (password.length < 4) {
    return "Password must be at least 4 characters";
  }
  if (password.length > 10) {
    return "Password must not be longer than 10 characters";
  }

  return null;
}

function DisplayMessage(type, message) {
  let success = document.querySelector(".alert-success");
  let danger = document.querySelector(".alert-danger");

  if (type == "success") {
    //Show Success, Hide Danger
    success.classList.remove("d-none");
    danger.classList.add("d-none");
    success.innerHTML = message;

    //in model qarsoomo
    setTimeout(function () {
      $("#userModal").modal("hide"); //model qarsomo
      $("#userForm")[0].reset(); // xogta form tiraa
      success.classList.add("d-none"); //alert hide
    }, 3000);
  } else {
    // Show Danger, Hide Success
    danger.classList.remove("d-none");
    success.classList.add("d-none");
    danger.innerHTML = message;
  }
}

function loadData() {
  $("#userTable tbody").html(""); //marka  loadData la waco markasta xogta tableka nadiifiya si xogta cusub u soo baxdo

  let sendingData = {
    action: "readAll",
  };

  $.ajax({
    method: "POST",
    dataType: "JSON",
    url: "../api/users.php",
    data: sendingData,
    success: function (data) {
      let status = data.status;
      let response = data.data;
      let html = "";
      let tr = "";

      if (status) {
        // res = 1 transaction xogtiisa oo dhamaystiran buu haya
        response.forEach((res) => {
          tr += "<tr>";
          // r = 1 value eg: id,name,etc
          for (let r in res) {
            if (r == "image") {
              tr += `<td> <img src="../uploads/${res[r]}" alt="Image" style="width: 50px; height: 50px; border: solid 1px #6c6c6c; border-radius: 50%; object-fit: cover;"> </td>`;
            } else {
              tr += `<td>${res[r]}</td>`;
            }
          }

          tr += `<td> <a class="btn btn-success update-info" update_id=${res["id"]}> <i class="ph ph-note-pencil" style="color: #fff;"></i> </a> 
                    <a class="btn btn-danger delete-info" style="color: #fff;" delete_id=${res["id"]}> <i class="ph ph-trash"></i></a></td>`;

          tr += "</tr>";
        });

        $("#userTable tbody").append(tr);
      } else {
        DisplayMessage("error", response);
      }
    },
    error: function (data) {},
  });
}

function fetchUserInfo(id) {
  let sendingData = {
    action: "get_user_info",
    id: id,
  };

  $.ajax({
    method: "POST",
    dataType: "JSON",
    url: "../api/users.php",
    data: sendingData,
    success: function (data) {
      let status = data.status;
      let response = data.data;

      if (status) {
        btnAction = "Update";
        $("#update_id").val(response["id"]);
        $("#username").val(response["username"]);
        $("#email").val(response["email"]);

        $("#userModal").modal("show");
      } else {
        DisplayMessage("error", response);
      }
    },
    error: function (data) {},
  });
}

function deleteUserInfo(id) {
  let sendingData = {
    action: "delete_user_info",
    id: id,
  };

  $.ajax({
    method: "POST",
    dataType: "JSON",
    url: "../api/users.php",
    data: sendingData,
    success: function (data) {
      let status = data.status;
      let response = data.data;

      if (status) {
        Swal.fire({
          title: "Good Job!",
          text: response,
          icon: "success",
        });

        loadData();
      } else {
        DisplayMessage("error", response);
      }
    },
    error: function (data) {},
  });
}

$("#userTable").on("click", "a.update-info", function () {
  let id = $(this).attr("update_id");
  fetchUserInfo(id);
});

$("#userTable").on("click", "a.delete-info", function () {
  let id = $(this).attr("delete_id");
  if (confirm("Are you sure you want to delete this user?")) {
    deleteUserInfo(id);
  }
});
