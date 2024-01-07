$("#btnsearch").click(function () {
    var date1 = $("#date1").val();
    var date2 = $("#date2").val();
    $("#showdate").html("Date : <i>" + date1 + "</i> to  <i>" + date2 + "</i>");
    $.ajax({
      url: "./controllers/report_json.php",
      type: "GET",
      data: { data: "get_book", date1: date1, date2: date2 },
      dataType: "json",
      success: function (alldata) {
        var columns = [
          {
            title: "សារពើភណ្ឌ",
          },
          {
            title: "ថ្ងៃខែឆ្នាំទទួល",
          },
          {
            title: "ឈ្មោះអ្នកនិពន្ធ",
          },
          {
            title: "ចំណងជើង",
          },
          {
            title: "គ្រឹះស្ថានបោះពុម្ភ",
          },
          {
            title: "ទីកន្លែងបោះពុម្ភ",
          },
          {
            title: "ឆ្នាំបោះពុម្ភ",
          },
          {
            title: "ម្ចាស់អំណោយ",
          },
          {
            title: "តម្លៃ",
          },
          {
            title: "សម្គាល់",
          },
          {
            title: "លេខបញ្ជី",
          },
        ];
        var data = [];
        var number = 0;
        for (var i in alldata) {
          number++;
          data.push([
            number,
            alldata[i][1],
            alldata[i][2],
            alldata[i][3],
            alldata[i][4],
            alldata[i][5],
            alldata[i][6],
            alldata[i][7],
            parseInt(alldata[i][8]).toLocaleString() + " ៛", 
            alldata[i][9] + " ក្បាល",
            alldata[i][10],
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
  