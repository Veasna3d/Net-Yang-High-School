
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
                    alldata[i][0] + ")'><i class='fa fa-trash'></i> </button> ";
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
                        alldata[i][8],
                        option
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
        }
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