<script src="{{ asset('js/jquery.cookie.js') }}"></script>
<script src="{{ asset('js/tether.min.js') }}"></script>
<script src="{{ asset('js/materialize.min.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>
<script src="{{ asset('js/moment.min.js') }}"></script>
<script>
    $('#closeMobileNav').click(function(){
        $('.mobile-menu-main').hide();
        $('#modal-wrapper').show();
    });

    $('.openbtn').click(function(){
        $('#modal-wrapper').hide();
        $('.mobile-menu-main').show();
    });
    $(document).ready(function(){
        $('.tooltipped').tooltip();
    });
</script>
