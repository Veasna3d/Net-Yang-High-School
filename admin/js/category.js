 
function displayData() {
    $.ajax({
        url: './controllers/category_json.php?data=get_category',
        type: 'GET',
        dataType: 'json',
        success: function(alldata) {
            var columns = [
                {title: 'ល.រ'},
                {title: 'ប្រភេទកូដ'},
                {title: 'ប្រភេទឈ្មោះ'},
                {title: 'សកម្មភាព'}
            ];
            var data = [];
            var option = '';
            for (var i in alldata) {
                option = "<button class='btn btn-success btn-sm edit btn-flat' data-toggle='modal' data-target='#myModal' onclick='editData(" +
                alldata[i][0] +
                ")'><i class='fa fa-edit'></i> </button> | <button class='btn btn-danger btn-sm delete btn-flat' onclick='deleteData(" +
                alldata[i][0] + ")'><i class='fa fa-trash'></i> </button> ";
                data.push([alldata[i][0], alldata[i][1], alldata[i][2], option]);
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
                buttons: ['icon pfd'],
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
    var categoryCode = $('#categoryCode');
    var categoryName = $('#categoryName');
    if(categoryCode.val() == ""){
        categoryCode.focus();
        return toastr.warning("សូមបញ្ចូលឈ្មោះ!").css("margin-top", "2rem");
    }
    else if(categoryName.val() == ""){
        categoryName.focus();
        return toastr.warning("សូមបញ្ចូលឈ្មោះ!").css("margin-top", "2rem");
    }
  // Check if txtName already exists in database
$.ajax({
    type: 'POST',
    url: './controllers/category_json.php?data=check_category_name',
    data: {categoryCode: categoryCode.val(), categoryName: categoryName.val()},
    dataType: 'json',
    success: function(data) {
        if (data.exists) {
            categoryCode.focus();
            categoryName.focus();
            toastr.warning("ឈ្មោះ​មាន​រួច​ហើយ​ក្នុង​​ទិន្នន័យ!").css("margin-top", "2rem");
        } else {
            var form_data = $('#form').serialize();
            if ($('#btnSave').text() == "រក្សាទុក") {
                // Insert
                $.ajax({
                    type: 'POST',
                    url: './controllers/category_json.php?data=add_category',
                    data: form_data,
                    dataType: 'json',
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
                    url: './controllers/category_json.php?data=update_category&id=' + class_id,
                    data: form_data,
                    dataType: 'json',
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
    $('#categoryCode').val("");
    $('#categoryName').val("");
    $('#btnSave').text("រក្សាទុក");
});

var class_id;

function editData(id) {
    $('#btnSave').text("កែប្រែ");
    class_id = id;
    $.ajax({
        url: './controllers/category_json.php?data=get_byid',
        data: '&id=' + id,
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            $('#categoryCode').val(data[0][1]);
            $('#categoryName').val(data[0][2]);
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
          url: "./controllers/category_json.php?data=delete_category&id=" + id,
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
  