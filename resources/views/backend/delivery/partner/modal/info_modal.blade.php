<style>
    .btn[disabled], input:disabled, select:disabled, textarea:disabled {
        background-color: #e9ecef!important;
        cursor: not-allowed!important;
        pointer-events: unset!important;
        box-shadow: none;
    }
</style>
<div class="modal" id="info_modal_connect" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class=" modal-dialog-centered modal-dialog-zoom product-modal" id="modal-size" role="document"
         style="    margin: auto;    width: 650px;">
        <div class="modal-content position-relative">
            <div class="modal-header">
                <h5 class="modal-title fw-600 heading-5">Cập nhật thông tin đối tác {{$deliveryTenancy->delivery_partners->fullname}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-content-se">
                <div class="modal-content-info__grab-express" style="max-height: calc(100vh - 300px);">
                    <div class="row" style="margin-bottom:15px;">
                        <div class="col-md-4" style="display:flex;align-items:center;">
                            <label>Đối tác</label>
                        </div>
                        <div class="col-md-8">
                            <div class="controls">
                                <img src="{{static_asset($deliveryTenancy->delivery_partners->logo)}}" style="width:160px;">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4" style="display: flex; align-items: center">
                            <label required="" for="Token">Token Key</label>
                        </div>
                        <div class="col-md-8">
                            <div class="controls">
                                <input bind="token" class="form-control product-input sapo-textbox"
                                       disabled="disabled" id="tokenv4" maxlength="255" name="Token" placeholder=" "
                                       type="text" value="{{$deliveryTenancy->token_key}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div style="margin-top:10px;">
                                <p style="margin-bottom:10px;"><strong>Thông tin hỗ trợ</strong></p>
                                <p style="color:#08f">&gt;&gt; <a
                                        href="#"
                                        class="delivery-link" target="_blank" rel="nofollow">Hướng dẫn cập nhật và
                                        sử dụng</a></p>
                                <p style="color:#08f">&gt;&gt; <a href="{{@$deliveryTenancy->url}}" class="delivery-link"
                                                                  target="_blank" rel="nofollow">Tìm hiểu thêm về {{$deliveryTenancy->delivery_partners->fullname}} </a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="action-btn clearfix">
                    <button type="button" class="btn btn-outline-primary fw-600" id="info_modal_connect_dismiss"
                            data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        $('#info_modal_connect_dismiss').on('click', function () {
            setTimeout(function (){
                $('#modal_content_html').empty()
            }, 1000)
        })
    })
</script>
