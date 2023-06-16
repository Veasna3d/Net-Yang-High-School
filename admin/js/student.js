
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
                    title: "ស្ថានភាព",
                }, {
                    title: "សកម្មភាព",
                },
            ];
            var data = [];
            var option = "";
            for (var i in alldata) {
                // Check if the record has an image
                var imageSrc = alldata[i][4] ? "upload/" + alldata[i][4] : "upload/user_cover.png";
                option =
                    "<button class='btn btn-info btn-sm btn-flat' onclick='viewStudentModal(" +
                    alldata[i][0] +
                    ")'><i class='fa fa-id-card'></i> </button> | <button class='btn btn-success btn-sm edit btn-flat' data-toggle='modal' data-target='#myModal' onclick='editData(" +
                    alldata[i][0] +
                    ")'><i class='fa fa-edit'></i> </button>";

                data.push([
                    alldata[i][0],
                    alldata[i][1] + "-" + alldata[i][2], // combine alldata[i][1] and alldata[i][2] with a space in between
                    alldata[i][3],
                    "<img style='width: 50px; height: 50px;' src='" + imageSrc + "'>",
                    alldata[i][5],
                    alldata[i][6],
                    alldata[i][7],
                    alldata[i][8],
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

    var start = $('#txtStartYear');
    var end = $('#txtEndYear');
    var studentName = $('#txtStudentName');
    var gender = $('#ddlGender');
    var classId = $('#ddlClass');


    if (start.val() == "") {
        start.focus();
        return toastr.warning("Field Require!").css("margin-top", "2rem");
    } else if (end.val() == "") {
        end.focus();
        return toastr.warning("Field Require!").css("margin-top", "2rem");
    } else if (studentName.val() == "") {
        studentName.focus();
        return toastr.warning("Field Require!").css("margin-top", "2rem");
    } else if (gender.val() == "") {
        gender.focus();
        return toastr.warning("Field Require!").css("margin-top", "2rem");
    } else if (classId.val() == "") {
        classId.focus();
        return toastr.warning("Field Require!").css("margin-top", "2rem");
    }


    var form_data = new FormData($("#form")[0]); // Use FormData object to include file data

    if ($("#btnSave").text() == "រក្សាទុក") {

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
function viewStudentModal(id) {
    $.ajax({
        type: "GET",
        url: "./controllers/student_json.php?data=get_byid&id=" + id,
        dataType: "json",
        success: function (data) {
            var student = data[0];
            if (student[8] === 1) {
                $.ajax({
                    type: "GET",
                    url: "./controllers/student_json.php?data=view_student&id=" + id,
                    dataType: "json",
                    success: function (data) {
                        var student = data[0];
                        var imageSrc = student[4] ? 'upload/' + student[4] : 'upload/user_cover.png';
                        // extract the student information from the JSON response
                        var modalContent = "<div class='container'>" +
                            "<div class='row d-flex justify-content-center'>" +
                            "<div class='col-md-12'>" +
                            "<div class='card p-2 text-center'>" +
                            "<div class='row'>" +
                            "<div class='col-md-12 border-right no-gutters'>" +
                            " <div class='py-3'><img src='" + imageSrc + "' width='100'>" + // add the student image as the card image
                            " <div class='allergy pt-2'>ឆ្នាំសិក្សា​ <span>" + student[1] + "-" + student[2] + "</span></div>'" +
                            "<h4 class='text-secondary'>ឈ្មោះ " + student[3] + "</h4>" +
                            "<hr>" +
                            "<div class='stats'>" +
                            "<table class='table table-borderless'>" +
                            "<tbody> " +
                            "<tr> <td>" +
                            "<div class='d-flex flex-column'> <span class='text-left head'><b>ថ្ងៃខែឆ្នាំកំណើត</b></span> <span class='text-left bottom'>" + student[7] + "</span></div></td> <td>" +
                            "<div class='d-flex flex-column'> <span class='text-left head'><b>ថ្នាក់</b></span> <span class='text-left bottom'>" + student[6] + "</span> </div></td> </tr>" +
                            "<tr> <td>" +
                            "<div class='d-flex flex-column'> <span class='text-left head'><b>ភេទ</b></span> <span class='text-left bottom'>" + student[5] + "</span></div></td> <td>" +
                            "<div class='d-flex flex-column'> <span class='text-left head'><b>ស្ថានភាព</b></span> <span class='text-left bottom'>" + student[8] + "</span> </div></td> </tr>" +
                            "</tbody></table></div></div> </div></div> </div></div></div></div>";

                        // Check if the disable_student data is equal to 0
                        Swal.fire({
                            title: "ព័ត៌មានសិស្ស",
                            html: modalContent,
                            showCloseButton: true,
                            showCancelButton: true,
                            confirmButtonColor: "#d33",
                            cancelButtonColor: "#3085d6",
                            cancelButtonText: "No",
                            confirmButtonText: "Disable",

                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    type: "GET",
                                    url: "./controllers/student_json.php?data=disable_student&id=" + id,
                                    dataType: "json",
                                    success: function (data) {
                                        Swal.fire({
                                            title: "ជោគជ័យ",
                                            icon: "success",
                                            timer: 2000,
                                        });
                                        displayData();
                                    },
                                    error: function (ex) {
                                        Swal.fire({
                                            title: "បរាជ័យ",
                                            text: ex.responseText,
                                            icon: "error",
                                            timer: 2000,
                                        });
                                        console.log(ex.responseText);
                                    },
                                });
                            }
                        });
                    },
                    error: function (ex) {
                        Swal.fire({
                            title: "Error",
                            text: ex.responseText,
                            icon: "error",
                            showConfirmButton: false,
                            timer: 1000,
                        });
                        console.log(ex.responseText);
                    },
                });
            } else {
                $.ajax({
                    type: "GET",
                    url: "./controllers/student_json.php?data=view_student&id=" + id,
                    dataType: "json",
                    success: function (data) {
                        var student = data[0];
                        // extract the student information from the JSON response
                        var imageSrc = student[4] ? 'upload/' + student[4] : 'upload/user_cover.png';
                        var modalContent = "<div class='container'>" +
                            "<div class='row d-flex justify-content-center'>" +
                            "<div class='col-md-12'>" +
                            "<div class='card p-2 text-center'>" +
                            "<div class='row'>" +
                            "<div class='col-md-12 border-right no-gutters'>" +
                            " <div class='py-3'><img src='" + imageSrc + "' width='100'>" + // add the student image as the card image
                            " <div class='allergy pt-2'>ឆ្នាំសិក្សា​ <span>" + student[1] + "-" + student[2] + "</span></div>'" +
                            "<h4 class='text-secondary'>ឈ្មោះ " + student[3] + "</h4>" +
                            "<hr>" +
                            "<div class='stats'>" +
                            "<table class='table table-borderless'>" +
                            "<tbody> " +
                            "<tr> <td>" +
                            "<div class='d-flex flex-column'> <span class='text-left head'><b>ថ្ងៃខែឆ្នាំកំណើត</b></span> <span class='text-left bottom'>" + student[7] + "</span></div></td> <td>" +
                            "<div class='d-flex flex-column'> <span class='text-left head'><b>ថ្នាក់</b></span> <span class='text-left bottom'>" + student[6] + "</span> </div></td> </tr>" +
                            "<tr> <td>" +
                            "<div class='d-flex flex-column'> <span class='text-left head'><b>ភេទ</b></span> <span class='text-left bottom'>" + student[5] + "</span></div></td> <td>" +
                            "<div class='d-flex flex-column'> <span class='text-left head'><b>ស្ថានភាព</b></span> <span class='text-left bottom'>" + student[8] + "</span> </div></td> </tr>" +
                            "</tbody></table></div></div> </div></div> </div></div></div></div>";

                        // Check if the disable_student data is equal to 0
                        Swal.fire({
                            title: "ព័ត៌មានសិស្ស",
                            html: modalContent,
                            showCloseButton: true,
                            showCancelButton: true,
                            confirmButtonColor: "",
                            cancelButtonColor: "#3085d6",
                            cancelButtonText: "No",
                            confirmButtonText: "Active",

                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    type: "GET",
                                    url: "./controllers/student_json.php?data=active_student&id=" + id,
                                    dataType: "json",
                                    success: function (data) {
                                        Swal.fire({
                                            title: "ជោគជ័យ",
                                            icon: "success",
                                            timer: 2000,
                                        });
                                        displayData();
                                    },
                                    error: function (ex) {
                                        Swal.fire({
                                            title: "បរាជ័យ",
                                            text: ex.responseText,
                                            icon: "error",
                                            timer: 2000,
                                        });
                                        console.log(ex.responseText);
                                    },
                                });
                            }
                        });
                    },
                    error: function (ex) {
                        Swal.fire({
                            title: "Error",
                            text: ex.responseText,
                            icon: "error",
                            showConfirmButton: false,
                            timer: 1000,
                        });
                        console.log(ex.responseText);
                    },
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











