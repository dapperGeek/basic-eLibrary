$(document).ready( function () {
    $('#bookListTable').DataTable({
        "columnDefs": [
                { "width": "10%", "targets": 0 },
                { "width": "20%", "targets": 1 },
                { "width": "15%", "targets": 2 },
                { "width": "15%", "targets": 3 },
                { "width": "15%", "targets": 4 },
                { "width": "15%", "targets": 5 }
            ],
    });
});