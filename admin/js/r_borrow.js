
// function displayData() {
//     $.ajax({
//         url: './controllers/r_import_json.php?data=get_import',
//         type: 'GET',
//         dataType: 'json',
//         success: function (alldata) {
//             var columns = [{
//                 title: "ល.រ"
//             }, {
//                 title: "ថ្ងៃខែឆ្នាំទទួល"
//             }, {
//                 title: "សៀវភៅ"
//             }, {
//                 title: "ម្នាស់អំណោយ"
//             },
//             {
//                 title: "ចំនួនសៀវភៅ"
//             }];
//             var data = [];
//             for (var i in alldata) {
//                 data.push(
//                     [
//                         alldata[i][0],
//                         alldata[i][1],
//                         alldata[i][2],
//                         alldata[i][3],
//                         alldata[i][4] + " ក្បាល"]);
//             }
//             console.log(data);
//             var table = $('#tableId').DataTable({
//                 destroy: true,
//                 data: data,
//                 columns: columns,
//                 responsive: true,
//                 ordering: false,
//                 lengthChange: false, // Set lengthChange to false
//                 searching: false, // Set searching to false
//                 autoWidth: false,
//                 buttons: ['pdf', 'excel'],
//                 dom: "<'row'<'col-md-5'B>>"
//             });
//         }
//     });


// }

$(document).ready(function() {
    displayData();
});
//displayData Function
function displayData() {
    $.ajax({
        url: './controllers/report_json.php?data=get_vborrow',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            var str = "<table data-ordering='false' id='table_id' class='table table-hover'>" +
                "<thead class='bg-primary text-white'><tr>" +
                "<th>ID</th>" +
                "<th>Book Title</th>" +
                "<th>Student Name</th>" +
                "<th>Borrow Date</th>" +
                "<th>Return Date</th>" +
                "<th>Create Date</th>" +
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
                str += "<td>" + data[d][5] + "</td>";
                str += "</tr>";
                total += Number(data[d][6])
            }
            str += "<tr><th colspan='5'>Total Number</th><th>" + data.length + "</th></tr>";
            str += "</table>";
            $('#display').html(str);
        },
        error: function(ex) {
            console.log(ex.responseText);


        }
    }); //ajax
}

//search Button 
$('#btnsearch').click(function() {
    var date1 = $("#date1").val();
    var date2 = $("#date2").val();
    $("#showdate").html("Date : <i>" + date1 + "</i> to  <i>" + date2 + "</i>");
    $.ajax({
        url: 'report_json.php?data=get_borrowbydate',
        type: 'GET',
        data: '&date1=' + date1 + '&date2=' + date2,
        dataType: 'json',
        success: function(data) {
            var str = "<table data-ordering='false' id='table_id' class='table table-hover'>" +
                "<thead class='bg-primary text-white'><tr>" +
                "<th>ID</th>" +
                "<th>Book Title</th>" +
                "<th>Student Name</th>" +
                "<th>Borrow Date</th>" +
                "<th>Return Date</th>" +
                "<th>Create Date</th>" +
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
                str += "<td>" + data[d][5] + "</td>";
                str += "</tr>";
                total += Number(data[d][6])
            }
            str += "<tr><th colspan='5'>Total Number</th><th>" + data.length + "</th></tr>";
            str += "</table>";
            $('#display').html(str);
        },
        error: function(ex) {
            console.log(ex.responseText);
        }
    }); //ajax
})
