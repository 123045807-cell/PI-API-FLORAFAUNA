<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Administrar Consejos</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --primary: #8C5E2A;
            --bg-body: #f8f7f0;
            --card-bg: #ffffff;
            --border-color: #e5e7eb;
            --error-color: #dc3545;
        }

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-body);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            padding-top: 60px;
        }

        .navbar {
            position: fixed; top: 0; width: 100%; z-index: 1000;
            display: flex; justify-content: space-between; align-items: center;
            padding: 0 2rem; background-color: #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1); height: 60px; box-sizing: border-box;
        }
        .logo {
            display: flex; align-items: center; font-weight: bold; font-family: 'Playfair Display', serif; color: var(--primary);
        }
        .logo img { height: 40px; margin-right: 12px; }
        .links a { text-decoration: none; color: #333; font-weight: 500; font-size: 0.9rem; margin-left: 20px; transition: color 0.3s; }
        .links a:hover { color: var(--primary); }
        .is-invalid { border-color: var(--error-color) !important; background-color: #fff8f8 !important; }
        .error-feedback { color: var(--error-color); font-size: 0.75rem; margin-top: 4px; font-weight: 600; }

        .dashboard-wrapper {
            display: grid; 
            grid-template-columns: 380px 1fr; 
            gap: 30px;
            max-width: 1400px; 
            width: 100%; 
            margin: 0 auto; 
            padding: 40px 20px;
            box-sizing: border-box; 
            align-items: start;
        }

        .panel-formulario {
            background: #ffffff; padding: 25px; border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05); border: 1px solid #eee;
            position: sticky; top: 90px; 
        }
        .panel-formulario h2 {
            margin-top: 0; font-size: 1.6rem; color: var(--primary);
            font-family: 'Playfair Display', serif; margin-bottom: 20px;
            border-bottom: 2px solid #f0f0f0; padding-bottom: 10px;
        }

        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: 600; font-size: 0.85rem; color: #444; }
        
        input, textarea, select {
            width: 100%; padding: 10px; border: 1px solid #d1d5db;
            border-radius: 8px; font-family: 'Inter', sans-serif;
            box-sizing: border-box; font-size: 0.9rem; background-color: #fafafa;
            transition: all 0.2s;
        }
        textarea { height: 100px; resize: none; }
        input:focus, textarea:focus, select:focus { outline: none; border-color: var(--primary); background-color: #fff; }

        .btn-crear {
            background-color: var(--primary); color: white; border: none; padding: 12px;
            width: 100%; border-radius: 8px; font-weight: 700; cursor: pointer;
            transition: background 0.3s; margin-top: 10px;
        }
        .btn-crear:hover { background-color: #6f4a20; }

        .header-minimal {
            display: flex; justify-content: space-between; align-items: center;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 15px; margin-bottom: 25px;
        }
        .header-minimal h1 { font-family: 'Playfair Display', serif; font-size: 1.8rem; margin: 0; color: #333; }

        .contenedor-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 20px;
        }

        .card-consejo {
            background: white; padding: 20px; border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04); border: 1px solid #eee;
        }

        .card-consejo h3 { font-size: 0.8rem; color: var(--primary); text-transform: uppercase; margin-bottom: 15px; letter-spacing: 1px; }

        .acciones-card {
            display: flex; gap: 10px; margin-top: 15px; padding-top: 15px; border-top: 1px solid #f5f5f5;
        }

        .btn-actualizar {
            flex: 2; background: #fdf4ea; color: var(--primary); border: 1px solid var(--primary);
            padding: 8px; border-radius: 6px; font-weight: 600; cursor: pointer; font-size: 0.85rem;
        }
        .btn-actualizar:hover { background: var(--primary); color: white; }

        .btn-eliminar {
            flex: 1; background: #fff1f1; color: #dc3545; border: 1px solid #dc3545;
            padding: 8px; border-radius: 6px; cursor: pointer;
        }
        .btn-eliminar:hover { background: #dc3545; color: white; }

        .footer { background-color: var(--primary); color: #fff; padding: 2rem; text-align: center; margin-top: auto; }

        @media (max-width: 1000px) {
            .dashboard-wrapper { grid-template-columns: 1fr; }
            .panel-formulario { position: relative; top: 0; }
        }
    </style>
</head>
    <body>

        <nav class="navbar">
            <div class="logo">
                <img src="{{ asset('img/logo.png') }}" alt="Logotipo">
                <span>Fauna y Flora Local Qro</span>
            </div>
            <div class="links">
                <a href="/">Panel</a>
                <a href="/logout" style="color: #8C5E2A;">Cerrar sesión</a>
            </div>
        </nav>
        @if(session('success'))
        <script>
            document.addEventListener("DOMContentLoaded", () => {
                Swal.fire({ icon: 'success', title: 'Listo', text: '{{ session('success') }}', timer: 2500, showConfirmButton: false });
            });
        </script>
        @endif
        @if($errors->any())
        <script>
            document.addEventListener("DOMContentLoaded", () => {
                Swal.fire({ 
                    icon: 'error', 
                    title: 'Error en el formulario', 
                    text: 'Por favor, corrige los campos marcados en rojo.',
                    confirmButtonColor: '#8C5E2A'
                });
            });
        </script>
        @endif

        <div class="dashboard-wrapper">
            
            <aside class="panel-formulario">
                <h2><i class="fas fa-plus-circle"></i> Nuevo Consejo</h2>
                
                <form action="{{ route('admin.consejos.store') }}" method="POST">
                    @csrf
                    
                    <div class="form-group">
                        <label>Título del Consejo</label>
                        <input type="text" name="titulo" value="{{ old('titulo') }}"
                            class="@error('titulo') is-invalid @enderror" 
                            placeholder="Ej: Cuidado del agua" required minlength="3" maxlength="150"/>
                        @error('titulo') <div class="error-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label>Contenido</label>
                        <textarea name="consejo" class="@error('consejo') is-invalid @enderror" 
                                placeholder="Describe el consejo aquí..." required minlength="10" maxlength="500">{{ old('consejo') }}</textarea>
                        @error('consejo') <div class="error-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                        <div class="form-group">
                            <label>Fecha</label>
                            <input type="date" name="fecha" value="{{ old('fecha') }}" 
                                class="@error('fecha') is-invalid @enderror" required/>
                            @error('fecha') <div class="error-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group">
                            <label>Hora</label>
                            <input type="time" name="hora" value="{{ old('hora') }}" 
                                class="@error('hora') is-invalid @enderror" required/>
                            @error('hora') <div class="error-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Zona Aplicable</label>
                        <select name="zona" class="@error('zona') is-invalid @enderror" required>
                            <option value="" disabled {{ old('zona') ? '' : 'selected' }}>Selecciona una zona</option>
                            @foreach($zonas as $z)
                                <option value="{{ $z['ID'] ?? $z['id'] }}" {{ old('zona') == ($z['ID'] ?? $z['id']) ? 'selected' : '' }}>
                                    {{ $z['nombre_region'] }}
                                </option>
                            @endforeach
                        </select>
                        @error('zona') <div class="error-feedback">{{ $message }}</div> @enderror
                    </div>

                    <button type="submit" class="btn-crear">
                        <i class="fas fa-paper-plane"></i> Publicar Consejo
                    </button>
                </form>
            </aside>

            <section class="panel-lista">
                <div class="header-minimal">
                    <h1>Consejos Publicados</h1>
                    <div style="font-size: 0.85rem; color: #777;">
                        Total: {{ count($consejos) }} consejos
                    </div>
                </div>

                <div class="contenedor-grid">
                    @forelse($consejos as $c)
                        @php
                            $id = $c['ID'] ?? $c['id'] ?? 0;
                            $titulo = $c['titulo'] ?? '';
                            $texto = $c['consejo'] ?? '';
                            $fecha = $c['fecha']  ?? '';
                            $hora = $c['hora']   ?? '';
                            $zonaId = $c['zona']   ?? '';
                        @endphp

                        <div class="card-consejo">
                            <h3>Edición de Consejo</h3>
                            <form action="{{ route('admin.consejos.update', $id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="form-group">
                                    <label style="font-size: 0.75rem; font-weight: 700; color: #888; text-transform: uppercase;">Título</label>
                                    <input type="text" name="titulo" value="{{ $titulo }}" required />
                                </div>
                                <div class="form-group">
                                    <label style="font-size: 0.75rem; font-weight: 700; color: #888; text-transform: uppercase;">Contenido</label>
                                    <textarea name="consejo" required>{{ $texto }}</textarea>
                                </div>
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 5px;" class="form-group">
                                    <input type="date" name="fecha" value="{{ $fecha }}" required />
                                    <input type="time" name="hora" value="{{ $hora }}" required />
                                </div>
                                <div class="form-group">
                                    <label style="font-size: 0.75rem; font-weight: 700; color: #888; text-transform: uppercase;">Zona</label>
                                    <select name="zona" required>
                                        @foreach($zonas as $z)
                                            @php $zid = $z['ID'] ?? $z['id']; @endphp
                                            <option value="{{ $zid }}" {{ $zonaId == $zid ? 'selected' : '' }}>
                                                {{ $z['nombre_region'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="acciones-card">
                                    <button type="submit" class="btn-actualizar"><i class="fas fa-save"></i> Actualizar</button>
                                    <button type="button" class="btn-eliminar" onclick="confirmarEliminar({{ $id }})" title="Eliminar">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </form>

                            <form id="form-eliminar-{{ $id }}" action="{{ route('admin.consejos.destroy', $id) }}" method="POST" style="display:none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    @empty
                        <div style="grid-column: 1/-1; text-align: center; padding: 50px; color: #999;">
                            <i class="fas fa-info-circle fa-2x" style="display:block; margin-bottom:10px;"></i>
                            No hay consejos publicados aún.
                        </div>
                    @endforelse
                </div>
            </section>
        </div>

        <footer class="footer">
            <p>&copy; Flora y Fauna de Querétaro</p>
        </footer>

        <script>
            function confirmarEliminar(id) {
                Swal.fire({
                    title: '¿Eliminar consejo?',
                    text: "Esta acción no se puede deshacer.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('form-eliminar-' + id).submit();
                    }
                });
            }
        </script>

    </body>
</html>