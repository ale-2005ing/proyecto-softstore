@extends('layouts.app')

@section('title', 'Bienvenido')

@section('content')
<div class="flex flex-col justify-center items-center text-center">

    {{-- Contenedor --}}
    <div class="bg-gray-800 border border-gray-700 shadow-lg rounded-2xl p-10 max-w-2xl">

        {{-- Título --}}
        <h1 class="text-4xl font-extrabold text-blue-400 mb-6">
            Bienvenido a SoftStore
        </h1>

        {{-- Descripción --}}
        <p class="text-gray-300 text-lg mb-8">
            Administra tu inventario de manera rápida, segura e intuitiva.  
            Inicia sesión o regístrate para comenzar.
        </p>

        {{-- Botones --}}
        <div class="flex flex-col sm:flex-row gap-4 justify-center">

            {{-- Login --}}
            <a href="{{ route('login') }}"
                class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 transition text-white px-6 py-3 rounded-lg font-semibold">
                Iniciar Sesión
            </a>

            {{-- Register --}}
            <a href="{{ route('register') }}"
                class="w-full sm:w-auto bg-gray-700 hover:bg-gray-600 transition text-blue-400 px-6 py-3 rounded-lg font-semibold border border-gray-600">
                Registrarse
            </a>
        </div>

    </div>
</div>
@endsection
