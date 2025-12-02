@extends('layouts.app')

@section('title', 'Registrar Entrada')

@section('content')

    {{-- Título --}}
    <div class="mb-6 opacity-0 animate-[fadeInDown_0.6s_ease-out_forwards] flex justify-between items-center">
        <h1 class="text-3xl font-bold text-slate-800">Registrar Entrada</h1>
    </div>

    {{-- Card principal --}}
    <div class="bg-white rounded-2xl shadow-md p-8 opacity-0 animate-[fadeInUp_0.6s_ease-out_0.2s_forwards]">

        <form action="{{ route('entradas.store') }}" method="POST" id="formEntrada">
            @csrf

            {{-- PROVEEDOR PRINCIPAL DE LA ENTRADA --}}
            <div class="mb-6">
                <label class="block font-semibold text-slate-700 mb-2">Proveedor de la Entrada:</label>
                <div class="flex gap-2">
                    <select name="proveedor_id" 
                            class="flex-1 p-3 rounded-lg border border-slate-300 bg-white text-slate-700 
                                focus:ring-2 focus:ring-orange-400 transition-all duration-300"
                            required>
                        <option value="">Seleccione proveedor principal...</option>
                        @foreach ($proveedores as $prov)
                            <option value="{{ $prov->id }}">{{ $prov->nombre }}</option>
                        @endforeach
                    </select>
                    <button type="button" 
                            onclick="abrirModalProveedor()"
                            class="bg-green-500 hover:bg-green-600 text-white px-4 py-3 rounded-lg font-semibold 
                                shadow-md transition-all duration-300 hover:scale-105 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Nuevo
                    </button>
                </div>
            </div>

            <hr class="my-8 border-slate-200">

            {{-- SUBTITULO --}}
            <h2 class="text-xl font-semibold text-slate-800 mb-4">Productos</h2>

            <div id="productos-container">

                {{-- PRODUCTO BASE --}}
                <div class="producto-item bg-slate-50 p-5 rounded-xl border border-slate-200 shadow-sm mb-6
                            opacity-0 animate-[fadeInUp_0.6s_ease-out_0.3s_forwards]">

                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <input type="checkbox" class="toggle-nuevo w-4 h-4 text-orange-500 rounded focus:ring-orange-400">
                            <span class="font-medium text-slate-700">Crear producto nuevo</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">

                        {{-- Seleccionar existente --}}
                        <select name="productos[0][producto_id]" 
                                class="select-existente p-3 rounded-lg border border-slate-300 bg-white text-slate-700 
                                    focus:ring-2 focus:ring-orange-400 transition-all duration-300">
                            <option value="">Seleccione producto existente</option>
                            @foreach ($productos as $prod)
                                <option value="{{ $prod->id }}">{{ $prod->nombre }}</option>
                            @endforeach
                        </select>

                        {{-- Crear nuevo --}}
                        <input type="text" name="productos[0][nombre]" 
                            placeholder="Nuevo nombre"
                            onkeypress="return soloLetras(event)"
                            class="input-nuevo p-3 rounded-lg border border-slate-300 bg-white text-slate-700 hidden
                                    focus:ring-2 focus:ring-orange-400 transition-all duration-300">

                        {{-- Categoría con botón de crear --}}
                        <div class="flex gap-2">
                            <select name="productos[0][categoria_id]" 
                                    class="flex-1 p-3 rounded-lg border border-slate-300 bg-white text-slate-700
                                        focus:ring-2 focus:ring-orange-400 transition-all duration-300">
                                <option value="">Sin categoría</option>
                                @foreach ($categorias as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
                                @endforeach
                            </select>
                            <button type="button" 
                                    onclick="abrirModalCategoria()"
                                    class="bg-green-500 hover:bg-green-600 text-white px-3 py-3 rounded-lg font-semibold 
                                        shadow-sm transition-all duration-300 hover:scale-105 flex items-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-4 mb-4">
                        {{-- Cantidad --}}
                        <input type="text" name="productos[0][cantidad]"
                            placeholder="Cantidad"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                            class="input-cantidad p-3 rounded-lg border border-slate-300 bg-white text-slate-700
                                    focus:ring-2 focus:ring-orange-400 transition-all duration-300"
                            pattern="[0-9]*">

                        {{-- Precio compra --}}
                        <input type="text" name="productos[0][precio_compra]"
                            placeholder="Precio compra"
                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')"
                            class="input-precio p-3 rounded-lg border border-slate-300 bg-white text-slate-700
                                    focus:ring-2 focus:ring-orange-400 transition-all duration-300"
                            pattern="[0-9]+\.?[0-9]*">

                        {{-- Precio venta --}}
                        <input type="text" name="productos[0][precio_venta]"
                            placeholder="Precio venta"
                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')"
                            class="p-3 rounded-lg border border-slate-300 bg-white text-slate-700
                                    focus:ring-2 focus:ring-orange-400 transition-all duration-300"
                            pattern="[0-9]+\.?[0-9]*">
                    </div>

                    <div>
                        {{-- Descripción --}}
                        <textarea name="productos[0][descripcion]"
                                placeholder="Descripción del producto (opcional)"
                                rows="2"
                                maxlength="150"
                                class="w-full p-3 rounded-lg border border-slate-300 bg-white text-slate-700
                                        focus:ring-2 focus:ring-orange-400 transition-all duration-300 resize-none"></textarea>
                    </div>
                </div>

            </div>

            {{-- Botón agregar producto --}}
            <button type="button" 
                    onclick="agregarProducto()"
                    class="bg-orange-500 hover:bg-orange-600 text-white px-5 py-3 rounded-lg font-semibold 
                        shadow-md transition-all duration-300 hover:scale-105 hover:shadow-lg flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Agregar Producto
            </button>

            {{-- Botón guardar --}}
            <div class="mt-8">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-bold shadow-md 
                            transition-all duration-300 hover:scale-105 hover:shadow-lg flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Guardar Entrada
                </button>
            </div>

        </form>

    </div>

    {{-- MODAL CREAR CATEGORÍA --}}
    <div id="modalCategoria" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-md w-full mx-4 animate-[fadeInUp_0.3s_ease-out]">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-slate-800">Nueva Categoría</h3>
                <button type="button" onclick="cerrarModalCategoria()" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form id="formCategoria" onsubmit="guardarCategoria(event)">
                <div class="mb-6">
                    <label class="block font-semibold text-slate-700 mb-2">Nombre de la Categoría:</label>
                    <input type="text" 
                           id="nombreCategoria" 
                           class="w-full p-3 rounded-lg border border-slate-300 bg-white text-slate-700
                                  focus:ring-2 focus:ring-orange-400 transition-all duration-300"
                           placeholder="Ej: Electrónicos, Alimentos, etc."
                           onkeypress="return soloLetras(event)"
                           required>
                </div>

                <div class="flex gap-3">
                    <button type="button" 
                            onclick="cerrarModalCategoria()"
                            class="flex-1 bg-slate-300 hover:bg-slate-400 text-slate-700 px-4 py-3 rounded-lg font-semibold 
                                   transition-all duration-300">
                        Cancelar
                    </button>
                    <button type="submit"
                            class="flex-1 bg-green-500 hover:bg-green-600 text-white px-4 py-3 rounded-lg font-semibold 
                                   shadow-md transition-all duration-300 hover:scale-105">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL CREAR PROVEEDOR --}}
    <div id="modalProveedor" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-md w-full mx-4 animate-[fadeInUp_0.3s_ease-out]">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-slate-800">Nuevo Proveedor</h3>
                <button type="button" onclick="cerrarModalProveedor()" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form id="formProveedor" onsubmit="guardarProveedor(event)">
                <div class="mb-4">
                    <label class="block font-semibold text-slate-700 mb-2">Nombre del Proveedor:</label>
                    <input type="text" 
                           id="nombreProveedor" 
                           class="w-full p-3 rounded-lg border border-slate-300 bg-white text-slate-700
                                  focus:ring-2 focus:ring-orange-400 transition-all duration-300"
                           placeholder="Nombre o razón social"
                           onkeypress="return soloLetras(event)"
                           required>
                </div>

                <div class="mb-4">
                    <label class="block font-semibold text-slate-700 mb-2">Teléfono:</label>
                    <input type="text" 
                           id="telefonoProveedor" 
                           class="w-full p-3 rounded-lg border border-slate-300 bg-white text-slate-700
                                  focus:ring-2 focus:ring-orange-400 transition-all duration-300"
                           placeholder="Número de contacto"
                           onkeypress="return soloNumeros(event)"
                           maxlength="20">
                </div>

                <div class="mb-6">
                    <label class="block font-semibold text-slate-700 mb-2">Email:</label>
                    <input type="email" 
                           id="emailProveedor" 
                           class="w-full p-3 rounded-lg border border-slate-300 bg-white text-slate-700
                                  focus:ring-2 focus:ring-orange-400 transition-all duration-300"
                           placeholder="correo@ejemplo.com">
                </div>

                <div class="flex gap-3">
                    <button type="button" 
                            onclick="cerrarModalProveedor()"
                            class="flex-1 bg-slate-300 hover:bg-slate-400 text-slate-700 px-4 py-3 rounded-lg font-semibold 
                                   transition-all duration-300">
                        Cancelar
                    </button>
                    <button type="submit"
                            class="flex-1 bg-green-500 hover:bg-green-600 text-white px-4 py-3 rounded-lg font-semibold 
                                   shadow-md transition-all duration-300 hover:scale-105">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Animaciones --}}
    <style>
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>

    {{-- SCRIPT --}}
    <script>
    console.log('✅ JavaScript cargado correctamente');
    let contador = 1;

    // ========== FUNCIONES MODALES ==========
    
    // Validación: Solo letras, espacios y acentos
    function soloLetras(event) {
        const char = String.fromCharCode(event.which);
        // Permite letras (mayúsculas y minúsculas), espacios, acentos y ñ
        if (!/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]$/.test(char)) {
            event.preventDefault();
            return false;
        }
        return true;
    }

    // Validación: Solo números enteros
    function soloNumeros(event) {
        const char = String.fromCharCode(event.which);
        // Solo permite números
        if (!/^[0-9]$/.test(char)) {
            event.preventDefault();
            return false;
        }
        return true;
    }

    // Validación: Números con decimales (permite punto)
    function soloNumerosDecimales(event) {
        const char = String.fromCharCode(event.which);
        const input = event.target;
        const value = input.value;
        
        // Permite números y un solo punto decimal
        if (!/^[0-9.]$/.test(char)) {
            event.preventDefault();
            return false;
        }
        
        // Evita múltiples puntos decimales
        if (char === '.' && value.includes('.')) {
            event.preventDefault();
            return false;
        }
        
        return true;
    }
    
    // Modal Categoría
    function abrirModalCategoria() {
        document.getElementById('modalCategoria').classList.remove('hidden');
        document.getElementById('nombreCategoria').focus();
    }

    function cerrarModalCategoria() {
        document.getElementById('modalCategoria').classList.add('hidden');
        document.getElementById('formCategoria').reset();
    }

    function guardarCategoria(event) {
        event.preventDefault();
        
        const nombre = document.getElementById('nombreCategoria').value.trim();
        
        if (!nombre) {
            alert('Por favor ingrese un nombre para la categoría');
            return;
        }

        // Enviar datos al servidor
        fetch('{{ route("categorias.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ nombre: nombre })
        })
        .then(async response => {
            const data = await response.json();
            
            if (!response.ok) {
                throw new Error(data.message || 'Error al crear la categoría');
            }
            
            return data;
        })
        .then(data => {
            if (data.success) {
                // Agregar la nueva categoría a todos los selects
                const nuevaOpcion = `<option value="${data.categoria.id}">${data.categoria.nombre}</option>`;
                document.querySelectorAll('select[name*="[categoria_id]"]').forEach(select => {
                    select.insertAdjacentHTML('beforeend', nuevaOpcion);
                    // Seleccionar la nueva categoría en el último producto agregado
                });
                
                // Seleccionar en el último producto agregado
                const ultimoProducto = document.querySelector('.producto-item:last-child');
                if (ultimoProducto) {
                    const selectCategoria = ultimoProducto.querySelector('select[name*="[categoria_id]"]');
                    if (selectCategoria) {
                        selectCategoria.value = data.categoria.id;
                    }
                }
                
                cerrarModalCategoria();
                
                // Mostrar mensaje de éxito
                alert('✅ Categoría creada exitosamente');
            } else {
                alert('Error: ' + (data.message || 'Error desconocido'));
            }
        })
        .catch(error => {
            console.error('Error completo:', error);
            let mensajeError = error.message;
            
            // Personalizar mensajes de error comunes
            if (mensajeError.includes('already been taken')) {
                mensajeError = '⚠️ Ya existe una categoría con ese nombre. Por favor use otro nombre.';
            }
            
            alert(mensajeError);
        });
    }

    // Modal Proveedor
    function abrirModalProveedor() {
        document.getElementById('modalProveedor').classList.remove('hidden');
        document.getElementById('nombreProveedor').focus();
    }

    function cerrarModalProveedor() {
        document.getElementById('modalProveedor').classList.add('hidden');
        document.getElementById('formProveedor').reset();
    }

    function guardarProveedor(event) {
        event.preventDefault();
        
        const nombre = document.getElementById('nombreProveedor').value.trim();
        const telefono = document.getElementById('telefonoProveedor').value.trim();
        const email = document.getElementById('emailProveedor').value.trim();
        
        if (!nombre) {
            alert('Por favor ingrese un nombre para el proveedor');
            return;
        }

        // Enviar datos al servidor
        fetch('{{ route("proveedores.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ 
                nombre: nombre,
                telefono: telefono,
                email: email
            })
        })
        .then(async response => {
            const data = await response.json();
            
            if (!response.ok) {
                throw new Error(data.message || 'Error al crear el proveedor');
            }
            
            return data;
        })
        .then(data => {
            if (data.success) {
                // Agregar el nuevo proveedor al selector principal de la entrada
                const nuevaOpcion = `<option value="${data.proveedor.id}">${data.proveedor.nombre}</option>`;
                
                const selectProveedorPrincipal = document.querySelector('select[name="proveedor_id"]');
                if (selectProveedorPrincipal) {
                    selectProveedorPrincipal.insertAdjacentHTML('beforeend', nuevaOpcion);
                    selectProveedorPrincipal.value = data.proveedor.id;
                }
                
                cerrarModalProveedor();
                
                // Mostrar mensaje de éxito
                alert('✅ Proveedor creado exitosamente');
            } else {
                alert('Error: ' + (data.message || 'Error desconocido'));
            }
        })
        .catch(error => {
            console.error('Error completo:', error);
            let mensajeError = error.message;
            
            // Personalizar mensajes de error comunes
            if (mensajeError.includes('already been taken')) {
                mensajeError = '⚠️ Ya existe un proveedor con ese nombre. Por favor use otro nombre.';
            } else if (mensajeError.includes('debe terminar en .com')) {
                mensajeError = '⚠️ El email debe terminar en .com';
            }
            
            alert(mensajeError);
        });
    }

    // Cerrar modal al hacer clic fuera
    window.onclick = function(event) {
        const modalCategoria = document.getElementById('modalCategoria');
        const modalProveedor = document.getElementById('modalProveedor');
        
        if (event.target === modalCategoria) {
            cerrarModalCategoria();
        }
        if (event.target === modalProveedor) {
            cerrarModalProveedor();
        }
    }

    // ========== FUNCIONES PRODUCTOS ==========

    function agregarProducto() {
        const cont = document.getElementById('productos-container');

        cont.insertAdjacentHTML('beforeend', `
            <div class="producto-item bg-slate-50 p-5 rounded-xl border border-slate-200 shadow-sm mb-6 animate-[fadeInUp_0.3s_ease-out]">

                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2">
                        <input type="checkbox" class="toggle-nuevo w-4 h-4 text-orange-500 rounded focus:ring-orange-400">
                        <span class="font-medium text-slate-700">Crear producto nuevo</span>
                    </div>
                    <button type="button" 
                            onclick="eliminarProducto(this)"
                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg font-semibold 
                                shadow-sm transition-all duration-300 hover:scale-105 flex items-center gap-1 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Eliminar
                    </button>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">

                    <select name="productos[${contador}][producto_id]" 
                            class="select-existente p-3 rounded-lg border border-slate-300 bg-white text-slate-700
                                focus:ring-2 focus:ring-orange-400 transition-all duration-300">
                        <option value="">Seleccione producto existente</option>
                        @foreach ($productos as $prod)
                            <option value="{{ $prod->id }}">{{ $prod->nombre }}</option>
                        @endforeach
                    </select>

                    <input type="text" name="productos[${contador}][nombre]" 
                        placeholder="Nuevo nombre"
                        onkeypress="return soloLetras(event)"
                        class="input-nuevo p-3 rounded-lg border border-slate-300 bg-white text-slate-700 hidden
                                focus:ring-2 focus:ring-orange-400 transition-all duration-300">

                    <div class="flex gap-2">
                        <select name="productos[${contador}][categoria_id]" 
                                class="flex-1 p-3 rounded-lg border border-slate-300 bg-white text-slate-700
                                    focus:ring-2 focus:ring-orange-400 transition-all duration-300">
                            <option value="">Sin categoría</option>
                            @foreach ($categorias as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
                            @endforeach
                        </select>
                        <button type="button" 
                                onclick="abrirModalCategoria()"
                                class="bg-green-500 hover:bg-green-600 text-white px-3 py-3 rounded-lg font-semibold 
                                    shadow-sm transition-all duration-300 hover:scale-105 flex items-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4 mb-4">
                    <input type="text" name="productos[${contador}][cantidad]"
                        placeholder="Cantidad"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                        class="input-cantidad p-3 rounded-lg border border-slate-300 bg-white text-slate-700
                                focus:ring-2 focus:ring-orange-400 transition-all duration-300"
                        pattern="[0-9]*">

                    <input type="text" name="productos[${contador}][precio_compra]"
                        placeholder="Precio compra"
                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')"
                        class="input-precio p-3 rounded-lg border border-slate-300 bg-white text-slate-700
                                focus:ring-2 focus:ring-orange-400 transition-all duration-300"
                        pattern="[0-9]+\.?[0-9]*">

                    <input type="text" name="productos[${contador}][precio_venta]"
                        placeholder="Precio venta"
                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')"
                        class="p-3 rounded-lg border border-slate-300 bg-white text-slate-700
                                focus:ring-2 focus:ring-orange-400 transition-all duration-300"
                        pattern="[0-9]+\.?[0-9]*">
                </div>

                <div>
                    <textarea name="productos[${contador}][descripcion]"
                            placeholder="Descripción del producto (opcional)"
                            rows="2"
                            maxlength="150"
                            class="w-full p-3 rounded-lg border border-slate-300 bg-white text-slate-700
                                    focus:ring-2 focus:ring-orange-400 transition-all duration-300 resize-none"></textarea>
                </div>
            </div>
        `);

        contador++;
        activarToggles();
    }

    function eliminarProducto(btn) {
        const item = btn.closest('.producto-item');
        item.style.animation = 'fadeInUp 0.3s ease-out reverse';
        setTimeout(() => item.remove(), 300);
    }

    function activarToggles() {
        document.querySelectorAll('.toggle-nuevo').forEach((checkbox) => {
            // Remover eventos anteriores
            checkbox.onchange = null;
            
            checkbox.onchange = () => {
                let item = checkbox.closest('.producto-item');
                let selectExistente = item.querySelector('.select-existente');
                let inputNuevo = item.querySelector('.input-nuevo');

                if (checkbox.checked) {
                    selectExistente.classList.add('hidden');
                    inputNuevo.classList.remove('hidden');
                    selectExistente.value = "";
                    selectExistente.removeAttribute('required');
                    inputNuevo.setAttribute('required', 'required');
                } else {
                    inputNuevo.classList.add('hidden');
                    selectExistente.classList.remove('hidden');
                    inputNuevo.value = "";
                    inputNuevo.removeAttribute('required');
                    selectExistente.setAttribute('required', 'required');
                }
            };
        });
    }

    // Validación antes de enviar el formulario
    document.getElementById('formEntrada').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const items = document.querySelectorAll('.producto-item');
        let hayProductosValidos = false;

        items.forEach(item => {
            const productoId = item.querySelector('.select-existente').value;
            const nombre = item.querySelector('.input-nuevo').value.trim();
            const cantidad = item.querySelector('.input-cantidad').value;
            const precio = item.querySelector('.input-precio').value;

            // Verificar si el producto tiene datos válidos
            const tieneProducto = productoId || nombre;
            const tieneDatos = cantidad && precio;

            if (tieneProducto && tieneDatos) {
                hayProductosValidos = true;
            } else if (tieneProducto || cantidad || precio) {
                // Si tiene algunos datos pero no todos, limpiar campos incompletos
                if (!tieneProducto || !tieneDatos) {
                    item.querySelector('.select-existente').value = '';
                    item.querySelector('.input-nuevo').value = '';
                    item.querySelector('.input-cantidad').value = '';
                    item.querySelector('.input-precio').value = '';
                }
            }
        });

        if (!hayProductosValidos) {
            alert('Debe agregar al menos un producto con cantidad y precio válidos');
            return false;
        }

        // Si todo está bien, enviar el formulario
        this.submit();
    });

    // Activar toggles al cargar la página
    activarToggles();
    </script>

@endsection