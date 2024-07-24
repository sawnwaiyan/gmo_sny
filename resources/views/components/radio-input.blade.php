@props(['name', 'label', 'options' => []])

<div class="my-2">
    <span class="block text-sm font-medium text-gray-700 mb-2">{{ $label }}</span>
    <div class="space-y-2">
        @foreach ($options as $option)
            <label class="inline-flex items-center cursor-pointer">
                <input type="radio" name="{{ $name }}" value="{{ $option['value'] }}"
                    {{ $attributes->merge(['class' => 'w-4 h-4']) }}>
                <span class="m-2">{{ $option['label'] }}</span>
            </label>
        @endforeach
    </div>
</div>
