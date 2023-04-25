
function displayData() {
    $.ajax({
        url: './controllers/book_json.php?data=get_book',
        type: 'GET',
        dataType: 'json',
        success: function (alldata) {
            var columns = [{
                title: "សារពើភណ្ឌ"
            }, {
                title: "ចំណងជើង"
            }, {
                title: "ឈ្មោះអ្នកនិពន្ធ"
            }, {
                title: "គ្រឹះស្ថានបោះពុម្ភ"
            }, {
                title: "ឆ្នាំបោះពុម្ភ"
            }, {
                title: "តម្លៃ"
            }, {
                title: "លេខបញ្ជី"
            },
            {
                title: "រូបភាព"
            }, {
                title: "ស្ថានភាព"
            }, {
                title: "សកម្មភាព"
            }];
            var data = [];
            var option = '';
            for (var i in alldata) {
                option = "<button class='btn btn-success btn-sm edit btn-flat' data-toggle='modal' data-target='#myModal' onclick='editData(" +
                    alldata[i][0] +
                    ")'><i class='fa fa-edit'></i> </button> | <button class='btn btn-danger btn-sm delete btn-flat' onclick='deleteData(" +
                    alldata[i][0] + ")'><i class='fa fa-trash'></i> </button> | <button class='btn btn-info btn-sm delete btn-flat' onclick='notAvailable(" +
                    alldata[i][0] + ")'><i class='fa fa-info-circle'></i> </button>";
                data.push(
                    [
                        //alldata[i][0],
                        alldata[i][1],
                        alldata[i][2],
                        alldata[i][3],
                        alldata[i][4],
                        alldata[i][5],
                        alldata[i][6] + " ៛",
                        alldata[i][7],
                        "<img style='width: 50px; height: 50px;' src='upload/" + alldata[i][8] + "'>",
                        alldata[i][9],
                        option
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
            $('#btn-container').append('<button id="btnAdd" type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">បង្កើតថ្មី</button>');
        
            // Move the custom button to the left of the other buttons
            $('.dt-buttons').prepend($('#btnAvailable'));
            $('.dt-buttons').prepend($('#btnNotAvailable'));
            $('.dt-buttons').prepend($('#btnAdd'));
            // Adjust the margins of the custom button
            $('#btnAdd').css('margin-right', '5px');
        },
        error: function (e) {
            console.log(e.responseText);
        }
    });
}

//Filter
$("#btnAvailable").click(function () {
    $.ajax({
        url: './controllers/book_json.php?data=get_book',
        type: 'GET',
        dataType: 'json',
        success: function (alldata) {
            var columns = [{
                title: "សារពើភណ្ឌ"
            }, {
                title: "ចំណងជើង"
            }, {
                title: "ឈ្មោះអ្នកនិពន្ធ"
            }, {
                title: "គ្រឹះស្ថានបោះពុម្ភ"
            }, {
                title: "ឆ្នាំបោះពុម្ភ"
            }, {
                title: "តម្លៃ"
            }, {
                title: "លេខបញ្ជី"
            },
            {
                title: "រូបភាព"
            }, {
                title: "ស្ថានភាព"
            }, {
                title: "សកម្មភាព"
            }];
            var data = [];
            var option = '';
            for (var i in alldata) {
                option = "<button class='btn btn-success btn-sm edit btn-flat' data-toggle='modal' data-target='#myModal' onclick='editData(" +
                    alldata[i][0] +
                    ")'><i class='fa fa-edit'></i> </button> | <button class='btn btn-danger btn-sm delete btn-flat' onclick='deleteData(" +
                    alldata[i][0] + ")'><i class='fa fa-trash'></i> </button> | <button class='btn btn-info btn-sm delete btn-flat' onclick='notAvailable(" +
                    alldata[i][0] + ")'><i class='fa fa-info-circle'></i> </button>";
                data.push(
                    [
                        //alldata[i][0],
                        alldata[i][1],
                        alldata[i][2],
                        alldata[i][3],
                        alldata[i][4],
                        alldata[i][5],
                        alldata[i][6] + " ៛",
                        alldata[i][7],
                        "<img style='width: 50px; height: 50px;' src='upload/" + alldata[i][8] + "'>",
                        alldata[i][9],
                        option
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
                "<'row'<'col-md-5'l><'#btn-container'>>"
            });
        
            // Add the custom button to the DataTables toolbar
            $('#btn-container').append('<button id="btnAdd" type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">បង្កើតថ្មី</button>');
        
            // Move the custom button to the left of the other buttons
            $('.dt-buttons').prepend($('#btnAvailable'));
            $('.dt-buttons').prepend($('#btnNotAvailable'));
            $('.dt-buttons').prepend($('#btnAdd'));
        
            // Adjust the margins of the custom button
            $('#btnAdd').css('margin-right', '5px');
        },
        error: function (e) {
            console.log(e.responseText);
        }
    });
});

$("#btnNotAvailable").click(function () {
    $.ajax({
        url: './controllers/book_json.php?data=not_available',
        type: 'GET',
        dataType: 'json',
        success: function (alldata) {
            var columns = [{
                title: "សារពើភណ្ឌ"
            }, {
                title: "ចំណងជើង"
            }, {
                title: "ឈ្មោះអ្នកនិពន្ធ"
            }, {
                title: "គ្រឹះស្ថានបោះពុម្ភ"
            }, {
                title: "ឆ្នាំបោះពុម្ភ"
            }, {
                title: "តម្លៃ"
            }, {
                title: "លេខបញ្ជី"
            },
            {
                title: "រូបភាព"
            }, {
                title: "ស្ថានភាព"
            }, {
                title: "សកម្មភាព"
            }];
            var data = [];
            var option = '';
            for (var i in alldata) {
                option = "<button class='btn btn-success btn-sm edit btn-flat' data-toggle='modal' data-target='#myModal' onclick='editData(" +
                    alldata[i][0] +
                    ")'><i class='fa fa-edit'></i> </button> | <button class='btn btn-danger btn-sm delete btn-flat' onclick='deleteData(" +
                    alldata[i][0] + ")'><i class='fa fa-trash'></i> </button> | <button class='btn btn-info btn-sm delete btn-flat' onclick='isAvailable(" +
                    alldata[i][0] + ")'><i class='fa fa-info-circle'></i> </button>";
                data.push(
                    [
                        //alldata[i][0],
                        alldata[i][1],
                        alldata[i][2],
                        alldata[i][3],
                        alldata[i][4],
                        alldata[i][5],
                        alldata[i][6] + " ៛",
                        alldata[i][7],
                        "<img style='width: 50px; height: 50px;' src='upload/" + alldata[i][8] + "'>",
                        alldata[i][9],
                        option
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
            $('#btn-container').append('<button id="btnAdd" type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">បង្កើតថ្មី</button>');
        
            // Move the custom button to the left of the other buttons
            $('.dt-buttons').prepend($('#btnAvailable'));
            $('.dt-buttons').prepend($('#btnNotAvailable'));
            $('.dt-buttons').prepend($('#btnAdd'));
        
            // Adjust the margins of the custom button
            $('#btnAdd').css('margin-right', '5px');
        },
        error: function (e) {
            console.log(e.responseText);
        }
    });
});



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
function setPrint(myselect, myjson, caption) {
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
                        '<option value="' + s[i][0] + '">' + s[i][1] +"|"+ s[i][2]+"</option>"
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
function setCategory(myselect, myjson, caption) {
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
                        '<option value="' + s[i][0] + '">' + s[i][1] +"|"+ s[i][2]+"</option>"
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
    setDataToSelect("#ddlAuthor", "./controllers/book_json.php?data=get_author", "ជ្រើសរើស");
    setCategory("#ddlCategory", "./controllers/book_json.php?data=get_category", "ជ្រើសរើស");
    setPrint("#ddlPrint", "./controllers/book_json.php?data=get_print", "ជ្រើសរើស");
});

//btnSave
$("#btnSave").click(function () {
    var bookTitle = $("#txtBookTitle");
    var author = $("#txtAuthor");
    var print = $("#ddlPrint");
    var publishYear = $("#txtPublishYear");
    var price = $("#txtPrice")
    var category = $("#ddlCategory")

    if (bookTitle.val() == "") {
        bookTitle.focus();
        return toastr.warning("Field Require!").css("margin-top", "2rem");
    } else if (bookTitle.val() == "") {
        bookTitle.focus();
        return toastr.warning("Book Title Require!").css("margin-top", "2rem");
    } else if (author.val() == "") {
        author.focus();
        return toastr.warning("Author Require!").css("margin-top", "2rem");
    }
    else if (print.val() == "") {
        print.focus();
        return toastr.warning("Print Require!").css("margin-top", "2rem");
    }
    else if (publishYear.val() == "") {
        publishYear.focus();
        return toastr.warning("Student Name Require!").css("margin-top", "2rem");
    }
    
    else if (price.val() == "") {
        price.focus();
        return toastr.warning("Birthday Require!").css("margin-top", "2rem");
    }else if (category.val() == "") {
        category.focus();
        return toastr.warning("Birthday Require!").css("margin-top", "2rem");
    }

    var form_data = new FormData($("#form")[0]); // Use FormData object to include file data
    if ($("#btnSave").text() == "រក្សាទុក") {
        //Insert
        $.ajax({
            type: "POST",
            url: "./controllers/book_json.php?data=add_book",
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
            url: "./controllers/book_json.php?data=update_book&id=" + book_id,
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
    $("#txtBookTitle").val("");
    $("#txtAuthor").val("");
    $("#ddlPrint").val("");
    $("#ddlCategory").val("");
    $("#txtPublishYear").val("");
    $("#txtPrice").val("");
    $("#image").val("");
    $("#btnSave").text("រក្សាទុក");
});

var book_id;

//Edit Book
function editData(id) {
    $("#btnSave").text("កែប្រែ");
    book_id = id;
    $.ajax({
        url: "./controllers/book_json.php?data=get_byid",
        data: "&id=" + id,
        type: "GET",
        dataType: "json",
        contentType: false,
        processData: false,
        success: function (data) {
            $("#txtBookTitle").val(data[0][2]);
            $("#txtAuthor").val(data[0][3]);
            $("#ddlPrint").val(data[0][4]);
            $("#txtPublishYear").val(data[0][5]);
            $("#txtPrice").val(data[0][6]);
            $("#ddlCategory").val(data[0][7]);
            $("#image").val(data[0][8]); 
        },
        error: function (ex) {
            console.log(ex.responseText);
        },
    });
}

//Delete Book
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
                url: "./controllers/book_json.php?data=delete_book&id=" + id,
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

//Not available
function notAvailable(id) {
    $.ajax({
        type: "GET",
        url: "./controllers/book_json.php?data=get_byid&id=" + id,
        dataType: "json",
        success: function (data) {
            var book = data[0];
            var modalContent = 
            '<div>'+
            '<div class="d-flex">'+
            
                '<div class="col-6">'+
                   
                    '<img src="upload/' + book[8] + '" width="100" class="card-img-top">'+
                    
                '</div>'+
                '<div class="col-6">'+
                                '<h4 class="card-header"><b>' + book[2] + '</b></h4>'+
                                '<p class="card-title pt-2">អ្នកនិពន្ធ : <b>' + book[3] + '</b></p>'+
                                '<p class="card-title pt-2">ឆ្នាំបោះពុម្ភ : <b>' + book[5] + '</b></p>'+
                                '<p class="card-title pt-2">តម្លៃ : <b>' + book[6] + '៛</b></p>'+
                                '<p class="card-title pt-2">លេខបញ្ចី : <b>' + book[7] + '</b></p>'+
                                '<p class="card-title pt-2">ស្ថានភាព : <b>' + book[9] + '</b></p>'+
                                '<p class="card-title pt-2">ចំនួនខ្ចី : <b>' + book[7] + '</b></p>'+
                                //'<p class="card-text">Hello</p>'+
                    
                '</div>'+
            '</div>'+
                '<div class="col-12 pt-4">'+
                        '<p>គ្រឹះស្ថានបោះពុម្ភ : <b>' + book[4] + '</b></p>'+
                '</div>'+
            '</div>';

            Swal.fire({
                title: 'ព័ត៌មានសៀវភៅ',
                html: modalContent,
                showCloseButton: true,
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                cancelButtonText: "No",
                confirmButtonText: "Not Available!",
                with: 1000,

                onBeforeOpen: () => {
                    const confirmButton = Swal.getConfirmButton();
                    if (student[6] == 0) {
                        confirmButton.disabled = true;
                    } else {
                        confirmButton.disabled = false;
                    }
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "GET",
                        url: "./controllers/book_json.php?data=is_not_available&id=" + id,
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

//Available
function isAvailable(id) {
    $.ajax({
        type: "GET",
        url: "./controllers/book_json.php?data=get_byid&id=" + id,
        dataType: "json",
        success: function (data) {
            var book = data[0];
            var modalContent = 
            '<div>'+
            '<div class="d-flex">'+
            
                '<div class="col-6">'+
                   
                    '<img src="upload/' + book[8] + '" width="100" class="card-img-top">'+
                    
                '</div>'+
                '<div class="col-6">'+
                                '<h4 class="card-header"><b>' + book[2] + '</b></h4>'+
                                '<p class="card-title pt-2">អ្នកនិពន្ធ : <b>' + book[3] + '</b></p>'+
                                '<p class="card-title pt-2">ឆ្នាំបោះពុម្ភ : <b>' + book[5] + '</b></p>'+
                                '<p class="card-title pt-2">តម្លៃ : <b>' + book[6] + '៛</b></p>'+
                                '<p class="card-title pt-2">លេខបញ្ចី : <b>' + book[7] + '</b></p>'+
                                '<p class="card-title pt-2">ស្ថានភាព : <b>' + book[9] + '</b></p>'+
                                '<p class="card-title pt-2">ចំនួនខ្ចី : <b>' + book[7] + '</b></p>'+
                                //'<p class="card-text">Hello</p>'+
                    
                '</div>'+
            '</div>'+
                '<div class="col-12 pt-4">'+
                        '<p>គ្រឹះស្ថានបោះពុម្ភ : <b>' + book[4] + '</b></p>'+
                '</div>'+
            '</div>';

            Swal.fire({
                title: 'ព័ត៌មានសៀវភៅ',
                html: modalContent,
                showCloseButton: true,
                showCancelButton: true,
                confirmButtonColor: "#32CD32",
                cancelButtonColor: "#3085d6",
                cancelButtonText: "No",
                confirmButtonText: "Available!",
                with: 1000,

                onBeforeOpen: () => {
                    const confirmButton = Swal.getConfirmButton();
                    if (student[6] == 0) {
                        confirmButton.disabled = true;
                    } else {
                        confirmButton.disabled = false;
                    }
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "GET",
                        url: "./controllers/book_json.php?data=is_available&id=" + id,
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
