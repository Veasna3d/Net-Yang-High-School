
$(document).ready(function () {
    displayData();
  });
  
  //displayData Function
  function displayData() {
    $.ajax({
      url: "./controllers/report_json.php?data=get_vReader",
      type: "GET",
      dataType: "json",
      success: function (data) {
        var str =
          "<table data-ordering='false' id='table_id' class='table table-hover'>" +
          "<thead class='bg-primary text-white'><tr>" +
          "<th>ល​.រ</th>" +
          "<th>ឈ្មោះសិស្ស</th>" +
          "<th>ភេទ</th>" +
          "<th>ឈ្មោះថ្នាក់</th>" +
        "<th>ឈ្មោះសៀវភៅ</th>" +
          "</tr></thead>" +
          "<tbody>";
        var total = 0;
        for (var d in data) {
          str += "<tr>";
          str += "<td>" + data[d][0] + "</td>";
          str += "<td>" + data[d][1] + "</td>";
          str += "<td>" + data[d][2] + "</td>";
          str += "<td>" + data[d][3] + "</td>";
          str += "<td>" + data[d][4] + "</td>";
          str += "</tr>";
          total += Number(data[d][5]);
        }
        str +=
          "<tr><th colspan='6'>Total Number</th><th>" +
          data.length +
          "</th></tr>";
        str += "</table>";
        $("#display").html(str);
        var table = $("#table_id").DataTable({
          destroy: true,
          data: data,
          columns: [
            { data: "0" },
            { data: "1" },
            { data: "2" },
            { data: "3" },
            { data: "4" },

          ],
          responsive: true,
          ordering: false,
          lengthChange: false,
          // searching: true, // enable searching
          autoWidth: false,
          buttons: ["print", "pdf"],
          dom:
          "<'row'<'col-md-5'B><'col-md-7'f>>" +
          "<'row'<'col-md-12'tr>>" +
          "<'row'<'col-md-5'l>>" +
          "<'row'<'col-md-5'i><'col-md-7'p>>",
        });
      },
      error: function (ex) {
        console.log(ex.responseText);
      },
    }); //ajax
  }
  
  //search Button
  $("#btnsearch").click(function () {
    var date1 = $("#date1").val();
    var date2 = $("#date2").val();
    $("#showdate").html("Date : <i>" + date1 + "</i> to  <i>" + date2 + "</i>");
    $.ajax({
      url: "./controllers/report_json.php",
      type: "GET",
      data: { data: "get_readerbydate", date1: date1, date2: date2 },
      dataType: "json",
      success: function (data) {
        var str =
          "<table data-ordering='false' id='table_id' class='table table-hover'>" +
          "<thead class='bg-primary text-white'><tr>" +
          "<th>ល​.រ</th>" +
          "<th>ឈ្មោះសិស្ស</th>" +
          "<th>ភេទ</th>" +
          "<th>ឈ្មោះថ្នាក់</th>" +
            "<th>ឈ្មោះសៀវភៅ</th>" +
          "</tr></thead>" +
          "<tbody>";
        var total = 0;
        for (var d in data) {
          str += "<tr>";
          str += "<td>" + data[d][0] + "</td>";
          str += "<td>" + data[d][1] + "</td>";
          str += "<td>" + data[d][2] + "</td>";
          str += "<td>" + data[d][3] + "</td>";
          str += "<td>" + data[d][4] + "</td>";
          str += "</tr>";
          total += Number(data[d][5]);
        }
        str +=
          "<tr><th colspan='6'>Total Number</th><th>" +
          data.length +
          "</th></tr>";
        str += "</tbody></table>";
        $("#display").html(str);
        var columns = [
          { title: "ល.រ" },
          { title: "ឈ្មោះសិស្ស" },
          { title: "ភេទ" },
          { title: "ឈ្មោះថ្នាក់" },
          { title: "ឈ្មោះសៀវភៅ" },
        ];
        var table = $("#table_id").DataTable({
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
      error: function (ex) {
        console.log(ex.responseText);
      },
    }); //ajax
  });
  