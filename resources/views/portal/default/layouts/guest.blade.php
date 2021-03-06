<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Source: https://github.com/invoiceninja/invoiceninja -->
    <!-- Error: {{ session('error') }} -->
    @if (config('services.analytics.tracking_id'))
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-122229484-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ config('services.analytics.tracking_id') }}', { 'anonymize_ip': true });
            function trackEvent(category, action) {
                ga('send', 'event', category, action, this.src);
            }
        </script>
        <script>
            Vue.config.devtools = true;
        </script>
    @else
        <script>
            function gtag(){}
        </script>
    @endif

    <meta charset="utf-8">
    <title>@yield('meta_title', 'Invoice Ninja') | {{ config('app.name') }}</title>
    <meta name="description" content="@yield('meta_description')"/>
    <link href="{{ asset('favicon.png') }}" rel="shortcut icon" type="image/png">

  <base href="./">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <meta name="author" content="">
  <meta name="keyword" content="">
  <!-- Icons-->
  <link href="/vendors/css/coreui-icons.min.css" rel="stylesheet">
  <link href="/vendors/css/font-awesome.min.css" rel="stylesheet">
  <!-- Main styles for this application-->
  <link href="/vendors/css/bootstrap.min.css" rel="stylesheet">
  <link href="/vendors/css/coreui.min.css" rel="stylesheet">
    @yield('head')
</head>
@section('body')
@yield('body')
</html>