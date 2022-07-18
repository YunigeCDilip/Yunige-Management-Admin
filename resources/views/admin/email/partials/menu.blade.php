<div class="inbox-leftbar">

    <a href="{{route('admin.emails.create')}}" class="btn btn-primary btn-rounded waves-effect waves-light">Compose Email</a>

    <div class="mail-list mt-4">
        <a href="{{route('admin.emails.index')}}" class="list-group-item border-0 @if(Route::current()->getName() == 'admin.emails.index') text-dark font-weight-bold @endif"><i class="mdi mdi-inbox font-18 align-middle mr-2"></i>Inbox<span class="badge badge-danger float-right ml-2 mt-1">@{{count.received}}</span></a>
        <a href="{{route('admin.emails.draft')}}" class="list-group-item border-0 @if(Route::current()->getName() == 'admin.emails.draft') text-dark font-weight-bold @endif"><i class="mdi mdi-file-document-box font-18 align-middle mr-2"></i>Draft<span class="badge badge-info float-right ml-2 mt-1">@{{count.draft}}</span></a>
        <a href="{{route('admin.emails.sent')}}" class="list-group-item border-0 @if(Route::current()->getName() == 'admin.emails.sent') text-dark font-weight-bold @endif"><i class="mdi mdi-send font-18 align-middle mr-2"></i>Sent Mail<span class="badge badge-success float-right ml-2 mt-1">@{{count.sent}}</span></a>
        <a href="{{route('admin.emails.trash')}}" class="list-group-item border-0 @if(Route::current()->getName() == 'admin.emails.trash') text-dark font-weight-bold @endif"><i class="mdi mdi-delete font-18 align-middle mr-2"></i>Trash<span class="badge badge-danger float-right ml-2 mt-1">@{{count.trash}}</span></a>
    </div>

    <h6 class="mt-4">Labels</h6>

    <div class="list-group b-0 mail-list">
        <a href="#" class="list-group-item border-0"><span class="mdi mdi-circle text-success mr-2"></span>Read</a>
        <a href="#" class="list-group-item border-0"><span class="mdi mdi-circle text-default mr-2"></span>Unread</a>
    </div>

</div>