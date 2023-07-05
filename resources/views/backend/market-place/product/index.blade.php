@extends('backend.layouts.app')

@section('content')
    <div class="card">
        <iframe class="app-iframe app-iframe--admin" frameborder="0" name="app-iframe"
                allow="camera; microphone" width="100%" height="1050px"
                src="{{route('market_place.product.list_data')}}">
        </iframe>
    </div>
    <div id="modal_content_html"></div>
@endsection

@section('modal')
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('.card').animate({
                scrollTop: $('.card')[0].scrollHeight
            }, 100);
        });
    </script>
@endsection
