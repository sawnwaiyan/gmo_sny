<div x-data="{ show: true, message: '{{ $message }}', type: '{{ $type }}' }" x-show="show" class="p-4 border-l-4"
    :class="{
        'bg-blue-100 border-blue-500 text-blue-700': type === 'info',
        'bg-green-100 border-green-500 text-green-700': type === 'success',
        'bg-yellow-100 border-yellow-500 text-yellow-700': type === 'warning',
        'bg-red-100 border-red-500 text-red-700': type === 'danger'
    }">
    <div class="flex justify-between items-center">
        <span x-text="message"></span>
        <button @click="show = false" class="text-xl font-bold">&times;</button>
    </div>
</div>
