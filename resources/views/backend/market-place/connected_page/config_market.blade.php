@extends('backend.layouts.app')

@section('content')
    <div class="card">
        <iframe class="app-iframe app-iframe--admin" frameborder="0" name="app-iframe"
                allow="camera; microphone" width="100%" height="790px"
                src="{{route('market_place.general_page_data', $ecommerceMarketPlaceId)}}">
        </iframe>
    </div>
    <div id="modal_content_html"></div>
@endsection

@section('modal')
@endsection

@section('script')
    <script>

    </script>
@endsection
