<!doctype html>
@if(\App\Language::where('code', Session::get('locale', Config::get('app.locale')))->first()->rtl == 1)
<html dir="rtl" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@else
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@endif
<head>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="app-url" content="{{ getBaseURL() }}">
	<meta name="file-base-url" content="{{ getFileBaseURL() }}">

	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Favicon -->
	<link rel="icon" href="{{ uploaded_asset(get_setting('site_icon')) }}">
	<title>{{ get_setting('website_name').' | '.get_setting('site_motto') }}</title>

	<!-- google font -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700">

	<!-- aiz core css -->
	<link rel="stylesheet" href="{{ static_asset('assets/css/vendors.css') }}">
    @if(\App\Language::where('code', Session::get('locale', Config::get('app.locale')))->first()->rtl == 1)
    <link rel="stylesheet" href="{{ static_asset('assets/css/bootstrap-rtl.min.css') }}">
    @endif
	<link rel="stylesheet" href="{{ static_asset('assets/css/aiz-core.css') }}">

    <link rel="stylesheet" href="{{ static_asset('assets/css/select2.min.css') }}">
    <style>
        body {
            font-size: 12px;
        }

        #loading-overlay {
            position: absolute;
            width: 100%;
            height: 100%;
            left: 0;
            top: 0;
            display: none;
            align-items: center;
            background-color: #000;
            z-index: 999;
            opacity: 0.5;
        }

        .loading-icon {
            position: absolute;
            border-top: 2px solid #fff;
            border-right: 2px solid #fff;
            border-bottom: 2px solid #fff;
            border-left: 2px solid #767676;
            border-radius: 25px;
            width: 25px;
            height: 25px;
            margin: 0 auto;
            position: absolute;
            left: 50%;
            margin-left: -20px;
            top: 50%;
            margin-top: -20px;
            z-index: 4;
            -webkit-animation: spin 1s linear infinite;
            -moz-animation: spin 1s linear infinite;
            animation: spin 1s linear infinite;
        }

        @-moz-keyframes spin { 100% {-moz-transform: rotate(360deg);} }
        @-webkit-keyframes spin { 100% {-webkit-transform: rotate(360deg);} }
        @keyframes spin { 100% {-webkit-transform: rotate(360deg);transform: rotate(360deg);} }
    </style>
    <script>
    	var AIZ = AIZ || {};
        AIZ.local = {
            nothing_selected: '{{translate('Nothing selected') }}',
            nothing_found: '{{translate('Nothing Found') }}',
            choose_file: '{{translate('Choose File') }}',
            file_selected: '{{translate('File selected') }}',
            files_selected: '{{translate('Files selected') }}',
            add_more_files: '{{translate('Add more files') }}',
            adding_more_files: '{{translate('Adding more files') }}',
            drop_files_here_paste_or: '{{translate('Drop files here, paste or') }}',
            browse: '{{translate('Browse') }}',
            upload_complete: '{{translate('Upload complete') }}',
            upload_paused: '{{translate('Upload paused') }}',
            resume_upload: '{{translate('Resume upload') }}',
            pause_upload: '{{translate('Pause upload') }}',
            retry_upload: '{{translate('Retry upload') }}',
            cancel_upload: '{{translate('Cancel upload') }}',
            uploading: '{{translate('Uploading') }}',
            processing: '{{translate('Processing') }}',
            complete: '{{translate('Complete') }}',
            file: '{{translate('File') }}',
            files: '{{translate('Files') }}',
        }
	</script>

</head>
<body class="">

	<div class="aiz-main-wrapper">
        @include('backend.inc.admin_sidenav')
		<div class="aiz-content-wrapper">
            @include('backend.inc.admin_nav')
			<div class="aiz-main-content">
				<div class="px-15px px-lg-25px">
                    @yield('content')
				</div>
				<div class="bg-white text-center py-3 px-15px px-lg-25px mt-auto">
					<p class="mb-0">&copy; {{ get_setting('site_name') }} v{{ get_setting('current_version') }}</p>
				</div>
			</div><!-- .aiz-main-content -->
		</div><!-- .aiz-content-wrapper -->
	</div><!-- .aiz-main-wrapper -->

    @yield('modal')

	<script src="{{ static_asset('assets/js/vendors.js') }}" ></script>
	<script src="{{ static_asset('assets/js/aiz-core.js') }}" ></script>
    <script src="{{ static_asset('assets/js/select2.min.js') }}"></script>

    @yield('script')

    <script type="text/javascript">
	    @foreach (session('flash_notification', collect())->toArray() as $message)
	        AIZ.plugins.notify('{{ $message['level'] }}', '{{ $message['message'] }}');
	    @endforeach


        if ($('#lang-change').length > 0) {
            $('#lang-change .dropdown-menu a').each(function() {
                $(this).on('click', function(e){
                    e.preventDefault();
                    var $this = $(this);
                    var locale = $this.data('flag');
                    $.post('{{ route('language.change') }}',{_token:'{{ csrf_token() }}', locale:locale}, function(data){
                        location.reload();
                    });

                });
            });
        }
        function menuSearch(){
			var filter, item;
			filter = $("#menu-search").val().toUpperCase();
			items = $("#main-menu").find("a");
			items = items.filter(function(i,item){
				if($(item).find(".aiz-side-nav-text")[0].innerText.toUpperCase().indexOf(filter) > -1 && $(item).attr('href') !== '#'){
					return item;
				}
			});

			if(filter !== ''){
				$("#main-menu").addClass('d-none');
				$("#search-menu").html('')
				if(items.length > 0){
					for (i = 0; i < items.length; i++) {
						const text = $(items[i]).find(".aiz-side-nav-text")[0].innerText;
						const link = $(items[i]).attr('href');
						 $("#search-menu").append(`<li class="aiz-side-nav-item"><a href="${link}" class="aiz-side-nav-link"><i class="las la-ellipsis-h aiz-side-nav-icon"></i><span>${text}</span></a></li`);
					}
				}else{
					$("#search-menu").html(`<li class="aiz-side-nav-item"><span	class="text-center text-muted d-block">{{translate('Nothing Found') }}</span></li>`);
				}
			}else{
				$("#main-menu").removeClass('d-none');
				$("#search-menu").html('')
			}
        }
        function number_format (number, decimals, dec_point, thousands_sep) {
            // Strip all characters but numerical ones.
            number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
            var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                s = '',
                toFixedFix = function (n, prec) {
                    var k = Math.pow(10, prec);
                    return '' + Math.round(n * k) / k;
                };
            // Fix for IE parseFloat(0.55).toFixed(0) = 0;
            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
            }
            return s.join(dec);
        }

        function un_number_format(number) {
           return number.replaceAll(',', '');
        }

        function block_submit(id) {
            let _overlay = $('#' + id + ' #loading-overlay')
            if (_overlay.length)
                _overlay.remove()

            $('#' + id).append('<div id="loading-overlay"> <div class="loading-icon"></div> </div>');
            $("#loading-overlay").show();
        }

        function un_block_submit(){
            $("#loading-overlay").hide();
        }

        let __baseFunction = {
            select2Ajax: function (url, id, placeholder, object){
                let element = $("#" + id);
                element.select2({
                    placeholder: placeholder,
                    allowClear: true,
                    ajax: {
                        url: url,
                        dataType: 'json',
                        type: 'post',
                        delay: 500,
                        data: function (params) {
                            object.keyword = params.term;
                            object.page = params.page;
                            object._token = '{{ csrf_token() }}';
                            return object;
                        },
                        processResults: function (data, params) {
                            params.page = params.page || 1;
                            return {
                                results: data.object,
                                pagination: {
                                    more: (params.page * 10) < data.total
                                }
                            };
                        },
                        cache: true
                    },
                    escapeMarkup: function (markup) {
                        return markup;
                    },
                    templateResult: __baseFunction.formatRepo,
                    templateSelection: __baseFunction.formatRepoSelection
                });
            },
            formatRepo : function (repo) {
                if (repo.loading) {
                    return "Loading...";
                }
                var markup = "<div>" + repo.fullname + "</div>";
                return markup;
            },
            formatRepoSelection: function(repo) {
                return repo.fullname
            }
        }


    </script>

</body>
</html>
