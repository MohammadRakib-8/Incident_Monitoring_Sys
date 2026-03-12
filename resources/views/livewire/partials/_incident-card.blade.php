
<div wire:key="incident-{{ $incident->id }}-{{ $currentStatusBtn }}-{{ $refreshKey }}" class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-100 dark:border-slate-700 p-3 flex flex-col justify-between hover:shadow-md transition border-l-4 {{ getBorderClass($incident) }}">
    <div>
        <!-- Top Row -->
        <div class="flex justify-between items-center mb-2">
            <span class="px-1.5 py-0.5 text-[11px] font-bold rounded {{ getImportanceClass($incident) }}">
                {{ $incident->importance }}
            </span>

            <p class="font-bold text-[11px] text-gray-500 leading-tight uppercase tracking-wide">
                {{ $incident->category->name ?? $incident->category_name ?? 'N/A' }}
            </p>

            <span class="px-1.5 py-0.5 text-[11px] font-bold rounded {{ getStatusClass($incident) }}">
                {{ $incident->status }}
            </span>
        </div>

        <!-- Main Info -->
        <div class="mb-2">
            <div class="flex items-baseline justify-between border-b border-dashed border-gray-200 dark:border-slate-600 pb-1">
                <h3 class="text-base font-bold text-gray-900 dark:text-white">{{ $incident->zonal->name ?? $incident->zonal_name ?? 'N/A' }}</h3>
                <p class="text-[11px] text-gray-500 font-mono bg-gray-100 dark:bg-slate-700 px-1.5 py-0.5 rounded">
                    #{{ $incident->id }}
                </p>
            </div>
        </div>
    </div>

    <div class="text-[12px] text-gray-600 dark:text-gray-400 space-y-1 mb-3">
        <div class="flex items-center space-x-2">
            <svg class="w-3 h-3 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="font-semibold text-gray-700 dark:text-gray-300 w-12">Started:</span>
            <span class="text-[11px]">{{ $incident->start_time ? $incident->start_time->format('m/d/y, h:i A') : 'N/A' }}</span>
        </div>
        <div class="flex items-center space-x-2">
            <svg class="w-3 h-3 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="font-semibold text-gray-700 dark:text-gray-300 w-12">Report Time:</span>
            <span class="text-[11px]">{{ $incident->first_report_time ? $incident->first_report_time->format('m/d/y, h:i A') : 'N/A' }}</span>
        </div>
        <div class="flex items-center space-x-2">
            <svg class="w-3 h-3 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="font-semibold text-gray-700 dark:text-gray-300 w-12">ETR:</span>
            <span class="text-[11px]">{{ $incident->initial_etr ? \Carbon\Carbon::parse($incident->initial_etr)->format('m/d/y, h:i A') : 'N/A' }}</span>
        </div>

        @if($incident->status === 'Resolved' && !empty($incident->resulation_time))
            <div class="flex items-center space-x-2">
                <svg class="w-3 h-3 text-purple-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="font-semibold text-gray-700 dark:text-gray-300 w-12">RT:</span>
                <span class="text-[11px]">{{ \Carbon\Carbon::parse($incident->resulation_time)->format('m/d/y, h:i A') }}</span>
            </div>
        @endif
    </div>

    <!-- Footer -->
    <div class="flex justify-between items-center border-t dark:border-slate-700 pt-2 mt-auto">
        <span class="text-[11px] font-semibold text-gray-700 dark:text-gray-300">{{ $incident->reporter_name }}</span>
        <button wire:click="edit({{ $incident->id }})" class="px-2 py-1 text-[11px] font-semibold rounded bg-blue-50 text-blue-600 hover:bg-blue-100 transition">
            Edit/Resolve
        </button>
    </div>
</div>
