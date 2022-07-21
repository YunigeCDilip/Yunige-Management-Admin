@if(Route::current()->getName() != 'admin.emails.trash')
<div class="btn-group">
    <button type="button" class="btn btn-sm btn-light waves-effect" title="Trash" @click.prevent="trashMessages"><i class="mdi mdi-archive font-18"></i></button>
</div>

<div class="btn-group">
    <button type="button" class="btn btn-sm btn-light dropdown-toggle waves-effect" data-toggle="dropdown" aria-expanded="false">
        <i class="mdi mdi-dots-horizontal font-18"></i> More
        <i class="mdi mdi-chevron-down"></i>
    </button>
    <div class="dropdown-menu">
        <span class="dropdown-header">More Option :</span>
        <a class="dropdown-item" href="javascript: void(0);" @click.prevent="readMessages">Mark as Read</a>
    </div>
</div>
@endif
<div class="btn-group float-right">
    <label for="inputPassword2" class="sr-only">{{__('messages.search')}}</label>
    <input type="search" class="form-control" id="searchForm" placeholder="{{__('messages.search')}}..." v-model="search"  @keyup.prevent="filterMessages">
</div>