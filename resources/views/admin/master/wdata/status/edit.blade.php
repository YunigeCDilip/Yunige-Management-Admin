<div id="edit-custom-modal" class="modal-demo">
    <button type="button" class="close" onclick="Custombox.modal.close();">
        <span>&times;</span><span class="sr-only">Close</span>
    </button>
    <h4 class="custom-modal-title">{{__('messages.edit_data')}}</h4>
    <div class="custom-modal-text text-left">
        <form id="editForm" method="post" class="needs-validation" novalidate>
            @csrf
            <input type="hidden" name="shipper_id" value="">
            <div class="form-group">
                <label for="name">{{__('messages.name')}} <span class="text-danger">*</span></label>
                <input type="text" class="form-control" placeholder="{{__('messages.name')}}" name="name">
                <div class="invalid-feedback" id="name_error" style="display:none;"></div>
            </div>

            <div class="text-right">
                <button type="button" class="btn btn-success waves-effect waves-light update-shipper">{{__('actions.save')}}</button>
                <button type="button" class="btn btn-danger waves-effect waves-light m-l-10 cancel-shipper">{{__('actions.cancel')}}</button>
            </div>
        </form>
    </div>
</div> 