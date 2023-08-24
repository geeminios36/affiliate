@extends('backend.layouts.app')

@section('content')
<div class="aiz-titlebar text-left mt-2 mb-3">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3">{{translate('All Tenant')}}</h1>
        </div>
        <div class="col-md-6 text-md-right">
            <a href="{{ route('tenants.create') }}" class="btn btn-primary">
                <span>{{translate('Add New Tenant')}}</span>
            </a>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header d-block d-md-flex">
        <h5 class="mb-0 h6">{{translate('All Tenant') }}</h5>
        <form class="" id="sort_tenants" action="" method="GET">
            <div class="box-inline pad-rgt pull-left">
                <div class="" style="min-width: 200px;">
                    <input type="text" class="form-control" id="search" name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{translate('Type name & Enter') }}">
                </div>
            </div>
        </form>
    </div>
    <div class="card-body">
        <table class="table aiz-table mb-0">
            <thead>
                <tr>
                    <th data-breakpoints="lg">#</th>
                    <th>{{translate('Code')}}</th>
                    <th data-breakpoints="lg">{{translate('Name') }}</th>
                    <th data-breakpoints="lg">{{translate('Host') }}</th>
                    <th data-breakpoints="lg">{{translate('Status') }}</th>
                    <th width="10%" class="text-right">{{translate('Options')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tenants as $key => $tenant)
                    <tr>
                        <td>{{ ($key+1) + ($tenants->currentPage() - 1)*$tenants->perPage() }}</td>
                        <td>{{ $tenant->code }}</td>
                        <td>{{ $tenant->name }}</td>


                        <td>
                            @if(!empty($tenant->host))
                                {{ @$tenant->host->name }} - {{ @$tenant->host->phone }}
                            @endif
                        </td>
                        <td>
                            <label class="aiz-switch aiz-switch-success mb-0">
                                <input type="checkbox" onchange="update_status(this)" value="{{ $tenant->id }}" <?php if($tenant->status == 1) echo "checked";?>>
                                <span></span>
                            </label>
                        </td>
                        <td class="text-right">
                            <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('tenants.edit', ['tenant'=>$tenant->id] )}}" title="{{translate('Edit') }}">
                                <i class="las la-edit"></i>
                            </a>
                            <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('tenants.destroy', $tenant->id)}}" title="{{translate('Delete') }}">
                                <i class="las la-trash"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="aiz-pagination">
            {{ $tenants->appends(request()->input())->links() }}
        </div>
    </div>
</div>
@endsection


@section('modal')
    @include('modals.delete_modal')
@endsection


@section('script')
    <script type="text/javascript">
        function update_status(el){
            if(el.checked){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('{{ route('tenants.status') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
                if(data == 1){
                    AIZ.plugins.notify('success', '{{translate('Status has been updated successfully') }}');
                }
                else{
                    AIZ.plugins.notify('danger', '{{translate('Something went wrong') }}');
                }
            });
        }
    </script>
@endsection
