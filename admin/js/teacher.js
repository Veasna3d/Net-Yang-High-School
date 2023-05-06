
function displayData() {
    $.ajax({
        url: "./controllers/teacher_json.php?data=get_teacher",
        type: "GET",
        dataType: "json",
        success: function (alldata) {
            var columns = [
                {
                    title: "ល.រ",
                }, {
                    title: "ឈ្មោះគ្រូ",
                }, {
                    title: "រូបភាព",
                }, {
                    title: "ភេទ",
                }, {
                    title: "លេខទូរស័ព្ទ",
                }, {
                    title: "លេខសម្ងាត់",
                }, {
                    title: "ស្ថានភាព",
                }, {
                    title: "សកម្មភាព",
                }
            ];
            var data = [];
            var option = "";
            for (var i in alldata) {
                option =
                    "<button class='btn btn-info btn-sm edit btn-flat' onclick='disabledData(" +
                    alldata[i][0] +
                    ")'><i class='fa fa-id-card'></i> </button> | <button class='btn btn-success btn-sm edit btn-flat' data-toggle='modal' data-target='#myModal' onclick='editData(" +
                    alldata[i][0] +
                    ")'><i class='fa fa-edit'></i> </button> | <button class='btn btn-danger btn-sm delete btn-flat' onclick='deleteData(" +
                    alldata[i][0] + ")'><i class='fa fa-trash'></i> </button>";

                data.push([
                    alldata[i][0],
                    alldata[i][1],
                    "<img style='width: 50px; height: 50px;' src='upload/" + alldata[i][2] + "'>",
                    alldata[i][3],
                    alldata[i][4],
                    "***" + alldata[i][7].slice(-2),
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
        },
    });
}

//Load
$(document).ready(function () {
    displayData();
});

//btnSave
$("#btnSave").click(function () {
    // var start = $("#txtStartYear");
    // var end = $("#txtEndYear");
    // var studentName = $("#txtStudentName");
    // var gender = $("#ddlGender");
    // var classId = $("#ddlClass");
    // var birthday = $("#txtBirthday");
    // var password = $("#txtPassword");

    // if (start.val() == "") {
    //     start.focus();
    //     return toastr.warning("Field Require!").css("margin-top", "2rem");
    // } else if (start.val() == "") {
    //     start.focus();
    //     return toastr.warning("From Require!").css("margin-top", "2rem");
    // } else if (end.val() == "") {
    //     end.focus();
    //     return toastr.warning("To Require!").css("margin-top", "2rem");
    // }
    // else if (studentName.val() == "") {
    //     studentName.focus();
    //     return toastr.warning("Student Name Require!").css("margin-top", "2rem");
    // } else if (password.val() == "") {
    //     password.focus();
    //     return toastr.warning("Password Require!").css("margin-top", "2rem");
    // } else if (password.val().length > 4) {
    //     password.focus();
    //     return toastr.warning("Password must be less than 5 characters long!").css("margin-top", "2rem");
    // } else if (classId.val() == "") {
    //     classId.focus();
    //     return toastr.warning("Class Require!").css("margin-top", "2rem");
    // }
    // else if (gender.val() == "") {
    //     gender.focus();
    //     return toastr.warning("Gender Require!").css("margin-top", "2rem");
    // }
    // else if (birthday.val() == "") {
    //     birthday.focus();
    //     return toastr.warning("Birthday Require!").css("margin-top", "2rem");
    // }
    var form_data = new FormData($("#form")[0]); // Use FormData object to include file data
    if ($("#btnSave").text() == "រក្សាទុក") {
        //Insert
        $.ajax({
            type: "POST",
            url: "./controllers/teacher_json.php?data=add_teacher",
            data: form_data,
            dataType: "json",
            contentType: false, // Set to false to let jQuery decide the content type
            processData: false, // Set to false to prevent jQuery from processing data (i.e. no stringifying)
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
        //Update
        $.ajax({
            type: "POST",
            url: "./controllers/teacher_json.php?data=update_teacher&id=" + teacher_id,
            data: form_data,
            dataType: "json",
            contentType: false,
            processData: false,
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
    $("#txtTeacherName").val("");
    $("#ddlGender").val("");
    $("#txtPhone").val("");
    $("#txtPassword").val("");
    $("#image").val("");
    $("#btnSave").text("រក្សាទុក");
});

var teacher_id;

//Edit student
function editData(id) {
    $("#btnSave").text("Update");
    teacher_id = id;
    $.ajax({
        url: "./controllers/teacher_json.php?data=get_byid",
        data: "&id=" + id,
        type: "GET",
        dataType: "json",
        contentType: false,
        processData: false,
        success: function (data) {
            $("#txtTeacherName").val(data[0][1]);
            $("#ddlGender").val(data[0][3]);
            $("#txtPhone").val(data[0][4]);
            $("#txtPassword").val(data[0][5]);
            $("#image").val(data[0][2]);


        },
        error: function (ex) {
            console.log(ex.responseText);
        },
    });
}

//Delete Student
function deleteData(id) {
    Swal.fire({
        title: "តើអ្នកចង់លុបសិស្សនេះចេញពីប្រព័ន្ធ?",
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

function disabledData(id) {
    Swal.fire({
        title: "ប្រសិនបើអ្នកពាក្យថា Inactive នោះ User មិនអាចប្រើប្រាស់ក្នុងប្រព័ន្ធបានទៀតទេ!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        cancelButtonText: "No",
        confirmButtonText: "Inactive!",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "GET",
                url: "./controllers/teacher_json.php?data=disable_teacher&id=" + id,
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









