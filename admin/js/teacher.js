 
function displayData() {
    $.ajax({
        url: './controllers/teacher_json.php?data=get_teacher',
        type: 'GET',
        dataType: 'json',
        success: function(alldata) {
            var columns = [
                {title: 'ល.រ'},
                {title: 'ឈ្មោះគ្រូ'},
                {title: 'លេខសម្ងាត់'},
                {title: 'រូបភាព'},
                {title: 'ភេទ'},
                {title: 'លេខទូរស័ព'},
                {title: 'ថ្ងៃបង្កើត'},
                {title: 'សកម្មភាព'}
            ];
            var data = [];
            var option = '';
            for (var i in alldata) {
                option = "<button class='btn btn-success btn-sm edit btn-flat' data-toggle='modal' data-target='#myModal' onclick='editData(" +
                alldata[i][0] +
                ")'><i class='fa fa-edit'></i> </button> | <button class='btn btn-danger btn-sm delete btn-flat' onclick='deleteData(" +
                alldata[i][0] + ")'><i class='fa fa-trash'></i> </button> ";
                data.push([alldata[i][0], alldata[i][1],alldata[i][2],"<img style='width: 50px; height: 50px;' src='uploads/" + alldata[i][3] + "'>", alldata[i][4],alldata[i][5],alldata[i][6], option]);
            }
            console.log(data);
            $('#tableId').DataTable({
                destroy: true,
                data: data,
                columns: columns, 
                responsive: true,
                lengthChange: false,
                autoWidth: false,
                buttons: ['print', 'pdf'],
                dom: "<'row'<'col-md-5'B><'col-md-7'f>>" +
                    "<'row'<'col-md-12'tr>>" +
                    "<'row'<'col-md-5'l>>" +
                    "<'row'<'col-md-5'i><'col-md-7'p>>",
            });
        },
        error: function(e) {
            console.log(e.responseText);
        }
    });
}


//Load
$(document).ready(function() {
    displayData();
})

$('#btnSave').click(function() {
    var name = $('#name');
    var password = $('#password');
    // var image = $('#image');
    var gender = $('#gender');
    var phone = $('#phone');
    if(name.val() == ""){
        name.focus();
        return toastr.warning("សូមបញ្ចូលឈ្មោះ!").css("margin-top", "2rem");
    }
    else if(password.val() == ""){
        password.focus();
        return toastr.warning("សូមបញ្ចូលឈ្មោះ!").css("margin-top", "2rem");
    }else if(gender.val() == ""){
        gender.focus();
        return toastr.warning("សូមបញ្ចូលឈ្មោះ!").css("margin-top", "2rem");
    }
    else if(phone.val() == ""){
        phone.focus();
        return toastr.warning("សូមបញ្ចូលឈ្មោះ!").css("margin-top", "2rem");
    }
  // Check if txtname already exists in database
$.ajax({
    type: 'POST',
    url: './controllers/teacher_json.php?data=check_teacher',
    data: {name: name.val()},
    dataType: 'json',
    success: function(data) {
        if (data.exists) {
            teachername.focus();
            password.focus();
            gender.focus();
            phone.focus();
            toastr.warning("ឈ្មោះ​មាន​រួច​ហើយ​ក្នុង​​ទិន្នន័យ!").css("margin-top", "2rem");
        } else {
            var form_data = $('#form').serialize();
            if ($('#btnSave').text() == "រក្សាទុក") {
                // Insert
                $.ajax({
                    type: 'POST',
                    url: './controllers/teacher_json.php?data=add_teacher',
                    data: form_data,
                    dataType: 'json',
                    contentType: false, // Set to false to let jQuery decide the content type
                    processData: false, // Set to false to prevent jQuery from processing data (i.e. no stringifying)
                    success: function(data) {
                        toastr.success("ជោគជ័យ").css("margin-top", "2rem");
                        displayData();
                        $('#myModal').modal('hide');
                    },
                    error: function(ex) {
                        toastr.error("បរាជ័យ").css("margin-top", "2rem");
                        console.log(ex.responseText);
                    }
                });
            } else {
                // Update
                $.ajax({
                    type: 'POST',
                    url: './controllers/teacher_json.php?data=update_teacher&id=' + class_id,
                    data: form_data,
                    dataType: 'json',
                    contentType: false, // Set to false to let jQuery decide the content type
                    processData: false, // Set to false to prevent jQuery from processing data (i.e. no stringifying)
                    success: function(data) {
                        toastr.success("ជោគជ័យ").css("margin-top", "2rem");
                        displayData();
                        $('#myModal').modal('hide');
                    },
                    error: function(ex) {
                        toastr.error("បរាជ័យ").css("margin-top", "2rem");
                        console.log(ex.responseText);
                    }
                });
            }
        }
    },
    error: function(ex) {
        toastr.error("Error checking name in database").css("margin-top", "2rem");
        console.log(ex.responseText);
    }
});
    
});

$('#btnAdd').click(function() {
    $('#name').val("");
    $('#password').val("");
    $('#image').val("");
    $('#ddlGender').val("");  
    $('#phone').val("");
    $('#btnSave').text("រក្សាទុក");
});

var class_id;

function editData(id) {
    $('#btnSave').text("កែប្រែ");
    class_id = id;
    $.ajax({
        url: './controllers/teacher_json.php?data=get_byid',
        data: '&id=' + id,
        type: 'GET',
        dataType: 'json',
        contentType: false, // Set to false to let jQuery decide the content type
        processData: false, // Set to false to prevent jQuery from processing data (i.e. no stringifying)
        success: function(data) {
            $('#name').val(data[0][1]);
            $('#password').val(data[0][2]);
            $('#image').val(data[0][3]);
            $('#ddlGender').val(data[0][4]);
            $('#phone').val(data[0][5]);  
        },
        error: function(ex) {
            console.log(ex.responseText);
        }
    });
}


//Delete
function deleteData(id) {
    Swal.fire({
      title: "តើអ្នកចង់លុបថ្នាក់នេះចេញពីប្រព័ន្ធ?",
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
          url: "./controllers/teacher_json.php?data=delete_teacher&id=" + id,
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
  