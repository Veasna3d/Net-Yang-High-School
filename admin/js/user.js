function displayData() {
  $.ajax({
    url: './controllers/user_json.php?data=get_user',
    type: 'GET',
    dataType: 'json',
    success: function (alldata) {
      var columns = [
        { title: 'ល.រ' },
        { title: 'ឈ្មោះ' },
        { title: 'លេខសម្ងាត់' },
        { title: 'រូបភាព' },
        { title: 'អ៊ីមែល' },
        { title: 'ស្ថានភាព' },
        { title: 'សកម្មភាព' }
      ];
      var data = [];
      var option = '';
      for (var i in alldata) {
        option = "<button class='btn btn-success btn-sm edit btn-flat' data-toggle='modal' data-target='#myModal' onclick='editData(" +
          alldata[i][0] +
          ")'><i class='fa fa-edit'></i> </button> | <button class='btn btn-danger btn-sm delete btn-flat' onclick='deleteData(" +
          alldata[i][0] + ")'><i class='fa fa-trash'></i> </button> ";
        data.push([
          alldata[i][0],
          alldata[i][1], 
          "***" + alldata[i][2].slice(-2),
          "<img style='width: 50px; height: 50px;' src='upload/" + alldata[i][3] + "'>", 
          alldata[i][4], 
          alldata[i][5], 
          option]);
      }
      console.log(data);
      $('#tableId').DataTable({
        destroy: true,
        data: data,
        columns: columns,
        pageLength: 5,
        language: {
            info: 'Showing _START_ to _END_ of _TOTAL_ entries',
            infoEmpty: 'Showing 0 entries',
            infoFiltered: '(filtered from _MAX_ total entries)'
        },
        responsive: true,
        lengthChange: false,
        autoWidth: false,
        buttons: ['icon pfd', 'pdf', 'excel'],
        dom: "<'row'<'col-md-5'B><'col-md-7'f>>" +
        "<'row'<'col-md-12'tr>>" +
        "<'row'<'col-md-5'i><'col-md-7'p>>" +
        "<'row'<'col-md-5'l><'#btn-container'>>",
    });

    // Add the custom button to the DataTables toolbar
    $('#btn-container').append('<button id="btnAdd" type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">បង្កើតថ្មី</button>');

    // Move the custom button to the left of the other buttons
    $('.dt-buttons').prepend($('#btnAdd'));

    // Adjust the margins of the custom button
    $('#btnAdd').css('margin-right', '5px');
    },
    error: function (e) {
      console.log(e.responseText);
    }
  });
}


//Load
$(document).ready(function () {
  displayData();
});

//btnSave
$("#btnSave").click(function () {

  var username = $("#txtUsername");
  var password = $("#txtPassword");

  if (username.val() == "") {
    username.focus();
    return toastr.warning("Field Require!").css("margin-top", "2rem");
  } else if (username.val() == "") {
    username.focus();
    return toastr.warning("Username Require!").css("margin-top", "2rem");
  } else if (password.val() == "") {
    password.focus();
    return toastr.warning("Password Require!").css("margin-top", "2rem");
  } else if (password.val().length < 5) {
    password.focus();
    return toastr.warning("Password must be at least 5 characters long!").css("margin-top", "2rem");
  }

  // Check if txtName already exists in database
  $.ajax({
    type: 'POST',
    url: './controllers/user_json.php?data=check_username',
    data: { name: username.val() },
    dataType: 'json',
    success: function (data) {
      if (data.exists) {
        username.focus();
        toastr.warning("Name already exists in database!").css("margin-top", "2rem");
      } else {
        var form_data = new FormData($("#form")[0]); // Use FormData object to include file data
        if ($("#btnSave").text() == "រក្សាទុក") {
          //Insert
          $.ajax({
            type: "POST",
            url: "./controllers/user_json.php?data=add_user",
            data: form_data,
            dataType: "json",
            contentType: false, // Set to false to let jQuery decide the content type
            processData: false, // Set to false to prevent jQuery from processing data (i.e. no stringifying)
            success: function (data) {
              toastr.success("Action completed").css("margin-top", "2rem");
              displayData();
              $("#myModal").modal("hide");
            },
            error: function (ex) {
              toastr.error("Action incomplete").css("margin-top", "2rem");
              console.log(ex.responseText);
            },
          });
        } else {
          //Update
          $.ajax({
            type: "POST",
            url: "./controllers/user_json.php?data=update_user&id=" + user_id,
            data: form_data,
            dataType: "json",
            contentType: false,
            processData: false,
            success: function (data) {
              toastr.success("Action completed").css("margin-top", "2rem");
              displayData();
              $("#myModal").modal("hide");
            },
            error: function (ex) {
              toastr.error("Action incomplete").css("margin-top", "2rem");
              console.log(ex.responseText);
            },
          });
        }
      }
    },
    error: function (ex) {
      toastr.error("Error checking name in database").css("margin-top", "2rem");
      console.log(ex.responseText);
    }
  })

});

$("#btnAdd").click(function () {
  $("#txtUsername").val("");
  $("#txtPassword").val("");
  $("#txtEmail").val("");
  $("#image").val("");
  $("#btnSave").text("Insert");
});

var user_id;

function editData(id) {
  $("#btnSave").text("Update");
  user_id = id;
  $.ajax({
    url: "./controllers/user_json.php?data=get_byid",
    data: "&id=" + id,
    type: "GET",
    dataType: "json",
    contentType: false,
    processData: false,
    success: function (data) {
      $("#txtUsername").val(data[0][1]);
      $("#txtPassword").val(data[0][2]);
      $("#txtEmail").val(data[0][3]);
      $("#image").val(data[0][4]);
    },
    error: function (ex) {
      console.log(ex.responseText);
    },
  });
}


//Delete Student
function deleteData(id) {
  Swal.fire({
      title: "តើអ្នកចង់ទិន្នន័យនេះចេញពីប្រព័ន្ធ?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      cancelButtonText: "ទេ",
      confirmButtonText: "បាទ!",
  }).then((result) => {
      if (result.isConfirmed) {
          $.ajax({
              type: "GET",
              url: "./controllers/user_json.php?data=delete_user&id=" + id,
              dataType: "json",
              success: function (data) {
                  Swal.fire({
                      title: "ជោគជ័យ",
                      icon: "success",
                      showConfirmButton: false,
                      timer: 2000,
                  });
                  displayData();
              },
              error: function (ex) {
                  Swal.fire({
                      title: "បរាជ័យ",
                      text: ex.responseText,
                      icon: "error",
                      showConfirmButton: false,
                      timer: 2000,
                  });
                  console.log(ex.responseText);
              },
          });
      }
  });
}
