
function displayData() {
    $.ajax({
        url: "./controllers/student_json.php?data=get_student",
        type: "GET",
        dataType: "json",
        success: function (alldata) {
            var columns = [
                {
                    title: "ល.រ",
                },
                {
                    title: "ឆ្នាំសិក្សា",
                },
                {
                    title: "ឈ្មោះសិស្ស",
                },
                {
                    title: "រូបភាព",
                },
                {
                    title: "ភេទ",
                }, {
                    title: "ថ្នាក់",
                }, {
                    title: "ថ្ងៃខែឆ្នាំកំណើត",
                }, {
                    title: "លេខសម្ងាត់",
                },

                {
                    title: "សកម្មភាព",
                },
            ];
            var data = [];
            var option = "";
            for (var i in alldata) {
                option =
                    "<button class='btn btn-info btn-sm edit btn-flat' data-toggle='modal' data-target='#viewData' onclick='viewData(" +
                    alldata[i][0] +
                    ")'><i class='fa fa-id-card'></i> </button> | <button class='btn btn-success btn-sm edit btn-flat' data-toggle='modal' data-target='#myModal' onclick='editData(" +
                    alldata[i][0] +
                    ")'><i class='fa fa-edit'></i> </button> | <button class='btn btn-danger btn-sm delete btn-flat' onclick='deleteData(" +
                    alldata[i][0] + ")'><i class='fa fa-trash'></i> </button>";

                data.push([
                    alldata[i][0],
                    alldata[i][1] + "-" + alldata[i][2], // combine alldata[i][1] and alldata[i][2] with a space in between
                    alldata[i][3],
                    "<img style='width: 50px; height: 50px;' src='upload/" + alldata[i][4] + "'>",
                    alldata[i][5],
                    alldata[i][6],
                    alldata[i][7],
                    "***" + alldata[i][8].slice(-2),
                    option,
                ]);

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
        error: function (e) {
            console.log(e.responseText);
        },
    });
}


function setDataToSelect(myselect, myjson, caption) {
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
                        '<option value="' + s[i][0] + '">' + s[i][1] + "</option>"
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
    setDataToSelect("#ddlClass", "./controllers/student_json.php?data=get_class", "ជ្រើសរើសថ្នាក់");
});

//btnSave
$("#btnSave").click(function () {

    var form_data = new FormData($("#form")[0]); // Use FormData object to include file data
    if ($("#btnSave").text() == "រក្សាទុក") {
        var start = $("#txtStartYear");
        var end = $("#txtEndYear");
        var studentName = $("#txtStudentName");
        var gender = $("#ddlGender");
        var classId = $("#ddlClass");
        var birthday = $("#txtBirthday");
        var password = $("#txtPassword");

        if (start.val() == "") {
            start.focus();
            return toastr.warning("Field Require!").css("margin-top", "2rem");
        } else if (start.val() == "") {
            start.focus();
            return toastr.warning("From Require!").css("margin-top", "2rem");
        } else if (end.val() == "") {
            end.focus();
            return toastr.warning("To Require!").css("margin-top", "2rem");
        }
        else if (studentName.val() == "") {
            studentName.focus();
            return toastr.warning("Student Name Require!").css("margin-top", "2rem");
        } else if (password.val() == "") {
            password.focus();
            return toastr.warning("Password Require!").css("margin-top", "2rem");
        } else if (password.val().length > 4) {
            password.focus();
            return toastr.warning("Password must be less than 5 characters long!").css("margin-top", "2rem");
        } else if (classId.val() == "") {
            classId.focus();
            return toastr.warning("Class Require!").css("margin-top", "2rem");
        }
        else if (gender.val() == "") {
            gender.focus();
            return toastr.warning("Gender Require!").css("margin-top", "2rem");
        }
        else if (birthday.val() == "") {
            birthday.focus();
            return toastr.warning("Birthday Require!").css("margin-top", "2rem");
        }
        //Insert
        $.ajax({
            type: "POST",
            url: "./controllers/student_json.php?data=add_student",
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

        var start = $("#txtStartYear");
        var end = $("#txtEndYear");
        var studentName = $("#txtStudentName");
        var gender = $("#ddlGender");
        var classId = $("#ddlClass");
        var birthday = $("#txtBirthday");
        var password = $("#txtPassword");

        if (start.val() == "") {
            start.focus();
            return toastr.warning("Field Require!").css("margin-top", "2rem");
        } else if (start.val() == "") {
            start.focus();
            return toastr.warning("From Require!").css("margin-top", "2rem");
        } else if (end.val() == "") {
            end.focus();
            return toastr.warning("To Require!").css("margin-top", "2rem");
        }
        else if (studentName.val() == "") {
            studentName.focus();
            return toastr.warning("Student Name Require!").css("margin-top", "2rem");
        } else if (password.val() == "") {
            password.focus();
            return toastr.warning("Password Require!").css("margin-top", "2rem");
        } else if (classId.val() == "") {
            classId.focus();
            return toastr.warning("Class Require!").css("margin-top", "2rem");
        }
        else if (gender.val() == "") {
            gender.focus();
            return toastr.warning("Gender Require!").css("margin-top", "2rem");
        }
        else if (birthday.val() == "") {
            birthday.focus();
            return toastr.warning("Birthday Require!").css("margin-top", "2rem");
        }
        //Update
        $.ajax({
            type: "POST",
            url: "./controllers/student_json.php?data=update_student&id=" + student_id,
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
    $("#txtStartYear").val("");
    $("#txtEndYear").val("");
    $("#txtStudentName").val("");
    $("#ddlGender").val("");
    $("#ddlClass").val("");
    $("#txtBirthday").val("");
    $("#txtPassword").val("");
    $("#image").val("");
    $("#btnSave").text("រក្សាទុក");
});

var student_id;

//Edit student
function editData(id) {
    $("#btnSave").text("Update");
    student_id = id;
    $.ajax({
        url: "./controllers/student_json.php?data=get_byid",
        data: "&id=" + id,
        type: "GET",
        dataType: "json",
        contentType: false,
        processData: false,
        success: function (data) {
            $("#txtStartYear").val(data[0][1]);
            $("#txtEndYear").val(data[0][2]);
            $("#txtStudentName").val(data[0][3]);
            $("#txtBirthday").val(data[0][7]);
            $("#ddlGender").val(data[0][5]);
            $("#ddlClass").val(data[0][6]);
            $("#txtPassword").val(data[0][8]);
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
                url: "./controllers/student_json.php?data=delete_student&id=" + id,
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

//View Student Card
// function viewData(id) {
  
//     student_id = id;
//     $.ajax({
//         url: "./controllers/student_json.php?data=get_byid",
//         data: "&id=" + id,
//         type: "GET",
//         dataType: "json",
//         contentType: false,
//         processData: false,
//         success: function (data) {
//             $("#txtVStartYear").val(data[0][1]);
//             $("#txtVEndYear").val(data[0][2]);
//             $("#txtVStudentName").val(data[0][3]);
//             $("#txtVBirthday").val(data[0][7]);
//             $("#ddlVGender").val(data[0][5]);
//             $("#ddlVClass").val(data[0][6]);
//             $("#txtVPassword").val(data[0][8]);
//             $("#vimage").val(data[0][4]);
//         },
//         error: function (ex) {
//             console.log(ex.responseText);
//         },
//     });
// }










