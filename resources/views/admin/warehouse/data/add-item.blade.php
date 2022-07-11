<div id="add-item-modal" class="modal-demo">
    <button type="button" class="close" onclick="Custombox.modal.close();">
        <span>&times;</span><span class="sr-only">Close</span>
    </button>
    <h4 class="custom-modal-title">{{__('messages.add_new_product')}}</h4>
    <div class="custom-modal-text text-left">
        <form id="addItemForm" method="post" class="needs-validation" novalidate>
            @csrf

            <div class="form-group mb-3">
                <label for="customer">{{__('messages.customer_name')}} <span class="text-danger">*</span></label>
                <select class="form-control modal-select2" name="customer">
                    <option value="">{{__('messages.select_customer')}}</option>
                    @forelse($clients as $client)
                        <option value="{{$client->id}}">{{$client->name}}</option>
                        @empty
                    @endforelse
                </select>
                <div class="invalid-feedback" id="customer_error" style="display:none;"></div>
            </div>

            <div class="form-group mb-3">
                <label for="item_category">{{__('messages.item_category')}} <span class="text-danger">*</span></label>
                <select class="form-control modal-select2" name="item_category">
                    <option value="">{{__('messages.select_item_category')}}</option>
                    @forelse($categories as $cat)
                        <option value="{{$cat->id}}">{{$cat->name}}</option>
                        @empty
                    @endforelse
                </select>
                <div class="invalid-feedback" id="item_category_error" style="display:none;"></div>
            </div>

            <div class="form-group mb-3">
                <label for="item_brand">{{__('messages.item_brand')}}</label>
                <select class="form-control modal-select2" name="item_brand">
                    <option value="">{{__('messages.select_item_brand')}}</option>
                    @forelse($brands as $cat)
                        <option value="{{$cat->id}}">{{$cat->name}}</option>
                        @empty
                    @endforelse
                </select>
                <div class="invalid-feedback" id="item_brand_error" style="display:none;"></div>
            </div>
            <div class="form-group">
                <label for="item_pseudo_name">{{__('messages.item_pseudo_name')}} <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="item_pseudo_name">
                <div class="invalid-feedback" id="item_pseudo_name_error" style="display:none;"></div>
            </div>
            <div class="form-group">
                <label for="barcode">{{__('messages.code')}} <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="barcode">
                <div class="invalid-feedback" id="barcode_error" style="display:none;"></div>
            </div>

            <div class="form-group mb-3">
                <label for="unit_set">{{__('messages.unit_set')}}</label>
                <select class="form-control modal-select2" name="unit_set">
                    <option value="">{{__('messages.select_unit_set')}}</option>
                    <option value="単品">単品</option>
                    <option value="セット外装">セット外装</option>
                    <option value="セット中身">セット中身</option>
                </select>
                <div class="invalid-feedback" id="unit_set_error" style="display:none;"></div>
            </div>
            <div class="form-group">
                <label for="capacity">{{__('messages.capacity')}} <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="capacity">
                <div class="invalid-feedback" id="capacity_error" style="display:none;"></div>
            </div>
            <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">{{__('messages.product_image')}}</h5>
            <div class="form-group mb-3 productimage-file">
                <input type="file" name="productimage" class="dropify productimage" data-max-file-size="1M" multiple/>
                <div class="invalid-feedback" id="productimage_error" style="display:none;"></div>
                <p class="text-muted text-center mt-2 mb-0">{{__('messages.product_image')}}</p>
            </div>
            <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">{{__('messages.pse_docs')}}</h5>
            <div class="form-group mb-3 psedocs-file">
                <input type="file" name="psedocs" class="dropify psedocs" data-max-file-size="1M" multiple/>
                <div class="invalid-feedback" id="psedocs_error" style="display:none;"></div>
                <p class="text-muted text-center mt-2 mb-0">{{__('messages.pse_docs')}}</p>
            </div>

            <div class="text-right">
                <button type="button" class="btn btn-success waves-effect waves-light save-item">
                <span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true" style="display: none;"></span>    
                {{__('actions.save')}}</button>
                <button type="button" class="btn btn-danger waves-effect waves-light m-l-10 cancel">{{__('actions.cancel')}}</button>
            </div>
        </form>
    </div>
</div> 