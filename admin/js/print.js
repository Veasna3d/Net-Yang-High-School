
function displayData() {
    $.ajax({
        url: './controllers/print_json.php?data=get_print',
        type: 'GET',
        dataType: 'json',
        success: function (alldata) {
            var columns = [{
                title: "ល.រ"
            }, {
                title: "គ្រឹះស្ថានបោះពុម្ព"
            }, {
                title: "ទីតាំងបោះពុម្ព"
            }, {
                title: "សកម្មភាព"
            }];
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
                pageLength: 10,
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
        error: function (e) {
            console.log(e.responseText);
        }
    });
}

//Load
$(document).ready(function () {
    displayData();
})

$('#btnSave').click(function () {
    var publishingHouse = $('#publishingHouse');
    var printingHouse = $('#printingHouse');
    if (publishingHouse.val() == "") {
        publishingHouse.focus();
        return toastr.warning("Field Require!").css("margin-top", "2rem");
    }
    if (printingHouse.val() == "") {
        printingHouse.focus();
        return toastr.warning("Field Require!").css("margin-top", "2rem");
    }

    var form_data = $('#form').serialize();
    if ($('#btnSave').text() == "រក្សាទុក") {
        // Insert
        $.ajax({
            type: 'POST',
            url: './controllers/print_json.php?data=add_print',
            data: form_data,
            dataType: 'json',
            success: function (data) {
                toastr.success("ជោគជ័យ").css("margin-top", "2rem");
                displayData();
                $('#myModal').modal('hide');
            },
            error: function (ex) {
                toastr.error("បរាជ័យ").css("margin-top", "2rem");
                console.log(ex.responseText);
            }
        });
    } else {
        // Update
        $.ajax({
            type: 'POST',
            url: './controllers/print_json.php?data=update_print&id=' + class_id,
            data: form_data,
            dataType: 'json',
            success: function (data) {
                toastr.success("ជោគជ័យ").css("margin-top", "2rem");
                displayData();
                $('#myModal').modal('hide');
            },
            error: function (ex) {
                toastr.error("បរាជ័យ").css("margin-top", "2rem");
                console.log(ex.responseText);
            }
        });
    }
})
    



$('#btnAdd').click(function () {
    $('#publishingHouse').val("");
    $('#printingHouse').val("");
    $('#btnSave').text("រក្សាទុក");
});

var class_id;

function editData(id) {
    $('#btnSave').text("កែប្រែ");
    class_id = id;
    $.ajax({
        url: './controllers/print_json.php?data=get_byid',
        data: '&id=' + id,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            $('#publishingHouse').val(data[0][1]);
            $('#printingHouse').val(data[0][2]);
        },
        error: function (ex) {
            console.log(ex.responseText);
        }
    });
}


//Delete
function deleteData(id) {
    Swal.fire({
        title: "តើអ្នកចង់លុបទិន្នន័យនេះចេញពីប្រព័ន្ធ?",
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
                url: "./controllers/print_json.php?data=delete_print&id=" + id,
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
