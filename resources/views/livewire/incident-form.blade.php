<div class="bg-white p-6 rounded-lg shadow-md h-fit">
    <h2 class="text-xl font-bold text-gray-800 border-b pb-2 mb-6">Add New Incident</h2>

    <!-- Success Message -->
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit="submit" class="space-y-5">
        
        <!-- 1. Reporter Name (Smart Field) -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Reporter Name</label>
            
            @auth
                <!-- If logged in: Show Name (Read Only) -->
                <input type="text" 
                       value="{{ auth()->user()->name }}" 
                       readonly 
                       class="mt-1 block w-full bg-gray-100 border border-gray-300 rounded-md shadow-sm py-2 px-3 text-gray-600 cursor-not-allowed focus:outline-none">
            @else
                <!-- If Guest: Show Input Field -->
                <input type="text" wire:model="reporter_name" placeholder="Enter your name"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 py-2 px-3">
                @error('reporter_name') 
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span> 
                @enderror
            @endauth
        </div>

        <!-- 2. Zonal Name Dropdown -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Zonal Name</label>
            <select wire:model="zonal_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 py-2 px-3">
                <option value="">Select Zone</option>
                <option value="Dhaka North">Dhaka North</option>
                <option value="Dhaka South">Dhaka South</option>
                <option value="Chittagong">Chittagong</option>
                <option value="Khulna">Khulna</option>
                <option value="Sylhet">Sylhet</option>
                <option value="Rajshahi">Rajshahi</option>
            </select>
            @error('zonal_name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <!-- 3. Category Dropdown -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
            <select wire:model="category" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 py-2 px-3">
                <option value="Logical">Logical</option>
                <option value="Physical">Physical</option>
                <option value="IIG">IIG</option>
                <option value="NTTN">NTTN</option>
            </select>
            @error('category') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <!-- 4. Importance Dropdown -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Importance</label>
            <select wire:model="importance" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 py-2 px-3">
                <option value="High">High</option>
                <option value="Mid">Mid</option>
                <option value="Low">Low</option>
            </select>
        </div>

        <!-- 5. Description -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Incident Description</label>
            <textarea wire:model="description" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm py-2 px-3" placeholder="Describe the issue here..."></textarea>
            @error('description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <!-- 6. Incident Start Time -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Incident Start Time</label>
            <input type="datetime-local" wire:model="start_time" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm py-2 px-3">
            @error('start_time') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <!-- 7. Initial ETR -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Initial ETR</label>
            <input type="datetime-local" wire:model="initial_etr" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm py-2 px-3">
            @error('initial_etr') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-4 rounded transition duration-150">
                Submit Incident
            </button>
        </div>
    </form>
</div>