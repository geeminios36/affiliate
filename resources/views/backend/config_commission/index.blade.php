@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3">{{translate('Config Commission')}}</h1>
        </div>
        <div class="col-md-6 text-md-right">
            <a href="{{ route('config_commission.create') }}" class="btn btn-circle btn-info">
                <span>{{translate('Add Config Commission')}}</span>
            </a>
        </div>
    </div>
</div>

<div class="card">
    <form class="" id="sort_customers" action="" method="GET">
        <div class="card-header row gutters-5">
            <div class="col">
                <h5 class="mb-0 h6">List Config</h5>
            </div>
        </div>
    
        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                    <tr>
                        <th>{{translate('Order')}}</th>
                        <th>{{translate('Name')}}</th>
                        <th>{{translate('Seller')}}</th>
                        <th>{{translate('Customer')}}</th>
                        <th>{{translate('Factory')}}</th>
                        <th>{{translate('Remunerate')}}</th>
                        <th>{{translate('Stock')}}</th>
                        <th>{{translate('Options')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($configsCommission as $key => $configCommission)
                    <tr>
                        <td>{{ $key+=1 }}</td>
                        <td>{{ $configCommission->name }}</td>
                        <td>{{ $configCommission->seller_commission }} %</td>
                        <td>{{ $configCommission->customer_commission }} %</td>
                        <td>{{ $configCommission->factory_commission }} %</td>
                        <td>{{ $configCommission->remunerate_commission }} %</td>
                        <td>{{ $configCommission->stock_commission }} %</td>
                        <td class="text-center">
                                <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('config_commission.destroy', $configCommission->id)}}" title="{{translate('Delete') }}">
                                    <i class="las la-trash"></i>
                                </a>
                                <a href="{{route('config_commission.edit',$configCommission->id)}}" class="btn btn-soft-primary btn-icon btn-circle btn-sm" ">
                                    <i class="las la-edit"></i>
                                </a>
                            </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="aiz-pagination">
            </div>
        </div>
    </form>
</div>

@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection

@section('script')

@endsection
