<!DOCTYPE html>
@langrtl
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
@else
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@endlangrtl
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', app_name())</title>
        <meta name="description" content="@yield('meta_description', 'Laravel Starter')">
        <meta name="author" content="@yield('meta_author', 'FasTrax Infotech')">
        @yield('meta')

        {{-- See https://laravel.com/docs/5.5/blade#stacks for usage --}}
        @stack('before-styles')

        <!-- Check if the language is set to RTL, so apply the RTL layouts -->
        <!-- Otherwise apply the normal LTR layouts -->
       
        {{ style(mix('css/backend.css')) }}

        @stack('after-styles')
    </head>
   <body class="app header-fixed sidebar-fixed aside-menu-off-canvas sidebar-lg-show">
        @include('includes.partials.read-only')
           @include('includes.partials.logged-in-as')
            @include('frontend.includes.nav')
        <div class="app-body" >
           @include('frontend.includes.sidebar')
             <main class="main">
            

           <div class="container-fluid">
                <div class="animated fadeIn">
                    <div class="content-header">
                        @yield('page-header')
                    </div>
                @include('includes.partials.messages')
                @yield('content')
           </div>
                <!--animated-->
            </div>
            <!--container-fluid-->
        </main>
        <!--main-->
  @include('backend.includes.aside')
    </div>

        <!-- Scripts -->
        @stack('before-scripts')
        {!! script(mix('js/manifest.js')) !!}
        {!! script(mix('js/vendor.js')) !!}
        {!! script(mix('js/frontend.js')) !!}
         {!! script(mix('js/backend.js')) !!}
        @stack('after-scripts')

        @include('includes.partials.ga')
       
<script src="{{ asset('js/social/socialpic.js') }}"></script>
<script>
    $(function(){       
        $('img').socialpic();
    });
    </script>
    </body>
</html>
