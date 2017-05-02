<!-- REQUIRED JS SCRIPTS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.3/vue.js"></script>

<!-- JQuery and bootstrap are required by Laravel 5.3 in resources/assets/js/bootstrap.js-->
<!-- Laravel App -->
<script src="{{ url (mix('/js/app.js')) }}" type="text/javascript"></script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience. Slimscroll is required when using the
      fixed layout. -->
<script>
    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
</script>

<script src="{{ asset('/js/sweetalert2.min.js') }}" charset="utf-8"></script>
<script src="{{ asset('/js/bootstrap-notify.min.js')}}" charset="utf-8"></script>
<script src="{{ asset('/js/helper.js') }}" charset="utf-8"></script>
<script src="{{ asset('/js/JsBarcode.all.min.js') }}" charset="utf-8"></script>
