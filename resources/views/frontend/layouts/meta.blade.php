<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>{{config('app.name')}}</title>
<link rel="canonical" href="{{ env('APP_URL') }}" />
<meta name="description" content="Lorem ipsum dolor sit amet, consectetur adipisicing elit. Placeat et corporis numquam voluptatibus officia magnam cum omnis doloremque, ipsa debitis!">
<meta name=”robots” content=”index, follow”>
<meta property="og:type" content="informative" /> 
<meta property="og:title" content="{{config('app.name')}}" /> 
<meta property="og:description" content="Lorem ipsum dolor sit amet, consectetur adipisicing elit. Placeat et corporis numquam voluptatibus officia magnam cum omnis doloremque, ipsa debitis!" /> 
<meta property="og:image" content="{{ getFrontendAsset('/images/og-image.jpg') }}" /> 
<meta property="og:url" content="{{ env('APP_URL') }}" /> 
<meta property="og:site_name" content="{{config('app.name')}}" />
<link rel="apple-touch-icon" sizes="180x180" href="{{ getFrontendAsset('/images/apple-touch-icon.png') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ getFrontendAsset('/images/favicon-32x32.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ getFrontendAsset('/images/favicon-16x16.png') }}">
<link rel="manifest" href="/site.webmanifest">
