<div class="bg-white p-4 rounded-lg shadow-md h-fit text-sm">
    
    <h2 class="text-lg font-bold text-gray-800 border-b pb-2 mb-4">Add New Incident</h2>

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-3 py-2 rounded mb-3">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit="submit" class="space-y-3">
        
        <div>
            <label class="block font-medium text-gray-700 mb-1">Reporter Name</label>
            @auth
                <input type="text" value="{{ auth()->user()->name }}" readonly class="mt-1 block w-full bg-gray-100 border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 text-gray-600 cursor-not-allowed">
            @else
                <input type="text" wire:model="reporter_name" placeholder="Enter your name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5">
                @error('reporter_name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            @endauth
        </div>

        <div class="flex gap-4 w-auto">
            <div>
                <label class="block font-medium text-gray-700 mb-1">Zonal Name</label>
                <select wire:model="zonal" class="mt-1 block w-auto border border-gray-300 rounded-md shadow-sm py-1.5 px-4.5">
                    <option value="">Select Zone</option>
                    @foreach ($zonals as $zone)
                        <option value="{{ $zone->name }}">{{ $zone->name }}</option>
                    @endforeach
                </select>
                @error('zonal') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block font-medium text-gray-700 mb-1">Category</label>
                <select wire:model="category" class="mt-1 block w-auto border border-gray-300 rounded-md shadow-sm py-1.5 px-4.5">
                    <option value="">Select Category</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('category') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block font-medium text-gray-700 mb-1">Importance</label>
                <select wire:model="importance" class="mt-1 block w-auto border border-gray-300 rounded-md shadow-sm py-1.5 px-5.5">
                    <option value="High">High</option>
                    <option value="Mid">Mid</option>
                    <option value="Low">Low</option>
                </select>
            </div>
        </div>

        <div>
            <label class="block font-medium text-gray-700 mb-1">Incident Description</label>
            <textarea wire:model="description" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5" placeholder="Describe the issue here..."></textarea>
            @error('description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <div class="flex gap-4">
            <div>
                <label class="block font-medium text-gray-700 mb-1">Incident Start Time</label>
                <input type="datetime-local" wire:model='start_time' class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5">
                @error('start_time') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="flex gap-4">
            <div>
                <label class="block font-medium text-gray-700 mb-1">Initial Reporting Time</label>
                <input type="datetime-local" wire:model="first_report_time" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5">
                @error('first_report_time') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block font-medium text-gray-700 mb-1">Initial ETR</label>
                <input type="datetime-local" wire:model="initial_etr" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5">
                @error('initial_etr') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-150">
                Submit
            </button>
        </div>
    </form>
</div>