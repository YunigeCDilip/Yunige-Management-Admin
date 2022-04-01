<div id="custom-modal" class="modal-demo">
    <button type="button" class="close" onclick="Custombox.modal.close();">
        <span>&times;</span><span class="sr-only">Close</span>
    </button>
    <h4 class="custom-modal-title">{{__('messages.add_new_shipper')}}</h4>
    <div class="custom-modal-text text-left">
        <form id="addForm" method="post" class="needs-validation" novalidate>
            @csrf
            <div class="form-group">
                <label for="shipper_name">{{__('messages.shipper_name')}} <span class="text-danger">*</span></label>
                <input type="text" class="form-control" placeholder="{{__('messages.shipper_name')}}" name="shipper_name">
                <div class="invalid-feedback" id="shipper_name_error" style="display:none;"></div>
            </div>

            <div class="text-right">
                <button type="button" class="btn btn-success waves-effect waves-light save-shipper">{{__('actions.save')}}</button>
                <button type="button" class="btn btn-danger waves-effect waves-light m-l-10 cancel-shipper">{{__('actions.cancel')}}</button>
            </div>
        </form>
    </div>
</div> 