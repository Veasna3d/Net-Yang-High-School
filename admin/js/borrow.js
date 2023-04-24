function displayData() {
    $.ajax({
        url: "./controllers/borrow_json.php?data=get_borrow",
        type: "GET",
        dataType: "json",
        success: function (alldata) {
            var columns = [
                {
                    title: "ល.រ",
                }, {
                    title: "សិស្ស",
                }, {
                    title: "គ្រូ",
                }, {
                    title: "សៀវភៅ",
                }, {
                    title: "កាលបរិច្ឆេទខ្ចី",
                }, {
                    title: "កាលបរិច្ឆេទសង",
                }, {
                    title: "ស្ថានភាព",
                }, {
                    title: "សម្គាល់",
                }, {
                    title: "សកម្មភាព",
                },
            ];
            var data = [];
            var option = "";
            for (var i in alldata) {
                option =
                    "<button class='btn btn-success btn-sm edit btn-flat' data-toggle='modal' data-target='#myModal' onclick='editData(" +
                    alldata[i][0] +
                    ")'><i class='fa fa-edit'></i> </button> | <button class='btn btn-danger btn-sm delete btn-flat' onclick='deleteData(" +
                    alldata[i][0] +
                    ")'><i class='fa fa-trash'></i> </button> | <button class='btn btn-info btn-sm btn-flat' onclick='returnData(" +
                    alldata[i][0] +
                    ")'><i class='fa fa-reply'></i> </button>";
                data.push([
                    alldata[i][0],
                    alldata[i][1],
                    alldata[i][2],
                    alldata[i][3],
                    alldata[i][4],
                    alldata[i][5],
                    alldata[i][7],
                    alldata[i][6],
                    option,
                ]);
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
           
           // $('#btn-container').append('<button id="btnReturn" type="button" class="btn btn-info">បានសង</button>');
           // $('#btn-container').append('<button id="btnBorrow" type="button" class="btn btn-success">បានខ្ចី</button>');
            $('#btn-container').append('<button id="btnAdd" type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">បង្កើតថ្មី</button>');
        
            // Move the custom button to the left of the other buttons
            
            $('.dt-buttons').prepend($('#btnReturn'));
            $('.dt-buttons').prepend($('#btnBorrow'));
            $('.dt-buttons').prepend($('#btnAdd'));
        
            // Adjust the margins of the custom button
            $('#btnReturn').css('margin-right', '5px');
            $('#btnBorrow').css('margin-right', '5px');
            $('#btnAdd').css('margin-right', '5px');
        },
        error: function (e) {
            console.log(e.responseText);
        },
    });
}

//Filter Borrow
$("#btnBorrow").click(function () {
    $.ajax({
        url: "./controllers/borrow_json.php?data=get_borrow",
        type: "GET",
        dataType: "json",
        success: function (alldata) {
            var columns = [
                {
                    title: "ល.រ",
                }, {
                    title: "សិស្ស",
                }, {
                    title: "គ្រូ",
                }, {
                    title: "សៀវភៅ",
                }, {
                    title: "កាលបរិច្ឆេទខ្ចី",
                }, {
                    title: "កាលបរិច្ឆេទសង",
                }, {
                    title: "ស្ថានភាព",
                }, {
                    title: "សម្គាល់",
                }, {
                    title: "សកម្មភាព",
                },
            ];
            var data = [];
            var option = "";
            for (var i in alldata) {
                option =
                    "<button class='btn btn-success btn-sm edit btn-flat' data-toggle='modal' data-target='#myModal' onclick='editData(" +
                    alldata[i][0] +
                    ")'><i class='fa fa-edit'></i> </button> | <button class='btn btn-danger btn-sm delete btn-flat' onclick='deleteData(" +
                    alldata[i][0] +
                    ")'><i class='fa fa-trash'></i> </button> | <button class='btn btn-info btn-sm btn-flat' onclick='returnData(" +
                    alldata[i][0] +
                    ")'><i class='fa fa-reply'></i> </button>";
                data.push([
                    alldata[i][0],
                    alldata[i][1],
                    alldata[i][2],
                    alldata[i][3],
                    alldata[i][4],
                    alldata[i][5],
                    alldata[i][7],
                    alldata[i][6],
                    option,
                ]);
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
           
           // $('#btn-container').append('<button id="btnReturn" type="button" class="btn btn-info">បានសង</button>');
           //$('#btn-container').append('<button id="btnBorrow" type="button" class="btn btn-success">បានខ្ចី</button>');
            $('#btn-container').append('<button id="btnAdd" type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">បង្កើតថ្មី</button>');
        
            // Move the custom button to the left of the other buttons
            
            $('.dt-buttons').prepend($('#btnReturn'));
            $('.dt-buttons').prepend($('#btnBorrow'));
            $('.dt-buttons').prepend($('#btnAdd'));
        
            // Adjust the margins of the custom button
            $('#btnReturn').css('margin-right', '5px');
            $('#btnBorrow').css('margin-right', '5px');
            $('#btnAdd').css('margin-right', '5px');
        },
        error: function (e) {
            console.log(e.responseText);
        },
    });
})

//Filter Returned
$("#btnReturn").click(function () {
    $.ajax({
        url: "./controllers/borrow_json.php?data=get_return",
        type: "GET",
        dataType: "json",
        success: function (alldata) {
            var columns = [
                {
                    title: "ល.រ",
                }, {
                    title: "សិស្ស",
                }, {
                    title: "គ្រូ",
                }, {
                    title: "សៀវភៅ",
                }, {
                    title: "កាលបរិច្ឆេទខ្ចី",
                }, {
                    title: "កាលបរិច្ឆេទសង",
                }, {
                    title: "ស្ថានភាព",
                }, {
                    title: "សម្គាល់",
                }, {
                    title: "សកម្មភាព",
                },
            ];
            var data = [];
            var option = "";
            for (var i in alldata) {
                option =
                    "<button class='btn btn-success btn-sm edit btn-flat' data-toggle='modal' data-target='#myModal' onclick='editData(" +
                    alldata[i][0] +
                    ")'><i class='fa fa-edit'></i> </button> | <button class='btn btn-danger btn-sm delete btn-flat' onclick='deleteData(" +
                    alldata[i][0] +
                    ")'><i class='fa fa-trash'></i> </button>";
                data.push([
                    alldata[i][0],
                    alldata[i][1],
                    alldata[i][2],
                    alldata[i][3],
                    alldata[i][4],
                    alldata[i][5],
                    alldata[i][7],
                    alldata[i][6],
                    option,
                ]);
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
           
          //  $('#btn-container').append('<button id="btnReturn" type="button" class="btn btn-info">បានសង</button>');
           // $('#btn-container').append('<button id="btnBorrow" type="button" class="btn btn-success">បានខ្ចី</button>');
            $('#btn-container').append('<button id="btnAdd" type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">បង្កើតថ្មី</button>');
        
            // Move the custom button to the left of the other buttons
            
            $('.dt-buttons').prepend($('#btnReturn'));
            $('.dt-buttons').prepend($('#btnBorrow'));
            $('.dt-buttons').prepend($('#btnAdd'));
        
            // Adjust the margins of the custom button
            $('#btnReturn').css('margin-right', '5px');
            $('#btnBorrow').css('margin-right', '5px');
            $('#btnAdd').css('margin-right', '5px');
        },
        error: function (e) {
            console.log(e.responseText);
        },
    });
})

function setStudent(myselect, myjson, caption) {
    try {
        var sel = $(myselect);
        sel.empty();
        sel.append('<option value="">' + caption + "</option>");
        $.ajax({
            url: myjson,
            dataType: "json",
            success: function (s) {
                for (var i = 0; i < s.length; i++) {
                    sel.append(
                        '<option value="' +
                        s[i][0] +
                        '">' +
                        s[i][3] +
                        "|ភេទ " +
                        s[i][5] +
                        "|ថ្នាក់ " +
                        s[i][6] +
                        "</option>"
                    );
                }
            },
            error: function (e) {
                console.log(e.responseText);
            },
        });
    } catch (err) {
        console.log(err.message);
    }
}
function setBook(myselect, myjson, caption) {
    try {
        var sel = $(myselect);
        sel.empty();
        sel.append('<option value="">' + caption + "</option>");
        $.ajax({
            url: myjson,
            dataType: "json",
            success: function (s) {
                for (var i = 0; i < s.length; i++) {
                    sel.append(
                        '<option value="' +
                        s[i][0] +
                        '">' +
                        s[i][2] +
                        "|" +
                        s[i][7] +
                        "</option>"
                    );
                }
            },
            error: function (e) {
                console.log(e.responseText);
            },
        });
    } catch (err) {
        console.log(err.message);
    }
}
function setData(myselect, myjson, caption) {
    try {
        var sel = $(myselect);
        sel.empty();
        sel.append('<option value="">' + caption + "</option>");
        $.ajax({
            url: myjson,
            dataType: "json",
            success: function (s) {
                for (var i = 0; i < s.length; i++) {
                    sel.append(
                        '<option value="' +
                        s[i][0] +
                        '">' +
                        s[i][1] +
                        "</option>"
                    );
                }
            },
            error: function (e) {
                console.log(e.responseText);
            },
        });
    } catch (err) {
        console.log(err.message);
    }
}

//Load
$(document).ready(function () {
    displayData();
    setStudent(
        "#ddlStudent",
        "./controllers/borrow_json.php?data=get_student",
        "ជ្រើសរើស"
    );
    setBook(
        "#ddlBook",
        "./controllers/borrow_json.php?data=get_book",
        "ជ្រើសរើស"
    );
    setData(
        "#ddlTeacher",
        "./controllers/borrow_json.php?data=get_teacher",
        "ជ្រើសរើស"
    );
});

$("#btnSave").click(function () {

    var book = $("#ddlBook");
    var borrowDate = $("#txtBorrowDate");
    var returnDate = $("#txtReturnDate");


    if (book.val() == "") {
        book.focus();
        return toastr.warning("បញ្ចូលទិន្នន័យ!").css("margin-top", "2rem");
    } else if (borrowDate.val() == "") {
        borrowDate.focus();
        return toastr.warning("ថ្ងៃខែឆ្នាំខ្ចី!").css("margin-top", "2rem");
    } else if (returnDate.val() == "") {
        returnDate.focus();
        return toastr.warning("ថ្ងៃខែឆ្នាំសង!").css("margin-top", "2rem");
    }

    var form_data = $("#form").serialize();
    if ($("#btnSave").text() == "រក្សាទុក") {
        // Insert
        $.ajax({
            type: "POST",
            url: "./controllers/borrow_json.php?data=add_borrow",
            data: form_data,
            dataType: "json",
            success: function (data) {
                toastr.success("ជោគជ័យ").css("margin-top", "2rem");
                displayData();
                $("#myModal").modal("hide");
            },
            error: function (ex) {
                toastr.error("បរាជ័យ").css("margin-top", "2rem");
                console.log(ex.responseText);
            },
        });
    } else {
        // Update
        $.ajax({
            type: "POST",
            url:
                "./controllers/borrow_json.php?data=update_borrow&id=" + borrow_id,
            data: form_data,
            dataType: "json",
            success: function (data) {
                toastr.success("ជោគជ័យ").css("margin-top", "2rem");
                displayData();
                $("#myModal").modal("hide");
            },
            error: function (ex) {
                toastr.error("បរាជ័យ").css("margin-top", "2rem");
                console.log(ex.responseText);
            },
        });
    }
});

$("#btnAdd").click(function () {
    $("#ddlStudent").val("");
    $("#ddlTeacher").val("");
    $("#ddlBook").val("");
    $("#txtBorrowDate").val("");
    $("#txtReturnDate").val("");
    $("#txtRemark").val("");
    $("#btnSave").text("រក្សាទុក");
});

var borrow_id;

function editData(id) {
    $("#btnSave").text("កែប្រែ");
    borrow_id = id;
    $.ajax({
        url: "./controllers/borrow_json.php?data=get_byid",
        data: "&id=" + id,
        type: "GET",
        dataType: "json",
        success: function (data) {
            $("#ddlStudent").val(data[0][1]);
            $("#ddlTeacher").val(data[0][2]);
            $("#ddlBook").val(data[0][3]);
            $("#txtBorrowDate").val(data[0][4]);
            $("#txtReturnDate").val(data[0][5]);
            $("#txtRemark").val(data[0][6]);

            // disable ddlTeacher if ddlStudent has a value
            if ($("#ddlStudent").val()) {
                $("#ddlTeacher").prop("disabled", true);
            } else {
                $("#ddlTeacher").prop("disabled", false);
            }

            // disable ddlStudent if ddlTeacher has a value
            if ($("#ddlTeacher").val()) {
                $("#ddlStudent").prop("disabled", true);
            } else {
                $("#ddlStudent").prop("disabled", false);
            }
        },

        error: function (ex) {
            console.log(ex.responseText);
        },
    });
}

//Returned
function returnData(id) {
    Swal.fire({
        title: "សៀវត្រូវបានសង?",
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
                url: "./controllers/borrow_json.php?data=return_borrow&id=" + id,
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

//Delete
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
                url: "./controllers/borrow_json.php?data=delete_borrow&id=" + id,
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