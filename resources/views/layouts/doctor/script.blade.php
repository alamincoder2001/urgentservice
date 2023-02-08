<!-- jQuery -->
<script src="{{asset('backend')}}/plugins/jquery/jquery-3.1.0.min.js"></script>

<!-- bootstrap -->
<script src="{{asset('backend')}}/plugins/bootstrap/js/bootstrap.min.js"></script>

<!-- slimscroll -->
<script src="{{asset('backend')}}/plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="{{asset('backend')}}/plugins/uniform/js/jquery.uniform.standalone.js"></script>
<script src="{{asset('backend')}}/js/main.js"></script>
<!-- datatables -->
<script src="{{asset('backend')}}/plugins/datatables/js/jquery.datatables.min.js"></script>

<script src="{{asset('js/select2.js')}}"></script>
<script src="{{asset('js/notify.js')}}"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

@stack("js")