  <!-- Favicon icon -->
  <link rel="icon" type="image/x-icon" href="{{asset($setting->favicon)}}">
  <!-- common plugins -->
  <link rel="stylesheet" href="{{asset('backend')}}/plugins/bootstrap/css/bootstrap.min.css" />
  <link rel="stylesheet" href="{{asset('backend')}}/plugins/font-awesome/css/font-awesome.min.css" />
  <link rel="stylesheet" href="{{asset('backend')}}/plugins/icomoon/style.css" />
  <link rel="stylesheet" href="{{asset('backend')}}/plugins/switchery/switchery.min.css" />
  <link rel="stylesheet" href="{{asset('backend')}}/plugins/datatables/css/jquery.datatables.min.css" />
  <!-- nvd3 plugin -->
  <link rel="stylesheet" href="{{asset('backend')}}/plugins/nvd3/nv.d3.min.css" />

  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

  @stack("style")
  <!-- theme core css -->
  <link rel="stylesheet" href="{{asset('backend')}}/css/styles.css" />

  <style>
      .form-control {
          box-shadow: none !important;
      }
  </style>