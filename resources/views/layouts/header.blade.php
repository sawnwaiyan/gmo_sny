<div class="flex justify-between items-center p-4">
    <button @click="sidebarOpen = !sidebarOpen" class="p-1 rounded-md hover:bg-gray-200">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 6h16M4 12h16m-7 6h7"></path>
        </svg>
    </button>
    <h1 class="text-2xl font-semibold text-gray-800">{{ config('app.name', 'Laravel') }}</h1>
    <div class="flex items-center">
        <span class="text-gray-800">Welcome, User!</span>
    </div>
</div>
