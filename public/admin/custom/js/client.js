$(function(){
    $(".select2").select2();
});

$(function(){
    var a = $("#table").DataTable({
        dom: 'lfrtip',
        lengthMenu: [ 10, 25, 50, 100, 200, 500],
        serverSide: true,
        responsive: true,
        processing: true,
        language: {
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'>",
                next: "<i class='mdi mdi-chevron-right'>"
            }
        },
        "ajax": {
            url: baseUrl + 'clients',
            type: "GET",
            dataType: 'json',
            'data': function (data) {
            
            },
            error: function (error) {
                console.log(error);
            }
        },
        columns: [
            {data: 'serial_number',
                render: function(data, type, dataObject, meta) {
                    return 'c'+dataObject.serial_number;
                }
            },
            {data: 'client_name'},
            {data: 'category_name'},
            {data: 'shipper_name'},
            {data: 'resp_person'},
            {data: 'contact_no'},
            {data: 'actions', searchable: false, orderable: false, sortable: false,
                render: function(data, type, dataObject, meta) {
                    var action = '';
                    action += '<a href="'+baseUrl+'wdata/'+dataObject.id+'" class="action-icon"> <i class="mdi mdi-eye text-success"></i></a>';
                    action += '<a href="'+baseUrl+'wdata/'+dataObject.id+'/edit" class="action-icon"> <i class="mdi mdi-square-edit-outline text-primary"></i></a>';
                    action += '<a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-delete text-danger" data-id="'+dataObject.id+'"></i></a>';
                    
                    return action;
                }
            }
        ],
        drawCallback: function() {
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
        }
    });
});

$('.custom-select').on('change', function () {
    $('body').find('#table_length select').val($(this).val()).trigger('change');
});

$('#searchForm').keyup(function(){
    $('body').find('#table_filter input').val($(this).val()).trigger('keyup');
});