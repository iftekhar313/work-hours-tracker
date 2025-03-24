<div class="max-w-3xl mx-auto p-8 bg-white shadow-xl rounded-2xl border border-gray-200">
    <!-- Company Logo -->
    <div class="flex justify-center mb-6">
        <img src="{{ asset('images/LogoTM-1-1.png') }}" alt="Company Logo" class="h-16">
    </div>

    <!-- Title -->
    <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">
        🕒 Coderkube Weekly Work Hours Tracker
    </h2>

    <div class="space-y-5">
        @foreach ($days as $dayKey => $time)
            <div class="bg-gradient-to-r from-blue-100 to-blue-200 p-5 rounded-lg shadow-md flex items-center gap-4">
                <label class="font-semibold text-lg text-gray-800 w-24">{{ ucfirst($dayKey) }}</label>

                <!-- Leave Checkbox -->
                <div class="flex items-center gap-2">
                    <input type="checkbox" wire:model="days.{{ $dayKey }}.leave" wire:change="updateTime" class="h-5 w-5 text-blue-600 border-gray-300 focus:ring-blue-500 rounded cursor-pointer">
                    <span class="text-gray-700 text-sm">On Leave (8h 30m)</span>
                </div>

                <!-- Half-Day Checkbox -->
                <div class="flex items-center gap-2">
                    <input type="checkbox" wire:model="days.{{ $dayKey }}.half_day" wire:change="updateTime" class="h-5 w-5 text-blue-600 border-gray-300 focus:ring-blue-500 rounded cursor-pointer">
                    <span class="text-gray-700 text-sm">Half Day (5h + Entered Time)</span>
                </div>

                <!-- Time Inputs -->
                <input type="text" wire:model.lazy="days.{{ $dayKey }}.input" class="border p-2 w-28 text-center rounded-md focus:ring-2 focus:ring-blue-400 shadow-sm placeholder-gray-500" placeholder="Paste time" {{ $time['leave'] ? 'disabled' : '' }}>

                <input type="number" wire:model.defer="days.{{ $dayKey }}.hours" wire:blur="updateTime" class="border p-2 w-20 text-center rounded-md focus:ring-2 focus:ring-blue-400 shadow-sm" min="0" placeholder="Hrs" {{ $time['leave'] ? 'disabled' : '' }}>

                <input type="number" wire:model.defer="days.{{ $dayKey }}.minutes" wire:blur="updateTime" class="border p-2 w-20 text-center rounded-md focus:ring-2 focus:ring-blue-400 shadow-sm" min="0" max="59" placeholder="Mins" {{ $time['leave'] ? 'disabled' : '' }}>
            </div>
        @endforeach
    </div>

    <!-- Total Hours Display -->
    <div class="mt-6 text-center bg-gradient-to-r from-blue-200 to-blue-300 p-6 rounded-lg shadow-md">
        <p class="text-xl font-semibold text-gray-800">Total Time:</p>
        <p class="text-3xl font-bold text-blue-700">{{ $totalHours }} hours {{ $totalMinutes }} minutes</p>
    </div>

    <!-- Motivational Message -->
    <div class="mt-4 text-center text-xl font-semibold text-green-700">
        {{ $message }}
    </div>
</div>
