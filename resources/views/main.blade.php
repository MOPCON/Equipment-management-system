<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="icon" type="image/png" href="favicon-128x128.png" sizes="16x16 32x32 64x64 128x128">

    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">

    <title>EMS</title>
</head>
<body>
<noscript>
    <strong>We're sorry but LinkMux doesn't work properly without JavaScript enabled. Please enable it to
        continue.</strong>
</noscript>
<div id="app">
    <App></App>
</div>
<script src="{{ mix('/js/manifest.js') }}"></script>
<script src="{{ mix('/js/vendor.js') }}"></script>
<script src="{{ mix('/js/app.js') }}"></script>
</body>
</html>
