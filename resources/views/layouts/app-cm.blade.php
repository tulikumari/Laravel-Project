@php
$withoutSidebar = isset($withoutSidebar)??false;
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | {{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="{{ asset('/public/img/twitter-icon.png') }}" type="image/png"/>
    <link rel="shortcut icon" href="{{ asset('/public/img/twitter-icon.png') }}" type="image/png"/>
    <!-- Scripts -->
    <script src="{{ asset('js/common.js') }}"></script>
    <script src="{{ asset('js/front.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/datatables.min.js') }}"></script>
    <script src="{{ asset('js/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('js/jquery.fancybox.min.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <!-- Styles -->
    <link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery.fancybox.min.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/updates.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
</head>
<body>
    <div class="wrapper">       
        <!-- Page Content  -->
        <div id="content">
            @include('layouts.app-cm-partials.header')
            <div class="container w-100 ">
                <div class="row">
                      @if(!$withoutSidebar)
                    <div class="col-md-2 col-sm-2 remv_padd_lft">
                      
            @include('layouts.app-cm-partials.sidebar')
        
            
                    </div>
                    <div class="col-md-10 col-sm-10">
                        @endif
                        <!--Info Top---->
            <div class="inner-info">
                <div class="container w-100">
                    @include('layouts.flash-message')
                    <h3 class="info-head">@yield('page-header')</h3>
                    @yield('refresh-button')
                    @yield('content')
                </div>
            </div>
                       @if(!$withoutSidebar)   
                    </div>
                     @endif
                </div>
            </div>
             
            
        </div>
    </div>
@include('layouts.app-cm-partials.footer')
