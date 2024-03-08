
<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    @include('frontend.layouts.meta')
    @include('frontend.layouts.fonts')
</head>

<body class="render" >

  <div id="pgs-app-id"></div> 
  @viteReactRefresh
  @vite('resources/js/main.jsx')

</body>

</html>
