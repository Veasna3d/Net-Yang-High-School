//Show Data
function displayData() {
    $.ajax({
      url: "./controllers/slide_json.php?data=get_slide",
      type: "Get",
      dataType: "json",
      success: function (alldata) {
        var columns = [
          {
            title: "ID",
          },
          {
            title: "TITLE",
          },
          {
            title: "SUB TITLE",
          },{
            title: "IMAGE"
          },
          {
            title: "CREATE DATE",
          },
          {
            title: "ACTIONS",
          },
        ];
        var data = [];
        var option = "";
        for (var i in alldata) {
          option =
            "<button class='btn btn-success btn-sm edit btn-flat' data-toggle='modal' data-target='#myModal' onclick='editData(" +
            alldata[i][0] +
            ")'><i class='fa fa-edit'></i> </button> | <button class='btn btn-danger btn-sm delete btn-flat' onclick='deleteData(" +
            alldata[i][0] + ")'><i class='fa fa-trash'></i> </button> ";
            data.push([
              alldata[i][0],
              alldata[i][1],
              alldata[i][2],
              "<img style='width: 120px; height: 100px;' src='upload/" + alldata[i][3] + "'>",
              alldata[i][4],
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
            buttons: ['icon pfd', 'pdf', 'excel'],
            dom: "<'row'<'col-md-5'B><'col-md-7'f>>" +
                "<'row'<'col-md-12'tr>>" +
                "<'row'<'col-md-5'l><'col-md-7 text-right'<'#btn-container'>p>>",
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
  };
  
  
  //Load
  $(document).ready(function () {
    displayData();
    
  });
  
  //btnSave
  $("#btnSave").click(function () {
      
      var title = $("#txtTitle");
      var subTitle = $("#txtSubTitle");
      
      if (title.val() == "") {
          title.focus();
          return toastr.warning("Field Require!").css("margin-top", "2rem");
      }else if (subTitle.val() == "") {
          subTitle.focus();
          return toastr.warning("Sub Title Require!").css("margin-top", "2rem");
      }
      
  
    var form_data = new FormData($("#form")[0]); // Use FormData object to include file data
    if ($("#btnSave").text() == "Insert") {
      //Insert
      $.ajax({
        type: "POST",
        url: "./controllers/slide_json.php?data=add_slide",
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
        url: "./controllers/slide_json.php?data=update_slide&id=" + slide_id,
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
    $("#txtTitle").val("");
    $("#txtSubTitle").val("");
    $("#image").val("");
    $("#btnSave").text("Insert");
  });
  
  var slide_id;
  
  function editData(id) {
    $("#btnSave").text("Update");
    slide_id = id;
    $.ajax({
      url: "./controllers/slide_json.php?data=get_byid",
      data: "&id=" + id,
      type: "GET",
      dataType: "json",
      contentType: false,
      processData: false,
      success: function (data) {
        $("#txtTitle").val(data[0][1]);
        $("#txtSubTitle").val(data[0][2]);
        $("#image").val(data[0][3]);
      },
      error: function (ex) {
        console.log(ex.responseText);
      },
    });
  }
  
  //Delete
  function deleteData(id) {
    Swal.fire({
      title: "Are you sure to delete this slide?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "GET",
          url: "./controllers/slide_json.php?data=delete_slide&id=" + id,
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
  
  
  
  
  