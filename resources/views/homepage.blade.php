<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home Page</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Tailwind & Scripts (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Livewire Styles (Required for Livewire to work) -->
    @livewireStyles
</head>
<body class="font-[Inter] antialiased bg-slate-100 dark:bg-slate-900">

    <!-- THIS LINE LOADS YOUR DASHBOARD -->
    <livewire:incident-dashboard />

    <!-- Livewire Scripts (Required) -->
    @livewireScripts

</body>
</html>