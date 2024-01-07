function displayData() {
  $.ajax({
    url: "./controllers/borrow_json.php?data=get_borrow",
    type: "GET",
    dataType: "json",
    success: function (alldata) {
      var columns = [
        {
          title: "ល.រ",
        },
        {
          title: "សិស្ស",
        },
        {
          title: "គ្រូ",
        },
        {
          title: "សៀវភៅ",
        },
        {
          title: "កាលបរិច្ឆេទខ្ចី",
        },
        {
          title: "កាលបរិច្ឆេទសង",
        },
        {
          title: "ស្ថានភាព",
        },
        {
          title: "សម្គាល់",
        },
        {
          title: "សកម្មភាព",
        },
      ];
      var data = [];
      var option = "";
      var number = 0;
      for (var i in alldata) {
        number++;
        option =
          "<button class='btn btn-success btn-sm edit btn-flat' data-toggle='modal' data-target='#myModal' onclick='editData(" +
          alldata[i][0] +
          ")'><i class='fa fa-edit'></i> </button> | <button class='btn btn-danger btn-sm delete btn-flat' onclick='deleteData(" +
          alldata[i][0] +
          ")'><i class='fa fa-trash'></i> </button> | <button class='btn btn-info btn-sm btn-flat' onclick='returnData(" +
          alldata[i][0] +
          ")'><i class='fa fa-reply'></i> </button>";
        data.push([
          number,
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
      $("#tableId").DataTable({
        destroy: true,
        data: data,
        columns: columns,
        order: [[0, "desc"]],
        pageLength: 10,
        language: {
          info: "Showing _START_ to _END_ of _TOTAL_ entries",
          infoEmpty: "Showing 0 entries",
          infoFiltered: "(filtered from _MAX_ total entries)",
        },
        responsive: true,
        lengthChange: false,
        autoWidth: false,
        buttons: ["icon pfd"], // remove 'pdf' and 'excel'
        dom:
          "<'row'<'col-md-5'B><'col-md-7'f>>" +
          "<'row'<'col-md-12'tr>>" +
          "<'row'<'col-md-5'i><'col-md-7'p>>" +
          "<'row'<'col-md-5'l><'#btn-container'>>",
      });

      var btn1 = $("<button>").attr({
        id: "btnBorrow",
        type: "button",
        class: "btn btn-success",
      });
      btn1.append("បានខ្ចី");

      var btn2 = $("<button>").attr({
        id: "btnReturn",
        type: "button",
        class: "btn btn-info",
      });
      btn2.append("បានសង");

      // Add the custom button to the DataTables toolbar
      $("#btn-container").append(btn1, btn2);
      $("#btn-container").append(
        '<button id="btnAdd" type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">បង្កើតថ្មី</button>'
      );

      // Register event handlers for custom buttons
      registerCustomButtonHandlers();

      // Move the custom button to the left of the other buttons
      $(".dt-buttons").prepend(btn1, btn2);
      $(".dt-buttons").prepend($("#btnAdd"));

      // Adjust the margins of the custom button
      $("#btnAdd").css("margin-right", "5px");
    },
    error: function (e) {
      console.log(e.responseText);
    },
  });
}

//Filter
function registerCustomButtonHandlers() {
  $("#btnBorrow").on("click", function () {
    $.ajax({
      url: "./controllers/borrow_json.php?data=get_borrow",
      type: "GET",
      dataType: "json",
      success: function (alldata) {
        var columns = [
          {
            title: "ល.រ",
          },
          {
            title: "សិស្ស",
          },
          {
            title: "គ្រូ",
          },
          {
            title: "សៀវភៅ",
          },
          {
            title: "កាលបរិច្ឆេទខ្ចី",
          },
          {
            title: "កាលបរិច្ឆេទសង",
          },
          {
            title: "ស្ថានភាព",
          },
          {
            title: "សម្គាល់",
          },
          {
            title: "សកម្មភាព",
          },
        ];
        var data = [];
        var option = "";
        var number = 0;
        for (var i in alldata) {
          number++;
          option =
            "<button class='btn btn-success btn-sm edit btn-flat' data-toggle='modal' data-target='#myModal' onclick='editData(" +
            alldata[i][0] +
            ")'><i class='fa fa-edit'></i> </button> | <button class='btn btn-danger btn-sm delete btn-flat' onclick='deleteData(" +
            alldata[i][0] +
            ")'><i class='fa fa-trash'></i> </button> | <button class='btn btn-info btn-sm btn-flat' onclick='returnData(" +
            alldata[i][0] +
            ")'><i class='fa fa-reply'></i> </button>";
          data.push([
            number,
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
        $("#tableId").DataTable({
          destroy: true,
          data: data,
          columns: columns,
          order: [[0, "desc"]],
          pageLength: 10,
          language: {
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            infoEmpty: "Showing 0 entries",
            infoFiltered: "(filtered from _MAX_ total entries)",
          },
          responsive: true,
          lengthChange: false,
          autoWidth: false,
          buttons: ["icon pfd"], // remove 'pdf' and 'excel'
          dom:
            "<'row'<'col-md-5'B><'col-md-7'f>>" +
            "<'row'<'col-md-12'tr>>" +
            "<'row'<'col-md-5'i><'col-md-7'p>>" +
            "<'row'<'col-md-5'l><'#btn-container'>>",
        });

        var btn1 = $("<button>").attr({
          id: "btnBorrow",
          type: "button",
          class: "btn btn-success",
        });
        btn1.append("បានខ្ចី");

        var btn2 = $("<button>").attr({
          id: "btnReturn",
          type: "button",
          class: "btn btn-info",
        });
        btn2.append("បានសង");

        // Add the custom button to the DataTables toolbar
        $("#btn-container").append(btn1, btn2);
        $("#btn-container").append(
          '<button id="btnAdd" type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">បង្កើតថ្មី</button>'
        );

        // Register event handlers for custom buttons
        registerCustomButtonHandlers();

        // Move the custom button to the left of the other buttons
        $(".dt-buttons").prepend(btn1, btn2);
        $(".dt-buttons").prepend($("#btnAdd"));

        // Adjust the margins of the custom button
        $("#btnAdd").css("margin-right", "5px");
      },
      error: function (e) {
        console.log(e.responseText);
      },
    });
  });

  $("#btnReturn").on("click", function () {
    $.ajax({
      url: "./controllers/borrow_json.php?data=get_return",
      type: "GET",
      dataType: "json",
      success: function (alldata) {
        var columns = [
          {
            title: "ល.រ",
          },
          {
            title: "សិស្ស",
          },
          {
            title: "គ្រូ",
          },
          {
            title: "សៀវភៅ",
          },
          {
            title: "កាលបរិច្ឆេទខ្ចី",
          },
          {
            title: "កាលបរិច្ឆេទសង",
          },
          {
            title: "ស្ថានភាព",
          },
          {
            title: "សម្គាល់",
          },
          {
            title: "សកម្មភាព",
          },
        ];
        var data = [];
        var option = "";
        var number = 0;
        for (var i in alldata) {
          number++;
          option =
            "<button class='btn btn-danger btn-sm delete btn-flat' onclick='deleteData(" +
            alldata[i][0] +
            ")'><i class='fa fa-trash'></i> </button>";
          data.push([
            number,
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
        $("#tableId").DataTable({
          destroy: true,
          data: data,
          columns: columns,
          order: [[0, "desc"]],
          pageLength: 10,
          language: {
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            infoEmpty: "Showing 0 entries",
            infoFiltered: "(filtered from _MAX_ total entries)",
          },
          responsive: true,
          lengthChange: false,
          autoWidth: false,
          buttons: ["icon pfd"], // remove 'pdf' and 'excel'
          dom:
            "<'row'<'col-md-5'B><'col-md-7'f>>" +
            "<'row'<'col-md-12'tr>>" +
            "<'row'<'col-md-5'i><'col-md-7'p>>" +
            "<'row'<'col-md-5'l><'#btn-container'>>",
        });

        var btn1 = $("<button>").attr({
          id: "btnBorrow",
          type: "button",
          class: "btn btn-success",
        });
        btn1.append("បានខ្ចី");

        var btn2 = $("<button>").attr({
          id: "btnReturn",
          type: "button",
          class: "btn btn-info",
        });
        btn2.append("បានសង");

        // Add the custom button to the DataTables toolbar
        $("#btn-container").append(btn1, btn2);
        $("#btn-container").append(
          '<button id="btnAdd" type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">បង្កើតថ្មី</button>'
        );

        // Register event handlers for custom buttons
        registerCustomButtonHandlers();

        // Move the custom button to the left of the other buttons
        $(".dt-buttons").prepend(btn1, btn2);
        $(".dt-buttons").prepend($("#btnAdd"));

        // Adjust the margins of the custom button
        $("#btnAdd").css("margin-right", "5px");
      },
      error: function (e) {
        console.log(e.responseText);
      },
    });
  });
}

function setStudent(myselect, myjson, caption) {
  try {
    var sel = $(myselect);

    if (sel[0] && sel[0].selectize) {
      sel[0].selectize.destroy();
    }

    sel.empty();

    sel.selectize({
      create: false,
      placeholder: caption,
      allowClear: true,
      onInitialize: function () {
        this.$input.attr("id", "ddlStudent");
      },
    });

    $.ajax({
      url: myjson,
      dataType: "json",
      success: function (s) {
        var selectize = sel[0].selectize;
        selectize.clearOptions();

        for (var i = 0; i < s.length; i++) {
          var displayText = s[i][3] + "|ភេទ " + s[i][5] + "|ថ្នាក់ " + s[i][6];
          selectize.addOption({
            value: s[i][0],
            text: displayText,
          });
        }

        selectize.settings.placeholder = caption;
        selectize.updatePlaceholder();
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

    if (sel[0] && sel[0].selectize) {
      sel[0].selectize.destroy();
    }

    sel.empty();

    sel.selectize({
      create: false,
      placeholder: caption,
      allowClear: true,
      onInitialize: function () {
        this.$input.attr("id", "ddlBook");
      },
    });

    $.ajax({
      url: myjson,
      dataType: "json",
      success: function (s) {
        var selectize = sel[0].selectize;
        selectize.clearOptions();

        for (var i = 0; i < s.length; i++) {
          var displayText = s[i][2] + "|" + s[i][7];
          selectize.addOption({
            value: s[i][0],
            text: displayText,
          });
        }

        selectize.settings.placeholder = caption;
        selectize.updatePlaceholder();
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

    if (sel[0] && sel[0].selectize) {
      sel[0].selectize.destroy();
    }

    sel.empty();

    sel.selectize({
      create: false,
      placeholder: caption,
      allowClear: true,
      onInitialize: function () {
        this.$input.attr("id", "ddlTeacher");
      },
    });

    $.ajax({
      url: myjson,
      dataType: "json",
      success: function (s) {
        var selectize = sel[0].selectize;
        selectize.clearOptions();

        for (var i = 0; i < s.length; i++) {
          var displayText = s[i][1];
          selectize.addOption({
            value: s[i][0],
            text: displayText,
          });
        }

        selectize.settings.placeholder = caption;
        selectize.updatePlaceholder();
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

  var ddlStudentSelectize = $("#ddlStudent")[0].selectize;
  var ddlTeacherSelectize = $("#ddlTeacher")[0].selectize;

  ddlStudentSelectize.on("change", function () {
    var ddlStudentValue = ddlStudentSelectize.getValue();
    ddlTeacherSelectize.disable(!!ddlStudentValue);
  });

  ddlTeacherSelectize.on("change", function () {
    var ddlTeacherValue = ddlTeacherSelectize.getValue();
    ddlStudentSelectize.disable(!!ddlTeacherValue);
  });
});

// $("#btnSave").click(function () {

//     var book = $("#ddlBook");
//     var borrowDate = $("#txtBorrowDate");
//     var returnDate = $("#txtReturnDate");

//     if (book.val() == "") {
//         book.focus();
//         return toastr.warning("បញ្ចូលទិន្នន័យ!").css("margin-top", "2rem");
//     } else if (borrowDate.val() == "") {
//         borrowDate.focus();
//         return toastr.warning("ថ្ងៃខែឆ្នាំខ្ចី!").css("margin-top", "2rem");
//     } else if (returnDate.val() == "") {
//         returnDate.focus();
//         return toastr.warning("ថ្ងៃខែឆ្នាំសង!").css("margin-top", "2rem");
//     }

//     var form_data = $("#form").serialize();
//     if ($("#btnSave").text() == "រក្សាទុក") {
//         // Insert
//         $.ajax({
//             type: "POST",
//             url: "./controllers/borrow_json.php?data=add_borrow",
//             data: form_data,
//             dataType: "json",
//             success: function (data) {
//                 toastr.success("ជោគជ័យ").css("margin-top", "2rem");
//                 displayData();
//                 $("#myModal").modal("hide");
//                 clearTextbox();
//             },
//             error: function (ex) {
//                 toastr.error("បរាជ័យ").css("margin-top", "2rem");
//                 console.log(ex.responseText);
//             },
//         });
//     } else {
//         // Update
//         $.ajax({
//             type: "POST",
//             url:
//                 "./controllers/borrow_json.php?data=update_borrow&id=" + borrow_id,
//             data: form_data,
//             dataType: "json",
//             success: function (data) {
//                 toastr.success("ជោគជ័យ").css("margin-top", "2rem");
//                 displayData();
//                 $("#myModal").modal("hide");
//                 clearTextbox();
//             },
//             error: function (ex) {
//                 toastr.error("បរាជ័យ").css("margin-top", "2rem");
//                 console.log(ex.responseText);
//             },
//         });
//     }
// });

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
        if (data === "Book not found") {
          toastr.error("សៀវភៅមិនទាន់ធ្វើការនាំចូល!").css("margin-top", "2rem");
        } else if (data === "Book quantity is 0") {
          toastr.error("សៀវភៅមិនមាននៅក្នុងបណ្ណាល័យ!").css("margin-top", "2rem");
        } else {
          toastr.success("ជោគជ័យ").css("margin-top", "2rem");
          displayData();
          $("#myModal").modal("hide");
          clearTextbox();
        }
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
      url: "./controllers/borrow_json.php?data=update_borrow&id=" + borrow_id,
      data: form_data,
      dataType: "json",
      success: function (data) {
        if (data === "Book not found") {
          toastr.error("សៀវភៅមិនទាន់ធ្វើការនាំចូល!").css("margin-top", "2rem");
        } else if (data === "Book quantity is 0") {
          toastr.error("សៀវភៅមិនមាននៅក្នុងបណ្ណាល័យ!").css("margin-top", "2rem");
        } else {
          toastr.success("ជោគជ័យ").css("margin-top", "2rem");
          displayData();
          $("#myModal").modal("hide");
          clearTextbox();
        }
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

function clearTextbox() {
  var ddlStudentSelectize = $("#ddlStudent")[0].selectize;
  var ddlTeacherSelectize = $("#ddlTeacher")[0].selectize;
  var ddlBookSelectize = $("#ddlBook")[0].selectize;

  ddlStudentSelectize.clear();
  ddlTeacherSelectize.clear();
  ddlBookSelectize.clear();

  $("#txtBorrowDate").val("");
  $("#txtReturnDate").val("");
  $("#txtRemark").val("");
}

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
      var ddlStudentSelectize = $("#ddlStudent")[0].selectize;
      ddlStudentSelectize.setValue(data[0][1]);
      var ddlTeacherSelectize = $("#ddlTeacher")[0].selectize;
      ddlTeacherSelectize.setValue(data[0][2]);
      var ddlBookSelectize = $("#ddlBook")[0].selectize;
      ddlBookSelectize.setValue(data[0][3]);
      $("#txtBorrowDate").val(data[0][4]);
      $("#txtReturnDate").val(data[0][5]);
      $("#txtRemark").val(data[0][6]);
    },

    error: function (ex) {
      console.log(ex.responseText);
    },
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

//Returned
function returnData(id) {
  $.ajax({
    type: "GET",
    url: "./controllers/borrow_json.php?data=get_borrow_detail&id=" + id,
    dataType: "json",
    success: function (data) {
      var borrow = data[0];
      var modalContent =
        "<div>" +
        '<div class="d-flex">' +
        '<div class="col-12">' +
        '<h5 class="card-header">សៀវភៅ : <b>' +
        borrow[4] +
        "</b></h5>";

      if (borrow[1] && borrow[2]) {
        modalContent +=
          '<ul class="list-group">' +
          '<li class="card-title pt-2 text-left">អ្នកខ្ចី : <b>' +
          borrow[1] +
          "</b></li>" +
          '<li class="card-title pt-2 text-left">ថ្នាក់ : <b>' +
          borrow[2] +
          "</b></li>" +
          "</ul>";
      } else if (borrow[3]) {
        modalContent +=
          '<ul class="list-group">' +
          '<li class="card-title pt-2 text-left">អ្នកខ្ចី : <b>' +
          borrow[3] +
          "</b></li>" +
          "</ul>";
      }

      modalContent +=
        '<ul class="list-group">' +
        '<li class="card-title pt-2 text-left">ថ្ងៃខ្ចី : <b>' +
        borrow[5] +
        "</b></li>" +
        '<li class="card-title pt-2 text-left">ថ្ងៃត្រូវសង : <b>' +
        borrow[6] +
        "</b></li>" +
        "</ul>" +
        "</div>" +
        "</div>" +
        '<div class="col-12 pt-4">' +
        '<p class="card-title pt-2 text-left">កំណត់សម្គាល់ : <b>' +
        borrow[7] +
        "</b></p>" +
        "</div>" +
        "</div>";

      Swal.fire({
        // title: 'ព័ត៌មានសៀវភៅ',
        html: modalContent,
        showCloseButton: true,
        showCancelButton: true,
        confirmButtonColor: "#30d",
        cancelButtonColor: "#3085d6",
        cancelButtonText: "ទេ",
        confirmButtonText: "សៀវភៅត្រូវបានសង!",
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
            url: "./controllers/borrow_json.php?data=return_borrow&id=" + id,
            dataType: "json",
            success: function (data) {
              Swal.fire({
                title: "ជោគជ័យ",
                icon: "success",
                timer: 1500,
              });
              displayData();
            },
            error: function (ex) {
              Swal.fire({
                title: "បរាជ័យ",
                text: ex.responseText,
                icon: "error",
                timer: 1500,
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
