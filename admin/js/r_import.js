
function displayData() {
    $.ajax({
        url: './controllers/r_import_json.php?data=get_import',
        type: 'GET',
        dataType: 'json',
        success: function (alldata) {
            var columns = [{
                title: "ល.រ"
            }, {
                title: "ថ្ងៃខែឆ្នាំទទួល"
            }, {
                title: "សៀវភៅ"
            }, {
                title: "ម្នាស់អំណោយ"
            },
            {
                title: "ចំនួនសៀវភៅ"
            }];
            var data = [];
            for (var i in alldata) {
                data.push(
                    [
                        alldata[i][0],
                        alldata[i][1],
                        alldata[i][2],
                        alldata[i][3],
                        alldata[i][4] + " ក្បាល"]);
            }
            console.log(data);
            var table = $('#tableId').DataTable({
                destroy: true,
                data: data,
                columns: columns,
                responsive: true,
                ordering: false,
                lengthChange: false, // Set lengthChange to false
                searching: false, // Set searching to false
                autoWidth: false,
                buttons: ['pdf', 'excel'],
                dom: "<'row'<'col-md-5'B>>"
            });

            // Add a search date range
            var start = moment();
            var end = moment();
            var dateRangeHtml = '<div class="form-group">' +
                '<label for="date-range">ថ្ងៃខែឆ្នាំទទួល:</label>' +
                '<input type="text" id="date-range" class="form-control">' +
                '</div>';
            $(dateRangeHtml).insertBefore('#tableId_wrapper');

            $('#date-range').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            });
            // Filter the data based on the selected date range
            $('#date-range').on('apply.daterangepicker', function (ev, picker) {
                var startDate = picker.startDate.format('YYYY-MM-DD');
                var endDate = picker.endDate.format('YYYY-MM-DD');
                table.columns(1).search(startDate + ' - ' + endDate).draw();
            });

            // Clear the date range filter
            $('#date-range').on('cancel.daterangepicker', function (ev, picker) {
                table.columns(1).search('').draw();
            });
        }
    });


}

// Call the displayData function when the page is loaded
$(document).ready(function () {
    displayData();
});