<!--  offcanvas Minicart Start -->
<div class="offcanvas-minicart_wrapper" id="miniCart">
    <div class="offcanvas-menu-inner">
        <div class="close-btn-box">
            <a href="#" class="btn-close"><i class="icon-cross2"></i></a>
        </div>
        <div class="minicart-content">
            <ul class="minicart-list">
                @foreach($listCart as $cart)
                    @php
                        $product = $cart->product;
                        $photos = !empty($detailedProduct) ?  explode(',', $product->photos)[0] : '';
                    @endphp
                    <li class="minicart-product">
                        <a class="product-item_remove" href="javascript:void(0)"><i class="icon-cross2"></i></a>
                        <a class="product-item_img">
                            <img class="img-fluid" src="{{ uploaded_asset($photos) }}"
                                 alt="Product Image">
                        </a>
                        <div class="product-item_content">
                            <a class="product-item_title" href="{{ route('product', $product->slug) }}">{{ $product->name }}</a>
                            <label>Qty : <span>{{ $cart->quantity }}</span></label>
                            <label class="product-item_quantity">Price: <span> {{ number_format($cart->price) }}</span></label>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="minicart-item_total">
            <span class="font-weight--reguler">Subtotal:</span>
            <span class="ammount font-weight--reguler">{{ number_format($listCart->sum('price')) }}</span>
        </div>
        <div class="minicart-btn_area">
            <a href="cart.html" class="btn btn--full btn--border_1">View cart</a>
        </div>
        <div class="minicart-btn_area">
            <a href="checkout.html" class="btn btn--full btn--black">Checkout</a>
        </div>
    </div>

    <div class="global-overlay"></div>
</div>
<!--  offcanvas Minicart End -->
