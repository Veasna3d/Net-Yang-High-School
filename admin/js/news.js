//Show Data

function displayData() {
  $.ajax({
    url: "./controllers/news_json.php?data=get_news",
    type: "GET",
    dataType: "json",
    success: function (alldata) {
      var columns = [
        { title: "ល.រ" },
        { title: "ចំណងជើងរង" },
        { title: "លម្អិត" },
        { title: "រូបភាព" },
        { title: "ថ្ងៃបង្កើត" },
        { title: "សកម្មភាព" },
      ];
      var data = [];
      var option = "";
      for (var i in alldata) {
        var imagesHtml = "";
        var imagesArr = alldata[i][3].split(",");
        for (var j = 0; j < imagesArr.length; j++) {
          imagesHtml +=
            "<span style='display: flex;'><img style='width: 50px; height: 40px;' src='upload/" +
            imagesArr[j] +
            "'></span>";
        }
        option =
          "<button class='btn btn-success btn-sm edit btn-flat' data-toggle='modal' data-target='#myModal' onclick='editData(" +
          alldata[i][0] +
          ")'><i class='fa fa-edit'></i> </button> | <button class='btn btn-danger btn-sm delete btn-flat' onclick='deleteData(" +
          alldata[i][0] +
          ")'><i class='fa fa-trash'></i> </button> ";
        data.push([
          alldata[i][0],
          alldata[i][1],
          alldata[i][2],
          imagesHtml,
          alldata[i][4],
          option,
        ]);
      }
      console.log(data);
      $("#tableId").DataTable({
        destroy: true,
        data: data,
        columns: columns,
        responsive: true,
        lengthChange: false,
        autoWidth: false,
        buttons: ["print", "pdf"],
        dom:
          "<'row'<'col-md-5'B><'col-md-7'f>>" +
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

//Load
$(document).ready(function () {
  displayData();
});

//btnSave
$("#btnSave").click(function () {
  var subTitle = $("#txtSubTitle");
  var detail = $("#txtDetail");

  if (subTitle.val() == "") {
    subTitle.focus();
    return toastr.warning("Field Require!").css("margin-top", "2rem");
  } else if (detail.val() == "") {
    detail.focus();
    return toastr.warning("Detail Require!").css("margin-top", "2rem");
  }

  var form_data = new FormData($("#form")[0]); // Use FormData object to include file data

  // Append multiple files to FormData object
  var imageFiles = $("#images")[0].files;
  for (var i = 0; i < imageFiles.length; i++) {
    form_data.append("image[]", imageFiles[i]);
  }

  if ($("#btnSave").text() == "Insert") {
    //Insert
    $.ajax({
      type: "POST",
      url: "./controllers/news_json.php?data=add_news",
      data: form_data,
      dataType: "json",
      contentType: false, // Set to false to let jQuery decide the content type
      processData: false, // Set to false to prevent jQuery from processing data (i.e. no stringifying)
      success: function (data) {
        toastr.success("Action completed").css("margin-top", "2rem");
        displayData();
        $("#myModal").modal("hide");
      },
      error: function (ex) {
        toastr.error("Action incomplete").css("margin-top", "2rem");
        console.log(ex.responseText);
      },
    });
  } else {
    //Update
    $.ajax({
      type: "POST",
      url: "./controllers/news_json.php?data=update_news&id=" + news_id,
      data: form_data,
      dataType: "json",
      contentType: false,
      processData: false,
      success: function (data) {
        toastr.success("Action completed").css("margin-top", "2rem");
        displayData();
        $("#myModal").modal("hide");
      },
      error: function (ex) {
        toastr.error("Action incomplete").css("margin-top", "2rem");
        console.log(ex.responseText);
      },
    });
  }
});

$("#btnAdd").click(function () {
  $("#txtSubTitle").val("");
  $("#txtDetail").val("");
  $("#image").val("");
  $("#btnSave").text("Insert");
});

var news_id;

function editData(id) {
  $("#btnSave").text("Update");
  news_id = id;
  $.ajax({
    url: "./controllers/news_json.php?data=get_byid",
    data: "&id=" + id,
    type: "GET",
    dataType: "json",
    contentType: false,
    processData: false,
    success: function (data) {
      $("#txtSubTitle").val(data[0][1]);
      $("#txtDetail").val(data[0][2]);
      $("#images").val(data[0][3]);
    },
    error: function (ex) {
      console.log(ex.responseText);
    },
  });
}

//Delete
function deleteData(id) {
  Swal.fire({
    title: "Are you sure to delete this news?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete it!",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type: "GET",
        url: "./controllers/news_json.php?data=delete_news&id=" + id,
        dataType: "json",
        success: function (data) {
          Swal.fire({
            title: "Action completed",
            icon: "success",
            showConfirmButton: false,
            timer: 2000,
          });
          displayData();
        },
        error: function (ex) {
          Swal.fire({
            title: "Action incomplete",
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
