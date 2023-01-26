<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">



        {{-- VUE CSS --}}
        <link rel="stylesheet" href="{{ asset('css') }}/app.css">

        <link rel="icon" href="{{ asset('back') }}/assets/images/favicon.png" type="image/x-icon">
        <link rel="shortcut icon" href="{{ asset('back') }}/assets/images/favicon.png" type="image/x-icon">
        <title>mCRM | MFSoftware </title>
        <!-- Google font-->
        <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ asset('back') }}/assets/css/font-awesome.css">
        <!-- ico-font-->
        <link rel="stylesheet" type="text/css" href="{{ asset('back') }}/assets/css/vendors/icofont.css">
        <!-- Themify icon-->
        <link rel="stylesheet" type="text/css" href="{{ asset('back') }}/assets/css/vendors/themify.css">
        <!-- Flag icon-->
        <link rel="stylesheet" type="text/css" href="{{ asset('back') }}/assets/css/vendors/flag-icon.css">
        <!-- Feather icon-->
        <link rel="stylesheet" type="text/css" href="{{ asset('back') }}/assets/css/vendors/feather-icon.css">
        <!-- Plugins css start-->
        <link rel="stylesheet" type="text/css" href="{{ asset('back') }}/assets/css/vendors/scrollbar.css">
        <link rel="stylesheet" type="text/css" href="{{ asset('back') }}/assets/css/vendors/animate.css">
        <link rel="stylesheet" type="text/css" href="{{ asset('back') }}/assets/css/vendors/chartist.css">
        <link rel="stylesheet" type="text/css" href="{{ asset('back') }}/assets/css/vendors/date-picker.css">
        <!-- Plugins css Ends-->
        <!-- Bootstrap css-->
        <link rel="stylesheet" type="text/css" href="{{ asset('back') }}/assets/css/vendors/bootstrap.css">
        <!-- App css-->
        <link rel="stylesheet" type="text/css" href="{{ asset('back') }}/assets/css/style.css">
        <link id="color" rel="stylesheet" href="{{ asset('back') }}/assets/css/color-1.css" media="screen">
        <!-- Responsive css-->
        <link rel="stylesheet" type="text/css" href="{{ asset('back') }}/assets/css/responsive.css">
    </head>
    <body onload="startTime()">
        <div id="app">
            <app-component></app-component>
        </div>

        {{-- VUE JS --}}
        <script src="{{ asset('js') }}/app.js"></script>

        <script src="{{ asset('back') }}/assets/js/jquery-3.5.1.min.js"></script>
        <!-- Bootstrap js-->
        <script src="{{ asset('back') }}/assets/js/bootstrap/bootstrap.bundle.min.js"></script>
        <!-- feather icon js-->
        <script src="{{ asset('back') }}/assets/js/icons/feather-icon/feather.min.js"></script>
        <script src="{{ asset('back') }}/assets/js/icons/feather-icon/feather-icon.js"></script>
        <!-- scrollbar js-->
        <script src="{{ asset('back') }}/assets/js/scrollbar/simplebar.js"></script>
        <script src="{{ asset('back') }}/assets/js/scrollbar/custom.js"></script>
        <!-- Sidebar jquery-->
        <script src="{{ asset('back') }}/assets/js/config.js"></script>
        <!-- Plugins JS start-->
        <script src="{{ asset('back') }}/assets/js/sidebar-menu.js"></script>
        <script src="{{ asset('back') }}/assets/js/chart/chartist/chartist.js"></script>
        <script src="{{ asset('back') }}/assets/js/chart/chartist/chartist-plugin-tooltip.js"></script>
        <script src="{{ asset('back') }}/assets/js/chart/knob/knob.min.js"></script>
        <script src="{{ asset('back') }}/assets/js/chart/knob/knob-chart.js"></script>
        <script src="{{ asset('back') }}/assets/js/chart/apex-chart/apex-chart.js"></script>
        <script src="{{ asset('back') }}/assets/js/chart/apex-chart/stock-prices.js"></script>
        <script src="{{ asset('back') }}/assets/js/notify/bootstrap-notify.min.js"></script>
        <script src="{{ asset('back') }}/assets/js/dashboard/default.js"></script>
        <script src="{{ asset('back') }}/assets/js/notify/index.js"></script>
        <script src="{{ asset('back') }}/assets/js/datepicker/date-picker/datepicker.js"></script>
        <script src="{{ asset('back') }}/assets/js/datepicker/date-picker/datepicker.en.js"></script>
        <script src="{{ asset('back') }}/assets/js/datepicker/date-picker/datepicker.custom.js"></script>
        <script src="{{ asset('back') }}/assets/js/typeahead/handlebars.js"></script>
        <script src="{{ asset('back') }}/assets/js/typeahead/typeahead.bundle.js"></script>
        <script src="{{ asset('back') }}/assets/js/typeahead/typeahead.custom.js"></script>
        <script src="{{ asset('back') }}/assets/js/typeahead-search/handlebars.js"></script>
        <script src="{{ asset('back') }}/assets/js/typeahead-search/typeahead-custom.js"></script>
        <!-- Plugins JS Ends-->
        <!-- Theme js-->
        <script src="{{ asset('back') }}/assets/js/script.js"></script>
        <!-- login js-->
        <!-- Plugin used-->
    </body>
</html>
