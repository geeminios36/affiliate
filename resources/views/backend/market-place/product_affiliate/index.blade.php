@extends('backend.layouts.app')

@section('content')
    <iframe class="app-iframe app-iframe--admin" frameborder="0" name="app-iframe"
            allow="camera; microphone" width="100%" height="820px"
            src="{{route('market_place.product_affiliate.list_data_product')}}">
    </iframe>
@endsection

@section('modal')
@endsection

@section('script')
    <script>
        @if(!empty($msg))
        AIZ.plugins.notify('warning', '{{$msg}}');
        @endif
    </script>
@endsection
