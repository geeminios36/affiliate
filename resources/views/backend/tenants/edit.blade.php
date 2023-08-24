@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
    <h5 class="mb-0 h6">{{translate('Tenant Information')}}</h5>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-body p-0">
                <form class="p-4" action="{{ route('tenants.update', $tenant->id) }}" method="POST" enctype="multipart/form-data">
                    <input name="_method" type="hidden" value="PATCH">
                	@csrf
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{translate('Code')}} </label>
                        <div class="col-md-9">
                            <input type="text" placeholder="{{translate('Code')}}..." value="{{ $tenant->code }}" id="code" name="code" class="form-control" maxlength="50" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{translate('Name')}} </label>
                        <div class="col-md-9">
                            <input type="text" name="name" value="{{ $tenant->name }}" class="form-control" id="name" placeholder="{{translate('Name')}}" maxlength="255" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{translate('Host')}}</label>
                        <div class="col-md-9">
                            <select class="select2 form-control aiz-selectpicker" name="host_id" data-toggle="select2" data-placeholder="Choose ..." data-live-search="true" data-selected="{{ $tenant->host_id }}">
                                <option value="0">-- {{translate('Host') }}</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} - {{ $user->phone }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{translate('Status')}}</label>
                        <div class="col-md-9">
                            <label class="aiz-switch aiz-switch-success mb-0">
                                <input type="checkbox" value="1" name="status" {{ $tenant->status == 1 ? 'checked' : '' }}>
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection
