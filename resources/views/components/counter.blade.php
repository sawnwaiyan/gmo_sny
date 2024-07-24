<div x-data="{ count: 0 }">
    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
        @click="count++">Increment</button>
    <span x-text="count"></span>
</div>
