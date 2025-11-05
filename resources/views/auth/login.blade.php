@extends('layouts.app')

@section('title', 'Iniciar sesión')

@section('content')
<div class="flex justify-center">
    <div class="bg-gray-800 shadow-lg rounded-xl p-8 w-full max-w-md border border-gray-700">

        <!-- Título -->
        <h2 class="text-3xl font-bold text-blue-400 text-center mb-6">
            Iniciar Sesión
        </h2>

        <!-- Formulario -->
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-sm mb-1 text-gray-300">Correo electrónico</label>
                <input 
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    class="w-full px-4 py-2 rounded-lg bg-gray-900 text-white border border-gray-700
                           focus:border-blue-500 focus:ring focus:ring-blue-700 focus:ring-opacity-50 outline-none"
                >
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block text-sm mb-1 text-gray-300">Contraseña</label>
                <input 
                    id="password"
                    type="password"
                    name="password"
                    required
                    class="w-full px-4 py-2 rounded-lg bg-gray-900 text-white border border-gray-700
                           focus:border-blue-500 focus:ring focus:ring-blue-700 focus:ring-opacity-50 outline-none"
                >
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center mb-4">
                <input 
                    id="remember_me"
                    type="checkbox"
                    name="remember"
                    class="h-4 w-4 rounded border-gray-600 bg-gray-800 text-blue-600 focus:ring-blue-500"
                >
                <label for="remember_me" class="ml-2 text-sm text-gray-400">
                    Recuérdame
                </label>
            </div>

            <!-- Forgot Password -->
            <div class="mb-6 text-right">
                @if (Route::has('password.request'))
                    <a 
                        href="{{ route('password.request') }}" 
                        class="text-sm text-blue-500 hover:underline hover:text-blue-400">
                        ¿Olvidaste tu contraseña?
                    </a>
                @endif
            </div>

            <!-- Button -->
            <button 
                type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 transition text-white py-2 rounded-lg font-semibold">
                Ingresar
            </button>
        </form>
    </div>
</div>
@endsection
