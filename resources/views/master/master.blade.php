<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TextOwners</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link rel="stylesheet" href="https://rawgit.com/lykmapipo/themify-icons/master/css/themify-icons.css">
</head>
<body>
<div class="flex-center position-ref full-height" id="app">
    <!-- <router-view></router-view> -->
     <!-- siteLayout -->
     <site-layout></site-layout>
</div>
<script src="/js/app.js"></script>
</body>
</html>
