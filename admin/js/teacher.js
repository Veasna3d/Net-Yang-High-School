
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
                    title: "ស្ថានភាព",
                }, {
                    title: "សកម្មភាព",
                }
            ];
            var data = [];
            var option = "";
            var number = 0;
            for (var i in alldata) {
                number++;
                // Check if the record has an image
                var imageSrc = alldata[i][2] ? "upload/" + alldata[i][2] : "upload/user_cover.png";
                option =
                    "<button class='btn btn-info btn-sm edit btn-flat' onclick='disabledData(" +
                    alldata[i][0] +
                    ")'><i class='fa fa-id-card'></i> </button> | <button class='btn btn-success btn-sm edit btn-flat' data-toggle='modal' data-target='#myModal' onclick='editData(" +
                    alldata[i][0] +
                    ")'><i class='fa fa-edit'></i> </button> | <button class='btn btn-danger btn-sm delete btn-flat' onclick='deleteData(" +
                    alldata[i][0] + ")'><i class='fa fa-trash'></i> </button>";

                data.push([
                    number,
                    alldata[i][1],
                    "<img style='width: 50px; height: 50px;' src='" + imageSrc + "'>",
                    alldata[i][3],
                    alldata[i][4],
                    alldata[i][5],
                    option,
                ]);

            }
            console.log(data);
            $('#tableId').DataTable({
                destroy: true,
                data: data,
                columns: columns,
                order: [[0, 'desc']], 
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
        },
    });
}

//Load
$(document).ready(function () {
    displayData();
});

//btnSave
$("#btnSave").click(function () {

    var teacherName = $('#txtTeacherName');
    var gender = $('#ddlGender');
    var phone = $('#txtPhone');

    if (teacherName.val() == "") {
        teacherName.focus();
        return toastr.warning("Field Require!").css("margin-top", "2rem");
    } else if (gender.val() == "") {
        gender.focus();
        return toastr.warning("Field Require!").css("margin-top", "2rem");
    } else if (phone.val() == "") {
        phone.focus();
        return toastr.warning("Field Require!").css("margin-top", "2rem");
    }


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
                clearTextbox();
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
                clearTextbox();
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
    $("#image").val("");
    $("#btnSave").text("រក្សាទុក");
});

function clearTextbox(){
    $("#txtTeacherName").val("");
    $("#ddlGender").val("");
    $("#txtPhone").val("");
    $("#image").val("");
}

var teacher_id;

//Edit teacher
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
            $("#image").val(data[0][2]);


        },
        error: function (ex) {
            console.log(ex.responseText);
        },
    });
}

//Delete teacher
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

//disabled teacher
function disabledData(id) {
    // Make an AJAX request to retrieve the teacher data
    $.ajax({
        type: "GET",
        url: "./controllers/teacher_json.php?data=get_byid&id=" + id,
        dataType: "json",
        success: function (data) {
            var teacher = data[0];
            // Check if the status of the teacher is 0
            if (teacher[5] === 1) {
                Swal.fire({
                    title: "ប្រសិនបើអ្នកពាក្យថា Disable នោះ User មិនអាចប្រើប្រាស់ក្នុងប្រព័ន្ធបានទៀតទេ!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    cancelButtonText: "No",
                    confirmButtonText: "Disable",
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Make an AJAX request to disable the teacher
                        $.ajax({
                            type: "GET",
                            url: "./controllers/teacher_json.php?data=disable_teacher&id=" + id,
                            dataType: "json",
                            success: function () {
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
            } else {
                Swal.fire({
                    title: "ដំណើរការ User ឡើងវិញ!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "",
                    cancelButtonColor: "#3085d6",
                    cancelButtonText: "No",
                    confirmButtonText: "Active",
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Make an AJAX request to disable the teacher
                        $.ajax({
                            type: "GET",
                            url: "./controllers/teacher_json.php?data=active_teacher&id=" + id,
                            dataType: "json",
                            success: function () {
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