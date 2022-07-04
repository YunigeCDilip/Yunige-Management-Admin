function messages(message, type)
{
    !function(p){
        "use strict";
        var t=function(){};
        t.prototype.send=function(t,i,o,e,n,a,s,r){
            a||(a=3e3),s||(s=1);
            var c={heading:t,text:i,position:o,loaderBg:e,icon:n,hideAfter:a,stack:s};
            r&&(c.showHideTransition=r),p.toast().reset("all"),p.toast(c)},
            p.NotificationApp=new t,p.NotificationApp.Constructor=t
        }(window.jQuery),
        function(i){
            if(type){
                i.NotificationApp.send("Well Done!",message,"top-right","#5ba035","success");
            }else{
                i.NotificationApp.send("Oh snap!",message,"top-right","#bf441d","error")
            }
            
        }(window.jQuery);
}

var table;
$(function(){
    table = $("#table").DataTable({
        dom: 'lfrtip',
        order: [[0, 'desc']],
        lengthMenu: [25, 50, 100, 200, 500],
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
            url: baseUrl + 'outbounds',
            type: "GET",
            dataType: 'json',
            'data': function (data) {
            
            },
            error: function (error) {
                console.log(error);
            }
        },
        columns: [
            {data: 'id', visible:false},
            {data: 'name'},
            {data: 'wdata_id'},
            {data: 'warehouse_in_charge', render: function(data, type, dataObject, meta) {
                var desig = '';
                if(data){
                    $.each(data, function(index, val){
                        if(index == 0){
                            var color = 'secondary';
                        }else if(index == 1){
                            var color = 'primary';
                        }else{
                            var color = 'warning';
                        }
                        desig += '<span class="badge badge-'+color+'">'+val+'</span>';
                    });
                }else{
                    desig = '-';
                }

                return desig;
            }},
            {data: 'reserve', render: function(data, type, dataObject, meta){
                if(data){
                    return '<i class="fe-check-square text-success"></i>';
                }else{
                    return '<i class="fe-x-circle text-danger"></i>';
                }
            }},
            {data: 'ship_date'},
            {data: 'delivery_id'},
            {data: 'create_date'},
            {data: 'actions', searchable: false, orderable: false, sortable: false,
                render: function(data, type, dataObject, meta) {
                    var action = '';
                    action += '<a href="'+baseUrl+'outbounds/'+dataObject.id+'" class="action-icon"> <i class="mdi mdi-eye text-success"></i></a>';
                    // action += '<a href="'+baseUrl+'outbounds/'+dataObject.id+'/edit" class="action-icon"> <i class="mdi mdi-square-edit-outline text-primary"></i></a>';
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

$('table#table').delegate('.mdi-delete', 'click', function(e){
    e.preventDefault();
    var clientId = $(this).attr('data-id');
    swal({
        title: "Are you sure want to delete this data?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#136ba7",
        confirmButtonText: "Yes",
        cancelButtonText: "Cancel",
        closeOnConfirm: true,
        closeOnCancel: true
    }, function (isConfirm){
        if(isConfirm){
            $.ajax({
                url: baseUrl + 'outbounds/' + clientId,
                type: 'post',
                data:{ id:clientId, _method: 'DELETE', _token: csrfToken
                },
                success: function(data){
                    table.draw();
                    messages(data.message, data.status);
                },
                error: function(){},
            });
        }
    });
});

$(function(){
    $('.column-visible').multiselect({
        includeSelectAllOption: true,
      });
});