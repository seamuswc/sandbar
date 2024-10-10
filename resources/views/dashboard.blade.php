@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <div class="row justify-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- Property Management Buttons with Tailwind CSS -->
                    <div class="mt-4 flex space-x-4">
                        <a href="{{ route('properties.index') }}" class="btn btn-primary bg-blue-500 text-black font-bold py-2 px-4 rounded hover:bg-blue-700">
                            View All Properties
                        </a>
                        <a href="{{ route('properties.create') }}" class="btn btn-success bg-green-500 text-black font-bold py-2 px-4 rounded hover:bg-green-700">
                            Add New Property
                        </a>
                    </div>

                    <!-- Laravel Inspirational Quote -->
                    <div class="mt-8 bg-gray-100 p-6 rounded-lg shadow-md">
                        <p class="text-xl italic text-center">
                            "{{ $quote }}"
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
