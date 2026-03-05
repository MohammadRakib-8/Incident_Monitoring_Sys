{{-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BDCOM Incident Reporting</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">
    
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        
        <!-- Header -->
        <div class="mb-6 text-center">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">BDCOM Incident Dashboard</h1>
            <p class="text-sm text-gray-500 mt-1">Log a new incident below</p>
        </div>

        <!-- Loads Livewire Component -->
        <div class="w-full sm:max-w-xl px-6">
            <livewire:incident-form />
        </div>

    </div>
    
    @livewireScripts
</body>
</html> --}}



{{-- 
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BDCOM Incident Monitoring</title>
    
    <!-- Fonts & Tailwind -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">

    <!-- 1. BLUE NAVIGATION BAR -->
    <nav class="bg-blue-600 shadow-lg w-full">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center">
                    <a href="#" class="text-white text-xl font-bold tracking-tight">
                        🚨 BDCOM Incident Monitor
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="#" class="text-white hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium">
                        Home
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- 2. MAIN CONTENT AREA -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Add Incident Button -->
        <div class="flex justify-end mb-6">
            <a href="{{ route('inciden') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-5 rounded-lg shadow flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Add Incident Log
            </a>
        </div>

        <!-- 3. INCIDENT CARDS GRID -->
        <div class="max-w-6xl mx-auto">
            <h5 class="text-center text-4xl font-bold py-4 text-gray-800 dark:text-white">Recent Incident Logs</h5>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 p-2">
                
                @forelse($incidents as $incident)
                
                <!-- Single Card -->
                <div class="w-full bg-white border border-gray-200 rounded-lg p-5 shadow-sm hover:shadow-lg transition dark:bg-gray-800 dark:border-gray-700">

                    <div class="flex flex-col items-center pb-6">
                        
                        <!-- Status Icon -->
                        <div class="w-20 h-20 mb-3 rounded-full shadow-md flex items-center justify-center text-4xl
                            @if($incident->status == 'Open') bg-red-100 text-red-600 border-2 border-red-200 @endif
                            @if($incident->status == 'Resolved') bg-green-100 text-green-600 border-2 border-green-200 @endif
                            @if($incident->status == 'In Progress') bg-yellow-100 text-yellow-600 border-2 border-yellow-200 @endif">
                            
                            @if($incident->status == 'Open') ⚠️ @endif
                            @if($incident->status == 'Resolved') ✅ @endif
                            @if($incident->status == 'In Progress') ⏳ @endif
                        </div>

                        <!-- Zonal Name (Accessing relationship safely) -->
                        <h5 class="mb-1 text-xl font-bold text-gray-900 dark:text-white">
                            {{ $incident->zonal->name ?? $incident->zonal_name ?? 'N/A' }}
                        </h5>
                        
                        <!-- Category -->
                        <span class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                            {{ $incident->category->name ?? $incident->category ?? 'N/A' }}
                        </span>

                        <!-- Importance Badge -->
                        <span class="px-3 py-1 text-xs font-bold rounded-full 
                            @if($incident->importance == 'Critical') bg-red-200 text-red-900 @endif
                            @if($incident->importance == 'High') bg-orange-200 text-orange-900 @endif
                            @if($incident->importance == 'Mid') bg-blue-200 text-blue-900 @endif
                            @if($incident->importance == 'Low') bg-gray-200 text-gray-900 @endif">
                            {{ $incident->importance }}
                        </span>

                        <!-- Info Details -->
                        <div class="mt-4 w-full text-xs text-gray-600 dark:text-gray-300 border-t dark:border-gray-700 pt-3 space-y-1">
                            <div class="flex justify-between">
                                <span class="font-medium">Reporter:</span>
                                <span>{{ $incident->reporter_name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium">User ID:</span>
                                <span>{{ $incident->user_id }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium">Start:</span>
                                <span>{{ $incident->start_time ? $incident->start_time->format('d M, H:i') : 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium">ETR:</span>
                                <span>{{ $incident->initial_etr ? $incident->initial_etr->format('d M, H:i') : 'N/A' }}</span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex mt-4 space-x-3 w-full">
                            <x-secondary-button class="flex-1 justify-center">
                                Edit
                            </x-secondary-button>
                            <x-danger-button class="flex-1 justify-center">
                                Delete
                            </x-danger-button>
                        </div>

                    </div>
                </div>

                @empty
                <div class="col-span-full text-center py-10 text-gray-500 dark:text-gray-400 bg-white rounded-lg shadow">
                    No incidents found. Click "Add Incident Log" to start.
                </div>
                @endforelse
            </div>
        </div>

    </main>

    @livewireScripts
</body>
</html> --}}



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BDCOM Incident Monitoring</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-[Inter] antialiased bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-900 dark:to-slate-950 text-gray-800 dark:text-gray-200 min-h-screen">

    <!-- 1. NAVIGATION BAR -->
    <nav class="sticky top-0 z-50 bg-blue-600/90 backdrop-blur-lg border-b border-white/10 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <!-- Brand -->
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-white/20 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <span class="text-white font-bold text-xl tracking-tight">BDCOM Incident Monitor</span>
                </div>

                <!-- Nav Links & Controls -->
                <div class="flex items-center space-x-4">
                    
                    <!-- Home Link -->
                    <a href="#" class="text-white/90 hover:text-white flex items-center space-x-2 transition font-medium">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span class="hidden sm:inline">Home</span>
                    </a>

                    <div class="h-6 w-px bg-white/30 hidden sm:block"></div>

                    <!-- FILTER BUTTONS -->
                    <div class="flex items-center space-x-2">
                        <button class="px-3 py-1.5 text-xs font-bold rounded-full bg-white/10 text-white/80 hover:bg-white/20 transition">
                            Resolved
                        </button>
                        <button class="px-3 py-1.5 text-xs font-bold rounded-full bg-white/10 text-white/80 hover:bg-white/20 transition">
                            Paused
                        </button>
                    </div>

                    <div class="h-6 w-px bg-white/30 hidden sm:block"></div>

                    <!-- Avatar -->
                    <img src="https://i.pravatar.cc/40?img=12" class="w-8 h-8 rounded-full border-2 border-white/30 hover:border-white transition cursor-pointer" alt="User">
                </div>
            </div>
        </div>
    </nav>

    <!-- 2. HERO & CONTENT AREA -->
    <div class="relative overflow-hidden">
        <div class="max-w-10xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                <div class="text-center md:text-left">
                </div>

                <!-- ADD INCIDENT BUTTON -->
                <div class="shrink-0">
                    <button class="inline-flex items-center gap-2 bg-gradient-to-r from-green-500 to-emerald-600 text-white px-4 py-2.5 rounded-lg font-bold shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add Incident Log
                    </button>
                </div>
            </div>

            <!-- Filter Bar -->
            <div class="mb-6">
                <div class="flex gap-2 flex-wrap">
                    <select class="bg-slate-50 dark:bg-slate-700 border-0 rounded-lg px-8 py-2.5 text-sm font-medium focus:ring-2 focus:ring-blue-500 outline-none cursor-pointer">
                        <option>Importance</option>
                        <option>High</option>
                        <option>Mid</option>
                        <option>Low</option>
                    </select>
                   <select class="bg-slate-50 dark:bg-slate-700 border-0 rounded-lg px-8 py-2.5 text-sm font-medium focus:ring-2 focus:ring-blue-500 outline-none cursor-pointer">
                        <option>Category</option>
                        <option>Logical</option>
                        <option>Physical</option>
                        <option>IIG</option>
                        <option>NTTN</option>
                    </select>
                    <select class="bg-slate-50 dark:bg-slate-700 border-0 rounded-lg px-4 py-2.5 text-sm font-medium focus:ring-2 focus:ring-blue-500 outline-none cursor-pointer">
                        <option>All Zones</option>
                        <option>Dhaka North</option>
                        <option>Dhaka South</option>
                        <option>Chittagong</option>
                        <option>Khulna</option>
                        <option>Sylhet</option>
                    </select>
                    <button class="bg-slate-50 dark:bg-slate-700 rounded-lg px-4 py-2.5 text-sm font-medium hover:bg-slate-100 dark:hover:bg-slate-600 transition flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        Filters
                    </button>
                </div>
            </div>

         
  
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-10 gap-3 mb-20">
    
    <!-- Mini Card 1 -->
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-100 dark:border-slate-700 p-2 flex flex-col justify-between hover:shadow-md transition border-l-4 border-red-500">
        <div>
            <div class="flex justify-between items-center mb-1">
                <span class="px-1.5 py-0.5 text-[9px] font-bold rounded bg-red-100 text-red-600">High</span>
            </div>
            <h3 class="text-xs font-bold text-gray-900 dark:text-white truncate">Dhaka North</h3>
            <p class="text-[9px] text-gray-500 leading-tight">Logical Issue</p>
            <p class="text-[9px] text-gray-500">ID:1001809</p>
            <p class="mt-1 text-[9px]">Status:
                <span class="px-1.5 py-0.5 text-[9px] font-bold rounded bg-gray-200 text-green-600">Open</span>
            </p>
        </div>

        <div class="text-[9px] text-gray-500 dark:text-gray-400 border-t dark:border-slate-700 mt-2 pt-1 space-y-0.5">
            <div class="flex items-center space-x-1">
                <svg class="w-2.5 h-2.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>Started: 2h ago</span>
            </div>
            <div class="flex items-center space-x-1">
                <svg class="w-2.5 h-2.5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>ETR: 4:00 PM</span>
            </div>
            <div class="flex items-center space-x-1">
                <svg class="w-2.5 h-2.5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>RT: 6:00 PM</span>
            </div>
        </div>

        <div class="flex justify-between items-center border-t dark:border-slate-700 mt-2 pt-1">
            <span class="text-[9px] font-semibold text-gray-700 dark:text-gray-300">Rakib</span>
            <button class="px-1.5 py-0.5 text-[8px] font-semibold rounded bg-blue-50 text-blue-600 hover:bg-blue-100">Edit/Resolve</button>
        </div>
    </div>

    <!-- Mini Card 3 -->
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-100 dark:border-slate-700 p-2 flex flex-col justify-between hover:shadow-md transition border-l-4 border-yellow-500">
        <div>
            <div class="flex justify-between items-center mb-1">
                <span class="px-1.5 py-0.5 text-[9px] font-bold rounded bg-yellow-100 text-yellow-700">Mid</span>
            </div>
            <h3 class="text-xs font-bold text-gray-900 dark:text-white truncate">Sylhet</h3>
            <p class="text-[9px] text-gray-500 leading-tight">Logical</p>
            <p class="text-[9px] text-gray-500">ID:1001811</p>
            <p class="mt-1 text-[9px]">Status:
                <span class="px-1.5 py-0.5 text-[9px] font-bold rounded bg-gray-200 text-green-600">Open</span>
            </p>
        </div>

        <div class="text-[9px] text-gray-500 dark:text-gray-400 border-t dark:border-slate-700 mt-2 pt-1 space-y-0.5">
            <div class="flex items-center space-x-1">
                <svg class="w-2.5 h-2.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>Started: 4PM</span>
            </div>
            <div class="flex items-center space-x-1">
                <svg class="w-2.5 h-2.5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>ETR: 6PM</span>
            </div>
            <div class="flex items-center space-x-1">
                <svg class="w-2.5 h-2.5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>RT: 6:00 PM</span>
            </div>
        </div>

        <div class="flex justify-between items-center border-t dark:border-slate-700 mt-2 pt-1">
            <span class="text-[9px] font-semibold text-gray-700 dark:text-gray-300">Amina</span>
            <button class="px-1.5 py-0.5 text-[8px] font-semibold rounded bg-blue-50 text-blue-600 hover:bg-blue-100">Edit/Resolve</button>
        </div>
    </div>

    <!-- Mini Card 5 -->
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border dark:border-slate-700 p-2 flex flex-col justify-between hover:shadow-md transition border-l-4 border-blue-500">
        <div>
            <div class="flex justify-between items-center mb-1">
                <span class="px-1.5 py-0.5 text-[9px] font-bold rounded bg-blue-100 text-blue-600">Low</span>
            </div>
            <h3 class="text-xs font-bold text-gray-900 dark:text-white truncate">Khulna</h3>
            <p class="text-[9px] text-gray-500 leading-tight">IIG</p>
            <p class="text-[9px] text-gray-500">ID:1001813</p>
            <p class="mt-1 text-[9px]">Status:
                <span class="px-1.5 py-0.5 text-[9px] font-bold rounded bg-gray-200 text-green-600">Open</span>
            </p>
        </div>

        <div class="text-[9px] text-gray-500 dark:text-gray-400 border-t dark:border-slate-700 mt-2 pt-1 space-y-0.5">
            <div class="flex items-center space-x-1">
                <svg class="w-2.5 h-2.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>Started: 1h</span>
            </div>
            <div class="flex items-center space-x-1">
                <svg class="w-2.5 h-2.5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>ETR: 7PM</span>
            </div>
            <div class="flex items-center space-x-1">
                <svg class="w-2.5 h-2.5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>RT: 6:00 PM</span>
            </div>
        </div>

        <div class="flex justify-between items-center border-t dark:border-slate-700 mt-2 pt-1">
            <span class="text-[9px] font-semibold text-gray-700 dark:text-gray-300">Kamal</span>
            <button class="px-1.5 py-0.5 text-[8px] font-semibold rounded bg-blue-50 text-blue-600 hover:bg-blue-100">Edit/Resolve</button>
        </div>
    </div>

    <!-- Mini Card 2 -->
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-100 dark:border-slate-700 p-2 flex flex-col justify-between hover:shadow-md transition border-l-4 border-green-500">
        <div>
            <div class="flex justify-between items-center mb-1">
                <span class="px-1.5 py-0.5 text-[9px] font-bold rounded bg-green-100 text-green-600">Resolved</span>
            </div>
            <h3 class="text-xs font-bold text-gray-900 dark:text-white truncate">Chittagong</h3>
            <p class="text-[9px] text-gray-500 leading-tight">Hardware</p>
            <p class="text-[9px] text-gray-500">ID:1001810</p>
            <p class="mt-1 text-[9px]">Status:
                <span class="px-1.5 py-0.5 text-[9px] font-bold rounded bg-gray-200 text-green-600">Closed</span>
            </p>
        </div>

        <div class="text-[9px] text-gray-500 dark:text-gray-400 border-t dark:border-slate-700 mt-2 pt-1 space-y-0.5">
            <div class="flex items-center space-x-1">
                <svg class="w-2.5 h-2.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>Started: Yesterday</span>
            </div>
            <div class="flex items-center space-x-1">
                <svg class="w-2.5 h-2.5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>Done</span>
            </div>
        </div>

        <div class="flex justify-between items-center border-t dark:border-slate-700 mt-2 pt-1">
            <span class="text-[9px] font-semibold text-gray-700 dark:text-gray-300">Javed</span>
            <button class="px-1.5 py-0.5 text-[8px] font-semibold rounded bg-gray-100 text-gray-600 hover:bg-gray-200">View</button>
        </div>
    </div>

    <!-- Mini Card 4 -->
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-100 dark:border-slate-700 p-2 flex flex-col justify-between hover:shadow-md transition border-l-4 border-red-500">
        <div>
            <div class="flex justify-between items-center mb-1">
                <span class="px-1.5 py-0.5 text-[9px] font-bold rounded bg-red-100 text-red-600">Critical</span>
            </div>
            <h3 class="text-xs font-bold text-gray-900 dark:text-white truncate">Rajshahi</h3>
            <p class="text-[9px] text-gray-500 leading-tight">Power</p>
            <p class="text-[9px] text-gray-500">ID:1001812</p>
            <p class="mt-1 text-[9px]">Status:
                <span class="px-1.5 py-0.5 text-[9px] font-bold rounded bg-gray-200 text-green-600">Open</span>
            </p>
        </div>

        <div class="text-[9px] text-gray-500 dark:text-gray-400 border-t dark:border-slate-700 mt-2 pt-1 space-y-0.5">
            <div class="flex items-center space-x-1">
                <svg class="w-2.5 h-2.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>Started: 30m</span>
            </div>
            <div class="flex items-center space-x-1">
                <svg class="w-2.5 h-2.5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>ETR: 5PM</span>
            </div>
            <div class="flex items-center space-x-1">
                <svg class="w-2.5 h-2.5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>RT: 6:00 PM</span>
            </div>
        </div>

        <div class="flex justify-between items-center border-t dark:border-slate-700 mt-2 pt-1">
            <span class="text-[9px] font-semibold text-gray-700 dark:text-gray-300">Sagor</span>
            <button class="px-1.5 py-0.5 text-[8px] font-semibold rounded bg-blue-50 text-blue-600 hover:bg-blue-100">Edit/Resolve</button>
        </div>
    </div>

    <!-- Mini Card 6 -->
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-100 dark:border-slate-700 p-2 flex flex-col justify-between hover:shadow-md transition border-l-4 border-purple-500">
        <div>
            <div class="flex justify-between items-center mb-1">
                <span class="px-1.5 py-0.5 text-[9px] font-bold rounded bg-yellow-100 text-yellow-700">Mid</span>
            </div>
            <h3 class="text-xs font-bold text-gray-900 dark:text-white truncate">Dhaka South</h3>
            <p class="text-[9px] text-gray-500 leading-tight">NTTN</p>
            <p class="text-[9px] text-gray-500">ID:1001814</p>
            <p class="mt-1 text-[9px]">Status:
                <span class="px-1.5 py-0.5 text-[9px] font-bold rounded bg-gray-200 text-green-600">Paused</span>
            </p>
        </div>

        <div class="text-[9px] text-gray-500 dark:text-gray-400 border-t dark:border-slate-700 mt-2 pt-1 space-y-0.5">
            <div class="flex items-center space-x-1">
                <svg class="w-2.5 h-2.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>Started: 5h</span>
            </div>
            <div class="flex items-center space-x-1">
                <svg class="w-2.5 h-2.5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>ETR: N/A</span>
            </div>
        </div>

        <div class="flex justify-between items-center border-t dark:border-slate-700 mt-2 pt-1">
            <span class="text-[9px] font-semibold text-gray-700 dark:text-gray-300">Rita</span>
            <button class="px-1.5 py-0.5 text-[8px] font-semibold rounded bg-blue-50 text-blue-600 hover:bg-blue-100">Edit/Resolve</button>
        </div>
    </div>

</div>
    <!-- FLOATING ACTION BUTTON -->
    <div class="fixed bottom-6 right-6 z-50">
        <button class="bg-gradient-to-r from-blue-600 to-purple-600 text-white w-14 h-14 rounded-full shadow-2xl flex items-center justify-center transform transition duration-200 hover:scale-105 hover:-translate-y-1">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
        </button>
    </div>

</body>
</html>