$(document).ready(function() {
    var a = $("#table").DataTable({
        dom: 'lfrtip',
        serverSide: true,
        responsive: true,
        processing: true,
        buttons: ["copy", "print", "pdf"],
        language: {
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'>",
                next: "<i class='mdi mdi-chevron-right'>"
            }
        },
        "ajax": {
            url: baseUrl + 'wdata',
            type: "GET",
            dataType: 'json',
            'data': function (data) {
            
            },
            error: function (error) {
                console.log(error);
            }
        },
        'createdRow': function( row, data, dataIndex ) {
            $(row).attr('data-id', data.id);
        },
        columns: [
            {data: 'Name'},
            {data: 'country'},
            {data: 'clientName'},
            {data: 'jobType'},
            {data: 'job',
                render: function(data, type, dataObject, meta) {
                    var html = '';
                    if(data != ''){
                        $.each(data, function(key, val){
                            html += '<span class="badge bg-soft-success text-success">'+val+'</span>';
                        });
                    }
                    return html
                }
            },
            {data: 'category'},
            {data: 'permitNo'},
            {data: 'trkNo'},
            {data: 'deliver'},
            {data: 'status'},
            {data: 'createdTime'},
            {data: 'actions', searchable: false, orderable: false, sortable: false,
                render: function(data, type, dataObject, meta) {
                    var action = '';
                    action += '<a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-square-edit-outline"></i></a>';
                    action += '<a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-delete"></i></a>';
                    
                    return action;
                }
            }
        ],
        drawCallback: function() {
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
        }
    });
});