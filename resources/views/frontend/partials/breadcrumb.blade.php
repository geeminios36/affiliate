<!-- breadcrumb-area start -->
<div class="breadcrumb-area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="row breadcrumb_box  align-items-center">
                    <div
                        class="col-lg-6 col-md-6 col-sm-6 text-center text-sm-start">
                        <h2 class="breadcrumb-title">{{ $detailedProduct->name }}
                        </h2>
                    </div>
                    <div class="col-lg-6  col-md-6 col-sm-6">
                        <!-- breadcrumb-list start -->
                        <ul class="breadcrumb-list text-center text-sm-end">
                            <li class="breadcrumb-item"><a
                                    href="/">Home</a></li>
                            <li class="breadcrumb-item active">
                                {{ $detailedProduct->category->name }}</li>
                        </ul>
                        <!-- breadcrumb-list end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- breadcrumb-area end -->
