<div id="add-client-modal" class="modal-demo">
    <button type="button" class="close" onclick="Custombox.modal.close();">
        <span>&times;</span><span class="sr-only">Close</span>
    </button>
    <h4 class="custom-modal-title">{{__('messages.add_new_customer')}}</h4>
    <div class="custom-modal-text text-left">
        <form id="addClientForm" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
            @csrf
            <div class="form-group mb-3">
                <label for="ja_name">{{__('messages.clientjp')}} <span class="text-danger">*</span></label>
                <input type="text" name="ja_name" class="form-control">
                <div class="invalid-feedback" id="ja_name_error" style="display:none;"></div>
            </div>
                            
            <div class="form-group mb-3">
                <label for="en_name">{{__('messages.clienteng')}} <span class="text-danger">*</span></label>
                <input type="text" name="en_name" class="form-control">
                <div class="invalid-feedback" id="en_name_error" style="display:none;"></div>
            </div>
            <div class="form-group mb-3">
                <label for="shipper">{{__('messages.country_classification')}} <span class="text-danger">*</span></label>
                <select class="form-control" name="shipper" id="shipper">
                    <option value="">{{__('messages.select_country_c')}}</option>
                    @forelse($shippers as $shipper)
                        <option value="{{$shipper->id}}">{{$shipper->shipper_name}}</option>
                        @empty
                    @endforelse
                </select>
                <div class="invalid-feedback" id="shipper_error" style="display:none;"></div>
            </div>
            <div class="form-group mb-3">
                <label for="incharge">{{__('messages.incharge')}}</label>
                <select class="form-control modal-select2" name="incharge">
                    <option value="">{{__('messages.select_incharge')}}</option>
                    @forelse($users as $user)
                        <option value="{{$user->id}}">{{$user->name}}</option>
                        @empty
                    @endforelse
                </select>
                <div class="invalid-feedback" id="incharge_error" style="display:none;"></div>
            </div>  
            <div class="form-group mb-3">
                <label for="person_name">{{__('messages.manager')}}</label>
                <input type="text" name="person_name" class="form-control" placeholder="e.g : John Doe">
            </div>
            <div class="form-group mb-3">
                <label for="contact_number">{{__('messages.manager_contact')}}</label>
                <input type="text" name="contact_number" class="form-control" placeholder="">
            </div>
            <div class="form-group mb-3">
                <label for="email">{{__('messages.resp_email')}}</label>
                <input type="text" name="email" class="form-control" placeholder="e.g : john.doe@example.com">
            </div>
            <div class="form-group mb-3">
                <label for="office_add">{{__('messages.office_add')}}</label>
                <input type="text" name="office_add" class="form-control" placeholder="">
            </div>
            <div class="form-group mb-3">
                <label for="company_tel">{{__('messages.company_tel')}}</label>
                <input type="text" name="company_tel" class="form-control" placeholder="">
            </div>
            <div class="form-group mb-3">
                <label for="fax">{{__('messages.fax')}}</label>
                <input type="text" name="fax" class="form-control" placeholder="">
            </div>
            <div class="form-group mb-3">
                <label for="hp">{{__('messages.hp')}}</label>
                <textarea name="hp" class="form-control"></textarea>
            </div>
            <div class="form-group mb-3">
                <label for="delivery_address">{{__('messages.delivery_address')}}</label>
                <textarea name="delivery_address" class="form-control"></textarea>
            </div>
            <div class="form-group mb-3">
                <label for="amazon_listed">{{__('messages.amazon_listed')}}</label>
                <textarea name="amazon_listed" class="form-control"></textarea>
            </div>
            <div class="form-group mb-3">
                <label for="amazon_listed_address">{{__('messages.amazon_listed_address')}}</label>
                <textarea name="amazon_listed_address" class="form-control"></textarea>
            </div> 
            <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">{{__('messages.food_notification')}}</h5>
            <div class="form-group mb-3 food-file">
                <input type="file" name="food[]" class="dropify food" data-max-file-size="1M" multiple/>
                <div class="invalid-feedback" id="food_error" style="display:none;"></div>
                <p class="text-muted text-center mt-2 mb-0">{{__('messages.food_notification')}}</p>
            </div>
            <div class="form-group mb-3">
                <label for="customer_memo">{{__('messages.customer_memo')}} <span><i class="mdi mdi-information" title="{{__('messages.customer_memo_desc')}}" data-plugin="tippy" data-tippy-duration="[500, 200]"></i></span></label>
                <textarea name="customer_memo" class="form-control"></textarea>
            </div>  

            <div class="text-right">
                <button type="button" class="btn btn-success waves-effect waves-light save-client">
                <span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true" style="display: none;"></span>    
                {{__('actions.save')}}</button>
                <button type="button" class="btn btn-danger waves-effect waves-light m-l-10 cancel">{{__('actions.cancel')}}</button>
            </div>
        </form>
    </div>
</div> 