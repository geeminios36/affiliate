@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
    <h5 class="mb-0 h6">{{translate('Add Config Commission')}}</h5>
</div>

<div class="col-lg-6 mx-auto">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{translate('Config Commission')}}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('config_commission.store') }}" method="POST">
            	@csrf
                <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="name">{{translate('Name')}}</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{translate('Name')}}" id="name" name="name" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="name">{{translate('Seller')}}</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <input type="number" min="0" max="100"  placeholder="{{translate('Seller')}}" id="seller" name="seller_commission" class="form-control" required>
                            <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="name">{{translate('Customer')}}</label>
                    <div class="col-sm-9">
                    <div class="input-group">
                    <input type="number" min="0" max="100"  placeholder="{{translate('Customer')}}" id="customer" name="customer_commission" class="form-control" required>
                            <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="name">{{translate('Factory')}}</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                        <input type="number" min="0" max="100"  placeholder="{{translate('Factory')}}" id="factory" name="factory_commission" class="form-control" required>
                            <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="name">{{translate('Remunerate')}}</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                        <input type="number" min="0" max="100"  placeholder="{{translate('Remunerate')}}" id="remunerate" name="remunerate_commission" class="form-control" required>
                            <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="name">{{translate('Stock')}}</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                        <input type="number" min="0" max="100"  placeholder="{{translate('Stock')}}" id="stock" name="stock_commission" class="form-control" required>
                            <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group mb-0 text-right">
                    <button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
