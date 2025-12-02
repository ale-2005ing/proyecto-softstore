@extends('layouts.app')

@section('title', 'Bienvenido')

@section('content')
<div class="flex flex-col justify-center items-center text-center">

    {{-- Contenedor --}}
    <div class="bg-white border border-slate-200 shadow-lg rounded-2xl p-10 max-w-2xl">

        {{-- Título --}}
        <h1 class="text-4xl font-extrabold text-slate-800 mb-6">
            Bienvenido a SoftStore
        </h1>

        {{-- Descripción --}}
        <p class="text-slate-600 text-lg mb-8">
            Administra tu inventario de manera rápida, segura e intuitiva.  
            Inicia sesión o regístrate para comenzar.
        </p>

        {{-- Botones --}}
        <div class="flex flex-col sm:flex-row gap-4 justify-center">

            {{-- Login --}}
            <a href="{{ route('login') }}"
                class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 transition text-white px-6 py-3 rounded-lg font-semibold shadow-sm">
                Iniciar Sesión
            </a>

            {{-- Register --}}
            <a href="{{ route('register') }}"
                class="w-full sm:w-auto bg-slate-100 hover:bg-slate-200 transition text-slate-700 px-6 py-3 rounded-lg font-semibold border border-slate-300">
                Registrarse
            </a>
        </div>

    </div>
</div>
@endsection