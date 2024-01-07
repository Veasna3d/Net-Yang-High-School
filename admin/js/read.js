function displayData() {
  $.ajax({
    url: "./controllers/read_json.php?data=get_read",
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
          title: "កាលបរិច្ឆេទ",
        },
        {
          title: "សៀវភៅ",
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
          ")'><i class='fa fa-trash'></i> </button> ";
        data.push([
          number,
          alldata[i][1],
          alldata[i][2],
          alldata[i][3],
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
        buttons: ["icon pfd"],
        dom:
          "<'row'<'col-md-5'B><'col-md-7'f>>" +
          "<'row'<'col-md-12'tr>>" +
          "<'row'<'col-md-5'i><'col-md-7'p>>" +
          "<'row'<'col-md-5'l><'#btn-container'>>",
      });

      // Add the custom button to the DataTables toolbar
      $("#btn-container").append(
        '<button id="btnAdd" type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">បង្កើតថ្មី</button>'
      );

      // Move the custom button to the left of the other buttons
      $(".dt-buttons").prepend($("#btnAdd"));

      // Adjust the margins of the custom button
      $("#btnAdd").css("margin-right", "5px");
    },
    error: function (e) {
      console.log(e.responseText);
    },
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

//Load
$(document).ready(function () {
  displayData();
  setStudent(
    "#ddlStudent",
    "./controllers/read_json.php?data=get_student",
    "ជ្រើសរើស"
  );
  setBook("#ddlBook", "./controllers/read_json.php?data=get_book", "ជ្រើសរើស");
});

$("#btnSave").click(function () {
  var student = $("#ddlStudent");
  var date = $("#txtDate");
  var book = $("#ddlBook");

  if (student.val() == "") {
    student.focus();
    return toastr.warning("Field Required!").css("margin-top", "2rem");
  } else if (date.val() == "") {
    date.focus();
    return toastr.warning("Field Required!").css("margin-top", "2rem");
  } else if (book.val() == "") {
    book.focus();
    return toastr.warning("Field Required!").css("margin-top", "2rem");
  }

  var form_data = $("#form").serialize();
  if ($("#btnSave").text() == "រក្សាទុក") {
    // Insert
    $.ajax({
      type: "POST",
      url: "././controllers/read_json.php?data=add_read",
      data: form_data,
      dataType: "json",
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
    // Update
    $.ajax({
      type: "POST",
      url: "./controllers/read_json.php?data=update_read&id=" + read_id,
      data: form_data,
      dataType: "json",
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
  $("#ddlStudent").val("");
  $("#txtDate").val("");
  $("#ddlBook").val("");
  $("#btnSave").text("រក្សាទុក");
});

function clearTextbox() {
  var ddlStudentSelectize = $("#ddlStudent")[0].selectize;
  var ddlBookSelectize = $("#ddlBook")[0].selectize;

  ddlStudentSelectize.clear();
  ddlBookSelectize.clear();

  $("#txtDate").val("");
}

var read_id;

function editData(id) {
  $("#btnSave").text("កែប្រែ");
  read_id = id;
  $.ajax({
    url: "./controllers/read_json.php?data=get_byid",
    data: "&id=" + id,
    type: "GET",
    dataType: "json",
    success: function (data) {
      var ddlStudentSelectize = $("#ddlStudent")[0].selectize;
      ddlStudentSelectize.setValue(data[0][1]);
      $("#txtDate").val(data[0][2]);
      var ddlBookSelectize = $("#ddlBook")[0].selectize;
      ddlBookSelectize.setValue(data[0][3]);
    },
    error: function (ex) {
      console.log(ex.responseText);
    },
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
        url: "./controllers/read_json.php?data=delete_read&id=" + id,
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
