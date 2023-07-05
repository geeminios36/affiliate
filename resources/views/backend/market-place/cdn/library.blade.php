<link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
<script src="//cdn.bootcss.com/jquery/1.11.2/jquery.min.js"></script>
<script src="//cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<div class="loading-overlay">
    <span class="fas fa-spinner fa-3x fa-spin"></span>
</div>
<script>
    function block_submit() {
        $('.loading-overlay').css('display', 'flex')
        let overlay = document.getElementsByClassName('loading-overlay')[0]
        overlay.classList.toggle('is-active')
    }

    function un_block_submit() {
        $('.loading-overlay').css('display', 'none')
    }

    function message(msg, responseMsg, type) {
        swal({
            title: msg,
            html: true,
            timer: 3000,
            text: responseMsg,
            confirmButtonText: "V redu",
            allowOutsideClick: "true",
            icon: type,
        });

    }

    let __$loadPosition = function () {
        window.onbeforeunload = function (e) {
            window.name += ' [' + $(window).scrollTop().toString() + '[' + $(window).scrollLeft().toString();
        };

        $.maintainscroll = function () {
            if (window.name.indexOf('[') > 0) {
                var parts = window.name.split('[');
                window.name = $.trim(parts[0]);
                window.scrollTo(parseInt(parts[parts.length - 1]), parseInt(parts[parts.length - 2]));
            }
        };

        $.maintainscroll();
    }

</script>
