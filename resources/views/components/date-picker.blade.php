@props(['placeholder' => '日付を選択', 'name' => 'date', 'label'])

<div x-data="datePicker('{{ $name }}')" x-init="init" class="mb-4">
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-2">{{ $label }}</label>
    <div x-data="datePicker('{{ $name }}')" x-init="init" class="flex items-center space-x-4">
        <input type="text" x-ref="input" :name="name" placeholder="{{ $placeholder }}"
            :value="selectedDate"
            {{ $attributes->merge(['class' => 'w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600']) }}>
        <button @click="clearDate" type="button"
            class="px-4 py-2 bg-red-400 text-white rounded-lg hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-400">✕</button>
    </div>
</div>

<script>
    function datePicker(name) {
        return {
            name: name,
            selectedDate: '',
            flatpickrInstance: null,
            init() {
                this.$nextTick(() => {
                    this.flatpickrInstance = flatpickr(this.$refs.input, {
                        locale: 'ja', // 日本語化
                        dateFormat: "Y-m-d",
                        onChange: (selectedDates, dateStr) => {
                            this.selectedDate = dateStr;
                        }
                    });
                });
            },
            clearDate() {
                this.flatpickrInstance.clear();
                this.selectedDate = '';
            }
        }
    }
</script>
