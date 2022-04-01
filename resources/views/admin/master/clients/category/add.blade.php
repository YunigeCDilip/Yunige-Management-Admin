<div id="custom-modal" class="modal-demo">
    <button type="button" class="close" onclick="Custombox.modal.close();">
        <span>&times;</span><span class="sr-only">Close</span>
    </button>
    <h4 class="custom-modal-title">{{__('messages.add_new_category')}}</h4>
    <div class="custom-modal-text text-left">
        <form id="addForm" method="post" class="needs-validation" novalidate>
            @csrf
            <div class="form-group">
                <label for="name">{{__('messages.category_name')}} <span class="text-danger">*</span></label>
                <input type="text" class="form-control" placeholder="{{__('messages.category_name')}}" name="name">
                <div class="invalid-feedback" id="name_error" style="display:none;"></div>
            </div>

            <div class="form-group">
                <label for="status">{{__('messages.status')}}</label>
                <select class="form-control select2" name="status">
                    <option value="1" selected>{{__('messages.active')}}</option>
                    <option value="0">{{__('messages.inactive')}}</option>
                </select>
            </div>

            <div class="text-right">
                <button type="button" class="btn btn-success waves-effect waves-light save-cat">{{__('actions.save')}}</button>
                <button type="button" class="btn btn-danger waves-effect waves-light m-l-10 cancel-cat">{{__('actions.cancel')}}</button>
            </div>
        </form>
    </div>
</div> 