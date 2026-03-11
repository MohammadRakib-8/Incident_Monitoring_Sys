<div class="bg-white p-6 rounded-lg shadow-md h-fit">
    
    <h2 class="text-xl font-bold text-gray-800 border-b pb-2 mb-6">Add New Incident</h2>

    {{-- @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <strong class="font-bold">Please fix the following errors:</strong>
            <ul class="mt-2 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif --}}

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit="submit" class="space-y-5">
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Reporter Name</label>
            @auth
                <input type="text" value="{{ auth()->user()->name }}" readonly class="mt-1 block w-full bg-gray-100 border border-gray-300 rounded-md shadow-sm py-2 px-3 text-gray-600 cursor-not-allowed">
            @else
                <input type="text" wire:model="reporter_name" placeholder="Enter your name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm py-2 px-3">
                @error('reporter_name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            @endauth
        </div>
<div class="flex gap-6 w-auto">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Zonal Name</label>
            <select wire:model="zonal" class="mt-1 block w-auto border-gray-300 rounded-md shadow-sm py-2 px-auto">
                <option value="">Select Zone</option>
                @foreach ($zonals as $zone)
                    <option value="{{ $zone->name }}">{{ $zone->name }}</option>
                @endforeach
            </select>
            @error('zonal') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
            <select wire:model="category" class="mt-1 block w-auto border-gray-300 rounded-md shadow-sm py-2 px-auto">
                <option value="">Select Category</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                @endforeach
            </select>
            @error('category') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Importance</label>
            <select wire:model="importance" class="mt-1 block w-auto border-gray-300 rounded-md shadow-sm py-2 px-auto">
                <option value="High">High</option>
                <option value="Mid">Mid</option>
                <option value="Low">Low</option>
            </select>
        </div>
    </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Incident Description</label>
            <textarea wire:model="description" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm py-2 px-3" placeholder="Describe the issue here..."></textarea>
            @error('description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>
<div class="flex gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Incident Start Time</label>
            <input type="datetime-local" wire:model="start_time" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm py-2 px-auto">
            @error('start_time') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Initial ETR</label>
            <input type="datetime-local" wire:model="initial_etr" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm py-2 px-auto">
            @error('initial_etr') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>
</div>
         {{-- <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Exact Resulation Time</label>
            <input type="datetime-local" wire:model="resulation_time" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm py-2 px-3">
            @error('resulation_time') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div> --}}

<div class="pt-2">
<button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-4 rounded transition duration-150">
    Submit
</button>
  </div>
    </form>
</div>