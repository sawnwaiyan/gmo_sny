@props(['name', 'label', 'placeholder' => ''])

<div class="my-2">
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-2">{{ $label }}</label>
    <textarea id="{{ $name }}" name="{{ $name }}" placeholder="{{ $placeholder }}"
        {{ $attributes->merge(['class' => 'w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600']) }}></textarea>
</div>
