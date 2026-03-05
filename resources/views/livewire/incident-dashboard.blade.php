<div x-data="incidentDashboard(@json($incidents ?? []))">
    
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
                    <button @click="currentFilter = 'open'" class="text-white/90 hover:text-white flex items-center space-x-2 transition font-medium">
                        <svg class="w-8 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                    </button>

                    <div class="h-6 w-px bg-white/30 hidden sm:block"></div>

                    <!-- FILTER BUTTONS -->
                    <div class="flex items-center space-x-2">
                        <button @click="currentFilter = 'open'" :class="currentFilter === 'open' ? 'bg-white text-blue-600 shadow' : 'bg-white/10 text-white/80 hover:bg-white/20'" class="px-3 py-1.5 text-xs font-bold rounded-full transition">Open</button>
                        <button @click="currentFilter = 'resolved'" :class="currentFilter === 'resolved' ? 'bg-white text-blue-600 shadow' : 'bg-white/10 text-white/80 hover:bg-white/20'" class="px-3 py-1.5 text-xs font-bold rounded-full transition">Resolved</button>
                        <button @click="currentFilter = 'paused'" :class="currentFilter === 'paused' ? 'bg-white text-blue-600 shadow' : 'bg-white/10 text-white/80 hover:bg-white/20'" class="px-3 py-1.5 text-xs font-bold rounded-full transition">Paused</button>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- 2. HERO & CONTENT AREA -->
    <div class="relative overflow-hidden">
        <div class="max-w-10xl mx-auto px-4 sm:px-6 lg:px-8 py-0">
            
            <!-- Filter Bar -->
            <div class="mb-4 mt-4">
                <div class="flex gap-2 flex-wrap items-center">
                    <select class="bg-slate-50 dark:bg-slate-700 border-0 rounded-lg px-9 py-2.5 text-sm font-medium focus:ring-2 focus:ring-blue-500 outline-none cursor-pointer">
                        <option>Importance</option><option>High</option><option>Mid</option><option>Low</option>
                    </select>
                   <select class="bg-slate-50 dark:bg-slate-700 border-0 rounded-lg px-9 py-2.5 text-sm font-medium focus:ring-2 focus:ring-blue-500 outline-none cursor-pointer">
                        <option>Category</option><option>Logical</option><option>Physical</option><option>IIG</option><option>NTTN</option>
                    </select>
                    <select class="bg-slate-50 dark:bg-slate-700 border-0 rounded-lg px-9 py-2.5 text-sm font-medium focus:ring-2 focus:ring-blue-500 outline-none cursor-pointer">
                        <option>All Zones</option><option>Dhaka North</option><option>Dhaka South</option><option>Chittagong</option>
                    </select>

                       <div class="shrink-0 ml-auto">
                    <button class="inline-flex items-center gap-2 bg-gradient-to-r from-green-500 to-emerald-600 text-white px-4 py-2.5 rounded-lg font-bold shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                        Add Incident Log
                    </button>
                </div>
                </div>
            </div>

            <!-- CARDS GRID -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-6 gap-4 mb-20">
                
                <template x-for="incident in incidents" :key="incident.id">
                    <div x-show="shouldShowCard(incident)"
                         x-transition
                         class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-100 dark:border-slate-700 p-3 flex flex-col justify-between hover:shadow-md transition border-l-4"
                         :class="getBorderClass(incident)">
                        
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="px-1.5 py-0.5 text-[11px] font-bold rounded"
                                      :class="getImportanceClass(incident)"
                                      x-text="incident.importance"></span>

                                <p class="font-bold text-[11px] text-gray-500 leading-tight uppercase tracking-wide" x-text="incident.category"></p>

                                <span class="px-1.5 py-0.5 text-[11px] font-bold rounded"
                                      :class="getStatusClass(incident)"
                                      x-text="incident.status"></span>
                            </div>

                            <div class="mb-2">
                                <div class="flex items-baseline justify-between border-b border-dashed border-gray-200 dark:border-slate-600 pb-1">
                                    <h3 class="text-base font-bold text-gray-900 dark:text-white" x-text="incident.zone"></h3>
                                    <p class="text-[11px] text-gray-500 font-mono bg-gray-100 dark:bg-slate-700 px-1.5 py-0.5 rounded" x-text="'#' + incident.id"></p>
                                </div>
                            </div>

                        </div>

                        <!-- Time Logs-->
                        <div class="text-[12px] text-gray-600 dark:text-gray-400 space-y-1 mb-3">
                            <div class="flex items-center space-x-2">
                                <svg class="w-3 h-3 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="font-semibold text-gray-700 dark:text-gray-300 w-12">Started:</span>
                                <span class="text-[11px]" x-text="incident.started"></span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <svg class="w-3 h-3 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="font-semibold text-gray-700 dark:text-gray-300 w-12">ETR:</span>
                                <span class="text-[11px]" x-text="incident.etr"></span>
                            </div>
                            <div class="flex items-center space-x-2" x-show="incident.status !== 'Open' && incident.status !== 'In Progress'&&incident.status !== 'Paused'">
                                <svg class="w-3 h-3 text-purple-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="font-semibold text-gray-700 dark:text-gray-300 w-12">RT:</span>
                                <span class="text-[11px]" x-text="incident.rt"></span>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="flex justify-between items-center border-t dark:border-slate-700 pt-2 mt-auto">
                            <span class="text-[11px] font-semibold text-gray-700 dark:text-gray-300" x-text="incident.reporter"></span>
                            <button class="px-2 py-1 text-[11px] font-semibold rounded bg-blue-50 text-blue-600 hover:bg-blue-100 transition">Edit/Resolve</button>
                        </div>
                    </div>
                </template>

            </div>
         
        </div>
    </div>

    <script>
        function incidentDashboard(serverData) {
            return {
                currentFilter: 'open',
                incidents: [], 

                init() {
                    if (serverData && serverData.length > 0) {
                        this.incidents = serverData;
                    } else {
                        this.incidents = [
                            { id: '1001809', zone: 'Dhaka North', category: 'Logical', importance: 'High', status: 'Open', status_class: 'open',
                              started: '03/26/2026, 09:12 AM', etr: '03/26/2026, 01:45 PM', reporter: 'Rakib' },
                            { id: '1001810', zone: 'Chittagong', category: 'Physical', importance: 'High', status: 'Resolved', status_class: 'resolved',
                              started: '03/25/2026, 06:55 PM', etr: '03/26/2026, 10:22 AM', rt: '03/26/2026, 08:03 AM', reporter: 'Javed' },
                            { id: '1001811', zone: 'Sylhet', category: 'Logical', importance: 'Mid', status: 'In Progress', status_class: 'in-progress',
                              started: '03/26/2026, 11:03 AM', etr: '03/26/2026, 03:30 PM', reporter: 'Amina' },
                            { id: '1001814', zone: 'Dhaka South', category: 'NTTN', importance: 'Mid', status: 'Paused', status_class: 'paused',
                              started: '03/26/2026, 07:48 AM', etr: '03/26/2026, 02:17 PM', reporter: 'Rita' },
                            { id: '1001813', zone: 'Khulna', category: 'IIG', importance: 'Low', status: 'Open', status_class: 'open',
                              started: '03/26/2026, 10:21 AM', etr: '03/26/2026, 05:02 PM', reporter: 'Kamal' },
                            { id: '1001812', zone: 'Rajshahi', category: 'Power', importance: 'High', status: 'In Progress', status_class: 'in-progress',
                              started: '03/26/2026, 11:27 AM', etr: '03/26/2026, 04:54 PM', reporter: 'Sagor' }
                        ];
                    }
                },

                shouldShowCard(incident) {
                    if (this.currentFilter === 'open') {
                        return incident.status_class === 'open' || incident.status_class === 'in-progress';
                    }
                    return incident.status_class === this.currentFilter;
                },


                getBorderClass(incident) {
                    // if (incident.status === 'Paused') return 'border-purple-500';
                    if (incident.importance === 'High') return 'border-red-500';
                    if (incident.status === 'Resolved') return 'border-green-500';
                    if (incident.importance === 'Mid') return 'border-yellow-500';
                    if(incident.importance === 'Low') return 'border-blue-400';
                    return 'border-gray-300';
                },

                getImportanceClass(incident) {
                    if (incident.importance === 'High') return 'bg-red-100 text-red-600';
                    if (incident.importance === 'Mid') return 'bg-yellow-100 text-yellow-700';
                    return 'bg-blue-100 text-blue-600';
                },

                getStatusClass(incident) {
                    if (incident.status === 'Resolved') return 'bg-green-100 text-green-600';
                    if (incident.status === 'Paused') return 'bg-purple-100 text-purple-600';
                    if (incident.status === 'In Progress') return 'bg-yellow-100 text-yellow-700';
                    return 'bg-gray-200 text-red-600'; 
                }
            }
        }
    </script>
</div>