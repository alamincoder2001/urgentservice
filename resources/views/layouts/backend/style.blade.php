  <!-- Favicon icon -->
  <link rel="icon" type="image/x-icon" href="{{asset($setting->favicon)}}">
  <!-- common plugins -->
  <link rel="stylesheet" href="{{asset('backend')}}/plugins/bootstrap/css/bootstrap.min.css" />
  <link rel="stylesheet" href="{{asset('backend')}}/plugins/font-awesome/css/font-awesome.min.css" />
  <link rel="stylesheet" href="{{asset('backend')}}/plugins/icomoon/style.css" />
  <link rel="stylesheet" href="{{asset('backend')}}/plugins/switchery/switchery.min.css" />
  <link rel="stylesheet" href="{{asset('backend')}}/plugins/datatables/css/jquery.datatables.min.css" />
  <link rel="stylesheet" href="{{asset('backend')}}/plugins/datatables/css/jquery.datatables_themeroller.css" />

  <!-- nvd3 plugin -->
  <link rel="stylesheet" href="{{asset('backend')}}/plugins/nvd3/nv.d3.min.css" />

  <link href="{{asset('backend/css/select2.css')}}" rel="stylesheet" />

  @stack("style")
  <!-- theme core css -->
  <link rel="stylesheet" href="{{asset('backend')}}/css/styles.css" />

  <style>
    .form-control {
      box-shadow: none !important;
    }
  </style>
  <style>
    .ImageBackground .imageShow {
      display: block;
      height: 120px;
      width: 135px;
      margin-top: 10px;
      border: 1px solid #27ff00;
      border-bottom: 0;
      box-sizing: border-box;
    }

    .ImageBackground input {
      display: none;
    }

    .ImageBackground label {
      background: green;
      width: 135px;
      color: white;
      padding: 5px;
      text-align: center;
      cursor: pointer;
      font-family: monospace;
      text-transform: uppercase;
    }
  </style>