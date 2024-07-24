@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-bold mb-4">Asking</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($askings as $asking)
                <div class="bg-white shadow-md rounded-lg p-4">
                    <h2 class="text-xl font-semibold mb-2">{{ $asking->title }}</h2>
                    <x-questionnaire :questionnaire="$asking->questionnaire" />
                </div>
            @endforeach
        </div>
    </div>
@endsection
