<div x-data="{ activeTab: @entangle('currentStatusBtn') }">
       <!-- NAVIGATION -->
    <nav class="sticky top-0 z-50 bg-blue-600/90 backdrop-blur-lg border-b border-white/10 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">

                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-white/20 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <span class="text-white font-bold text-xl tracking-tight">BDCOM Incident Monitor</span>
                </div>

                <div class="flex items-center space-x-4">
                    
                    <!-- Home Icon -->
                    <a href="{{ route('incidentdashboard', ['status' => 'open']) }}" class="text-white/90 hover:text-white flex items-center space-x-2 transition font-medium">
                        <svg class="w-8 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                    </a>

                    <div class="h-6 w-px bg-white/30 hidden sm:block"></div>

                    <!-- NAVIGATION BUTTONS -->
                    <div class="flex items-center space-x-2">
                        
                        <!-- Open Button -->
                        <button @click="activeTab = 'open'" wire:click="setStatus('open')" 
                           :class="activeTab === 'open' ? 'bg-white text-blue-600 shadow' : 'bg-white/10 text-white/80 hover:bg-white/20'"
                           class="px-3 py-1.5 text-xs font-bold rounded-full transition">
                            Open
                        </button>

                        <!-- Resolved Button -->
                        <button @click="activeTab = 'Resolved'" wire:click="setStatus('Resolved')" 
                           :class="activeTab === 'Resolved' ? 'bg-white text-blue-600 shadow' : 'bg-white/10 text-white/80 hover:bg-white/20'"
                           class="px-3 py-1.5 text-xs font-bold rounded-full transition">
                            Resolved
                        </button>

                        <!-- Paused Button -->
                        <button @click="activeTab = 'Paused'" wire:click="setStatus('Paused')" 
                           :class="activeTab === 'Paused' ? 'bg-white text-blue-600 shadow' : 'bg-white/10 text-white/80 hover:bg-white/20'"
                           class="px-3 py-1.5 text-xs font-bold rounded-full transition">
                            Paused
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="relative overflow-hidden">
        <div class="max-w-10xl mx-auto px-4 sm:px-6 lg:px-8 py-0">
            
            <!-- Filter Bar -->
            <div class="mb-4 mt-4">
                <div class="flex gap-2 flex-wrap items-center">
                    
                    <!-- Importance Filter -->
                    <div class="relative">
                        <select wire:model.live="filterImportance" class="bg-slate-50 dark:bg-slate-700 border-0 rounded-lg px-9 py-2.5 text-sm font-medium focus:ring-2 focus:ring-blue-500 outline-none cursor-pointer appearance-none pr-10">
                            <option value="">All Importance</option>
                            <option value="High">High</option>
                            <option value="Mid">Mid</option>
                            <option value="Low">Low</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                        </div>
                    </div>

                    <!-- Category Filter -->
                    <div class="relative">
                        <select wire:model.live="filterCategory" class="bg-slate-50 dark:bg-slate-700 border-0 rounded-lg px-9 py-2.5 text-sm font-medium focus:ring-2 focus:ring-blue-500 outline-none cursor-pointer appearance-none pr-10">
                            <option value="">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                         <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                        </div>
                    </div>

                    <!-- Zone Filter -->
                    <div class="relative">
                        <select wire:model.live="filterZone" class="bg-slate-50 dark:bg-slate-700 border-0 rounded-lg px-9 py-2.5 text-sm font-medium focus:ring-2 focus:ring-blue-500 outline-none cursor-pointer appearance-none pr-10">
                            <option value="">All Zones</option>
                            @foreach($zonals as $zone)
                                <option value="{{ $zone->name }}">{{ $zone->name }}</option>
                            @endforeach
                        </select>
                         <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                        </div>
                    </div>

                    <div class="shrink-0 ml-auto">
                         <button wire:click="$set('showAddModal', true)" class="inline-flex items-center gap-2 bg-gradient-to-r from-green-500 to-emerald-600 text-white px-9 py-2.5 rounded-lg font-bold shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                            Add Incident Log
                        </button>
                    </div>
                </div>
            </div>

            @if (session()->has('status'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg text-sm font-medium">
                    {{ session('status') }}
                </div>
            @endif


            <!-- OPEN INCIDENTS GRID -->
            <div x-show="activeTab === 'open'" x-cloak class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-6 gap-4 mb-20">
                @foreach($openIncidents as $incident)
                    @include('livewire.partials._incident-card', ['incident' => $incident])
                @endforeach
            </div>

            <!-- RESOLVED INCIDENTS GRID -->
            <div x-show="activeTab === 'Resolved'" x-cloak class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-6 gap-4 mb-20">
                @foreach($resolvedIncidents as $incident)
                    @include('livewire.partials._incident-card', ['incident' => $incident])
                @endforeach
            </div>

            <!-- PAUSED INCIDENTS GRID -->
            <div x-show="activeTab === 'Paused'" x-cloak class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-6 gap-4 mb-20">
                @foreach($pausedIncidents as $incident)
                    @include('livewire.partials._incident-card', ['incident' => $incident])
                @endforeach
            </div>

        </div>
    </div>

    @teleport('body')
        <div x-cloak> 
            <div wire:transition.opacity.duration.300ms>
                @if($showEditModal)
                    <div class="fixed inset-0 z-[60] bg-black/60 backdrop-blur-sm" wire:click="closeModal"></div>
                @endif
            </div>

            <div wire:transition.opacity.scale.duration.300ms>
                @if($showEditModal)
                    <div class="fixed inset-0 z-[60] overflow-y-auto">
                        <div class="relative min-h-screen flex items-center justify-center p-4">
                            <div class="relative bg-white dark:bg-slate-800 w-full max-w-lg rounded-2xl shadow-2xl p-6 border border-gray-200 dark:border-slate-700">
                                
                                <button wire:click="closeModal" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>

                                <div class="mb-6">
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Edit Incident</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                        Updating ID: <span class="font-mono font-bold text-blue-600">{{ $editId }}</span>
                                    </p>
                                </div>

                                <form wire:submit="update" class="space-y-5">
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                                        <select wire:model.live="editStatus" class="w-full bg-slate-50 dark:bg-slate-700 border-0 rounded-lg px-4 py-2.5 text-sm font-medium focus:ring-2 focus:ring-blue-500 outline-none">
                                            <option value="Open">Open</option>
                                            <option value="InProgress">In Progress</option>
                                            <option value="Paused">Paused</option>
                                            <option value="Resolved">Resolved</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Update ETR</label>
                                        <input type="datetime-local" wire:model="editEtr" 
                                               class="w-full bg-slate-50 dark:bg-slate-700 border-0 rounded-lg px-4 py-2.5 text-sm font-medium focus:ring-2 focus:ring-blue-500 outline-none">
                                    </div>

                                    @if($editStatus == 'Resolved')
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Exact RT</label>
                                            <input type="datetime-local" wire:model="editRt" 
                                                   class="w-full bg-slate-50 dark:bg-slate-700 border-0 rounded-lg px-4 py-2.5 text-sm font-medium focus:ring-2 focus:ring-blue-500 outline-none">
                                        </div>
            @error('editRt') 
                <span class="text-red-500 text-xs mt-1">{{ $message }}</span> 
            @enderror
                                    @endif

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Resolution Notes</label>
                                        <textarea wire:model="editNotes" rows="3" placeholder="Add notes here..."
                                                  class="w-full bg-slate-50 dark:bg-slate-700 border-0 rounded-lg px-4 py-2.5 text-sm font-medium focus:ring-2 focus:ring-blue-500 outline-none resize-none"></textarea>
                                    </div>

                                    <!-- Actions -->
                                    <div class="flex justify-end gap-3 pt-2">
                                        <button type="button" wire:click="closeModal" 
                                                class="px-4 py-2 text-sm font-bold text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-slate-700 rounded-lg hover:bg-gray-200 dark:hover:bg-slate-600 transition">
                                            Cancel
                                        </button>
                                        <button type="submit" 
                                                class="px-6 py-2 text-sm font-bold text-white bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow hover:shadow-md transition">
                                            Save Changes
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endteleport

@teleport('body')
    <div x-cloak> 
        <div wire:transition.opacity.duration.300ms>
            @if($showAddModal)
                <div class="fixed inset-0 z-[60] bg-black/60 backdrop-blur-sm" wire:click="$set('showAddModal', false)"></div>
            @endif
        </div>

        <div wire:transition.opacity.scale.duration.300ms>
            @if($showAddModal)
                <div class="fixed inset-0 z-[60] overflow-y-auto">
                    <div class="relative min-h-screen flex items-center justify-center p-4">
                        <div class="relative bg-white dark:bg-slate-800 w-full max-w-2xl rounded-2xl shadow-2xl p-6 border border-gray-200 dark:border-slate-700">
                            <button wire:click="$set('showAddModal', false)" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition z-10">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                            <livewire:incident-form />
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endteleport

    @php
        function getBorderClass($incident) {
            if ($incident->status === 'Paused') return 'border-purple-500';
            if ($incident->importance === 'High') return 'border-red-500';
            if ($incident->importance === 'Mid') return 'border-yellow-500';
            return 'border-gray-500';
        }

        function getImportanceClass($incident) {
            if ($incident->importance === 'High') return 'bg-red-100 text-red-600';
            if ($incident->importance === 'Mid') return 'bg-yellow-100 text-yellow-700';
            return 'bg-blue-100 text-blue-600';
        }

        function getStatusClass($incident) {
            if ($incident->status === 'Resolved') return 'bg-green-100 text-green-600';
            if ($incident->status === 'Paused') return 'bg-purple-100 text-purple-600';
            if ($incident->status === 'InProgress') return 'bg-yellow-100 text-yellow-700';
            return 'bg-gray-200 text-red-600'; 
        }
    @endphp
</div>