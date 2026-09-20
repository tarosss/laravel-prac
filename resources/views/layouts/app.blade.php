<!DOCTYPE html>
<html lang="ja">

<head>
  ...
  @yield('meta')
  @stack('styles')
</head>

<body>
  @yield('top')

  @include('layouts.partials.header')

  @yield('content')

  @include('layouts.partials.footer')

  @stack('scripts')

  @stack('sub-content')

</body>

</html>