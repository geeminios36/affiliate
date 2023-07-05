@extends('backend.layouts.app')

@section('content')
    <div class="card">
        @if(!count($connectedMarket))
            <iframe class="app-iframe app-iframe--admin" frameborder="0" name="app-iframe"
                    allow="camera; microphone" width="100%" height="1000px"
                    src="{{route('market_place.connect')}}">
            </iframe>
        @else
            <iframe class="app-iframe app-iframe--admin" frameborder="0" name="app-iframe"
                    allow="camera; microphone" width="100%" height="790px"
                    src="{{route('market_place.general_page')}}">
            </iframe>
        @endif
    </div>
    <div id="modal_content_html"></div>
@endsection

@section('modal')

@endsection

@section('script')

@endsection
