<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@yield('title')</title>
  @include('admin.wraplib.wrapper_css')
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

 @include('admin.wrapper.header')
 @include('admin.wrapper.sidebar')
     <div class="content-wrapper">
      @yield('contents')
    </div>
</div>

<script>
  var base_url = "{{url('')}}";
</script>
 @include('admin.wraplib.wrapper_js')
 @yield('script')
</body>
</html>
