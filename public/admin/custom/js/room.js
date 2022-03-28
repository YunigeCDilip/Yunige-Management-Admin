var table = $('#table').DataTable({
    order: [0, 'desc'],
    dom: 'lfrtip',
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
        url: baseUrl + 'rooms',
        type: "GET",
        dataType: 'json',

        'data': function (data) {
            data._token = csrfToken;
            data.search = $('#searchForm').val();
        },
        error: function (error) {
            console.log(error);
        }
    },
    'createdRow': function( row, data, dataIndex ) {
        $(row).attr('data-id', data.id);
    },
    columns: [
        {data: 'name'},
        {data: 'activation_code'},
        {data: 'status',
            render: function(data, type, dataObject, meta) {
                if(data){
                    return '<span class="badge badge-success">'+data+'</span>';
                }else{
                    return '<span class="badge badge-danger">Offline</span>';
                }
            }
        },
        {data: 'created_at'},
        {data: 'actions', searchable: false, orderable: false, sortable: false,
            render: function(data, type, dataObject, meta) {
                var action = '';
                action += '<a href="'+baseUrl+'rooms/'+dataObject.id+'/edit" class="action-icon edit-meeting" title="EDIT"> <i class="mdi mdi-square-edit-outline text-primary"></i></a>';
                action += '<a href="'+baseUrl+'rooms/'+dataObject.id+'/destroy" class="action-icon delete-meeting" title="DELETE"> <i class="mdi mdi-delete text-danger"></i></a>';

                return action;
            }
        }
    ],
});

$('.custom-select').on('change', function () {
    $('body').find('#table_length select').val($(this).val()).trigger('change');
});

$('#searchForm').keyup(function(){
    table.draw();
});