$("#btnsearch").click(function () {
  var date1 = $("#date1").val();
  var date2 = $("#date2").val();
  $("#showdate").html("Date : <i>" + date1 + "</i> to  <i>" + date2 + "</i>");
  $.ajax({
    url: "./controllers/report_json.php",
    type: "GET",
    data: { data: "get_studentBorrow", date1: date1, date2: date2 },
    dataType: "json",
    success: function (alldata) {
      var columns = [
        {
          title: "ល.រ",
        },
        {
          title: "ចំណងជើងសៀវភៅ",
        },
        {
          title: "ឈ្មោះសិស្ស",
        },
        {
          title: "ថ្នាក់",
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
      ];
      var data = [];
      for (var i in alldata) {
        data.push([
          alldata[i][0],
          alldata[i][1],
          alldata[i][2],
          alldata[i][3],
          alldata[i][4],
          alldata[i][5],
          alldata[i][6],
          alldata[i][7],
        ]);
      }
      console.log(data);
      $("#tableId").DataTable({
        destroy: true,
        data: data,
        columns: columns,
        pageLength: 10,
        language: {
          info: "Showing _START_ to _END_ of _TOTAL_ entries",
          infoEmpty: "Showing 0 entries",
          infoFiltered: "(filtered from _MAX_ total entries)",
        },
        responsive: true,
        lengthChange: false,
        autoWidth: false,
        buttons: [
          {
            extend: "excel",
            className: "btn btn-success",
            text: '<i class="fa fa-file-excel"> Excel</i> ',
          },
          {
            extend: "print",
            className: "btn btn-primary",
            text: '<i class="fa fa-print"> Print</i> ',
          },
        ],
        dom:
          "<'row'<'col-md-5'B><'col-md-7'f>>" +
          "<'row'<'col-md-12'tr>>" +
          "<'row'<'col-md-5'i><'col-md-7'p>>",
      });
    },
    error: function (ex) {
      console.log(ex.responseText);
    },
  }); //ajax
});
