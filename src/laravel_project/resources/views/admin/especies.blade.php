<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Administración de Especies</title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    :root {
        --primary: #8C5E2A;
        --bg-body: #f8f7f0;
        --border-color: #e5e7eb;
    }

    * { box-sizing: border-box; }

    html { width: 100%; overflow-x: hidden; }

    body {
        margin: 0;
        font-family: 'Inter', sans-serif;
        background: var(--bg-body);
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        padding-top: 60px;
    }

    .navbar {
        position: fixed; top: 0; width: 100%; z-index: 1000;
        display: flex; justify-content: space-between; align-items: center;
        padding: 0 2rem; background: #fff;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1); height: 60px;
    }
    .logo {
        display: flex; align-items: center;
        font-weight: bold; font-size: 1.3rem;
        font-family: 'Playfair Display', serif; color: var(--primary);
    }
    .logo img { height: 40px; margin-right: 12px; }
    .links a {
        text-decoration: none; color: #333; font-weight: 500;
        margin-left: 20px; font-size: .9rem; transition: color .3s;
    }
    .links a:hover { color: var(--primary); }

    .dashboard-wrapper {
        display: grid;
        grid-template-columns: 360px 1fr;
        gap: 30px;
        max-width: 1400px;
        margin: 0 auto;
        padding: 40px 20px;
        align-items: start;
    }

    .panel-formulario {
        background: #fff; padding: 25px; border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05); border: 1px solid #eee;
        position: sticky; top: 80px;
    }
    .panel-formulario h2 {
        margin-top: 0; font-size: 1.6rem; color: var(--primary);
        font-family: 'Playfair Display', serif; margin-bottom: 20px;
        border-bottom: 2px solid #f0f0f0; padding-bottom: 10px;
    }
    .form-group { margin-bottom: 14px; }
    .form-group label {
        display: block; margin-bottom: 5px;
        font-weight: 600; font-size: .82rem; color: #444;
    }
    input[type="text"], select {
        width: 100%; padding: 10px; border: 1px solid #d1d5db;
        border-radius: 7px; font-family: 'Inter', sans-serif;
        font-size: .9rem; background: #fafafa;
    }
    input:focus, select:focus { outline: none; border-color: var(--primary); background: #fff; }

    .btn-submit {
        background: var(--primary); color: white; border: none;
        padding: 12px; width: 100%; border-radius: 7px;
        font-weight: 700; cursor: pointer; transition: background .3s;
        font-size: .95rem; margin-top: 8px;
    }
    .btn-submit:hover { background: #6f4a20; }

    .panel-feed {
        background: white; padding: 25px; border-radius: 10px; border: 1px solid #eee;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    .feed-header {
        display: flex; justify-content: space-between; align-items: center;
        border-bottom: 1px solid #f0f0f0; padding-bottom: 15px; margin-bottom: 20px;
        flex-wrap: wrap; gap: 10px;
    }
    .feed-header h2 {
        margin: 0; font-size: 1.5rem;
        font-family: 'Playfair Display', serif; color: #333;
    }
    .feed-header select { width: auto; padding: 8px 12px; }

    .table-container { overflow-x: auto; }

    table { width: 100%; border-collapse: collapse; font-size: .88rem; }

    th {
        text-align: left; padding: 13px 15px;
        color: var(--primary); border-bottom: 2px solid #eee;
        background: #f9f8f3; white-space: nowrap;
    }
    td { padding: 13px 15px; border-bottom: 1px solid #eee; vertical-align: middle; }
    tr:hover td { background: #fdfaf6; }

    .badge {
        padding: 4px 10px; border-radius: 20px;
        font-size: .72rem; font-weight: 700; white-space: nowrap;
    }
    .badge-1 { background: #e6f4ea; color: #2e7d32; border: 1px solid #a5d6a7; } /* Preocupación menor */
    .badge-2 { background: #fff8e1; color: #f57f17; border: 1px solid #ffe082; } /* Casi amenazado */
    .badge-3 { background: #fff3e0; color: #e65100; border: 1px solid #ffcc80; } /* Vulnerable */
    .badge-4 { background: #fce4ec; color: #c62828; border: 1px solid #ef9a9a; } /* En peligro */
    .badge-5 { background: #f3e5f5; color: #6a1b9a; border: 1px solid #ce93d8; } /* En peligro crítico */

    .tipo-flora  { background: #e8f5e9; color: #2e7d32; padding: 3px 8px; border-radius: 10px; font-size: .75rem; font-weight: 600; }
    .tipo-fauna  { background: #e3f2fd; color: #1565c0; padding: 3px 8px; border-radius: 10px; font-size: .75rem; font-weight: 600; }

    .btn-action { background: none; border: none; cursor: pointer; font-size: .9rem; padding: 5px 7px; border-radius: 5px; transition: background .2s; }
    .btn-edit   { color: #0d6efd; }
    .btn-edit:hover   { background: #e7f0ff; }
    .btn-delete { color: #dc3545; }
    .btn-delete:hover { background: #fff1f1; }

    .modal-overlay {
        display: none; position: fixed; inset: 0;
        background: rgba(0,0,0,0.45); z-index: 2000;
        align-items: center; justify-content: center;
    }
    .modal-overlay.active { display: flex; }
    .modal-box {
        background: #fff; border-radius: 12px; padding: 30px;
        width: 100%; max-width: 480px; box-shadow: 0 8px 30px rgba(0,0,0,0.15);
        max-height: 90vh; overflow-y: auto;
    }
    .modal-box h3 {
        margin-top: 0; font-family: 'Playfair Display', serif;
        color: var(--primary); font-size: 1.4rem; margin-bottom: 20px;
    }
    .modal-actions { display: flex; gap: 10px; margin-top: 15px; }
    .btn-guardar {
        flex: 2; background: var(--primary); color: white; border: none;
        padding: 11px; border-radius: 7px; font-weight: 700; cursor: pointer;
    }
    .btn-guardar:hover { background: #6f4a20; }
    .btn-cancelar {
        flex: 1; background: #f1f1f1; color: #555; border: none;
        padding: 11px; border-radius: 7px; cursor: pointer;
    }

    .estado-vacio { text-align: center; padding: 50px 20px; color: #aaa; }

    .footer {
        background: var(--primary); color: #fff;
        padding: 1.5rem; text-align: center; margin-top: auto;
    }

    @media (max-width: 1000px) {
        .dashboard-wrapper { grid-template-columns: 1fr; }
        .panel-formulario { position: relative; top: 0; }
    }
</style>
</head>

<body>
<nav class="navbar">
    <div class="logo">
        <img src="{{ asset('img/logo.png') }}" alt="Logo">
        <span>Panel de Administración</span>
    </div>
    <div class="links">
        <a href="/">Panel</a>
        <a href="/logout" style="color:#8C5E2A;">Cerrar sesión</a>
    </div>
</nav>

@if(session('success'))
<script>
    document.addEventListener("DOMContentLoaded", () => {
        Swal.fire({ icon:'success', title:'Listo', text:'{{ session('success') }}', timer:2000, showConfirmButton:false });
    });
</script>
@endif
@if(session('error'))
<script>
    document.addEventListener("DOMContentLoaded", () => {
        Swal.fire({ icon:'error', title:'Error', text:'{{ session('error') }}' });
    });
</script>
@endif

<div class="dashboard-wrapper">
    <aside class="panel-formulario">
        <h2><i class="fas fa-plus-circle"></i> Nueva Especie</h2>

        <form action="{{ route('admin.especies.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Nombre Común</label>
                <input type="text" name="Nombre_comun" placeholder="Ej: Jaguar" required>
            </div>

            <div class="form-group">
                <label>Nombre Científico</label>
                <input type="text" name="nombre_cientifico" placeholder="Ej: Panthera onca" required>
            </div>

            <div class="form-group">
                <label>Tipo</label>
                <select name="tipo" required>
                    <option value="" disabled selected>Seleccionar...</option>
                    <option value="1">Flora</option>
                    <option value="2">Fauna</option>
                </select>
            </div>

            <div class="form-group">
                <label>Familia</label>
                <select name="id_familia" required>
                    <option value="" disabled selected>Seleccionar familia...</option>
                    @foreach($familias as $f)
                        <option value="{{ $f['ID'] ?? $f['id'] }}">{{ $f['nombre_familia'] }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Estado de Conservación</label>
                <select name="id_estado_conservacion" required>
                    <option value="" disabled selected>Seleccionar estado...</option>
                    @foreach($estados as $e)
                        <option value="{{ $e['ID'] ?? $e['id'] }}">{{ $e['categoria'] }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Zona</label>
                <select name="id_zonas" required>
                    <option value="" disabled selected>Seleccionar zona...</option>
                    @foreach($zonas as $z)
                        <option value="{{ $z['ID'] ?? $z['id'] }}">{{ $z['nombre_region'] }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn-submit">
                <i class="fas fa-save"></i> Guardar Especie
            </button>
        </form>
    </aside>

    <section class="panel-feed">

        <div class="feed-header">
            <h2></i>Inventario Actual</h2>
            <select onchange="location='?zona='+this.value">
                <option value="">Todas las zonas</option>
                @foreach($zonas as $z)
                    @php $zid = $z['ID'] ?? $z['id']; @endphp
                    <option value="{{ $zid }}" {{ ($idZona == $zid) ? 'selected' : '' }}>
                        {{ $z['nombre_region'] }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre Común</th>
                        <th>Nombre Científico</th>
                        <th>Tipo</th>
                        <th>Familia</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($especies as $e)
                        @php
                            $eid = $e['ID'] ?? $e['id'] ?? 0;
                            $comun = $e['Nombre_comun'] ?? $e['nombre_comun'] ?? '—';
                            $cient = $e['nombre_cientifico'] ?? '—';
                            $tipo = $e['tipo'] ?? 0;
                            $fam = $e['familia'] ?? '—';
                            $estado = $e['id_estado_conservacion'] ?? 0;
                            $zona = $e['id_zonas'] ?? 0;

                            $estadoLabels = [
                                1 => 'Preocupación menor',
                                2 => 'Casi amenazado',
                                3 => 'Vulnerable',
                                4 => 'En peligro',
                                5 => 'En peligro crítico',
                            ];
                        @endphp
                        <tr>
                            <td style="color:#aaa;font-size:.8rem;">{{ $eid }}</td>
                            <td><strong>{{ $comun }}</strong></td>
                            <td><i style="color:#777;">{{ $cient }}</i></td>
                            <td>
                                @if($tipo == 1)
                                    <span class="tipo-flora"><i class="fas fa-seedling"></i> Flora</span>
                                @else
                                    <span class="tipo-fauna"><i class="fas fa-paw"></i> Fauna</span>
                                @endif
                            </td>
                            <td>{{ $fam }}</td>
                            <td>
                                <span class="badge badge-{{ $estado }}">
                                    {{ $estadoLabels[$estado] ?? '—' }}
                                </span>
                            </td>
                            <td style="white-space:nowrap;">
                                <button class="btn-action btn-edit"
                                    onclick="abrirEditar(
                                        {{ $eid }},
                                        '{{ addslashes($comun) }}',
                                        '{{ addslashes($cient) }}',
                                        {{ $tipo }},
                                        {{ $e['id_familia'] ?? 0 }},
                                        {{ $estado }},
                                        {{ $zona }}
                                    )" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <button class="btn-action btn-delete"
                                    onclick="confirmarEliminar({{ $eid }})" title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>

                                <form id="form-delete-{{ $eid }}"
                                      action="{{ route('admin.especies.destroy', $eid) }}"
                                      method="POST" style="display:none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="estado-vacio">
                                    <i class="fas fa-leaf fa-3x" style="display:block;margin-bottom:12px;"></i>
                                    No hay especies registradas.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

</div>

<div class="modal-overlay" id="modalEditar">
    <div class="modal-box">
        <h3><i class="fas fa-edit"></i> Editar Especie</h3>

        <form id="formEditar" method="POST">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label>Nombre Común</label>
                <input type="text" name="Nombre_comun" id="edit_nombre_comun" required>
            </div>
            <div class="form-group">
                <label>Nombre Científico</label>
                <input type="text" name="nombre_cientifico" id="edit_nombre_cientifico" required>
            </div>
            <div class="form-group">
                <label>Tipo</label>
                <select name="tipo" id="edit_tipo" required>
                    <option value="1">Flora</option>
                    <option value="2">Fauna</option>
                </select>
            </div>
            <div class="form-group">
                <label>Familia</label>
                <select name="id_familia" id="edit_familia" required>
                    @foreach($familias as $f)
                        <option value="{{ $f['ID'] ?? $f['id'] }}">{{ $f['nombre_familia'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Estado de Conservación</label>
                <select name="id_estado_conservacion" id="edit_estado" required>
                    @foreach($estados as $e)
                        <option value="{{ $e['ID'] ?? $e['id'] }}">{{ $e['categoria'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Zona</label>
                <select name="id_zonas" id="edit_zona" required>
                    @foreach($zonas as $z)
                        <option value="{{ $z['ID'] ?? $z['id'] }}">{{ $z['nombre_region'] }}</option>
                    @endforeach
                </select>
            </div>

            <div class="modal-actions">
                <button type="submit" class="btn-guardar">
                    <i class="fas fa-save"></i> Guardar cambios
                </button>
                <button type="button" class="btn-cancelar" onclick="cerrarModal()">
                    Cancelar
                </button>
            </div>
        </form>
    </div>
</div>

        <footer class="footer">
            <p>&copy; Flora y Fauna de Querétaro</p>
        </footer>

        <script>
            function abrirEditar(id, nombre, cientifico, tipo, familia, estado, zona) {
                document.getElementById('edit_nombre_comun').value = nombre;
                document.getElementById('edit_nombre_cientifico').value = cientifico;
                document.getElementById('edit_tipo').value = tipo;
                document.getElementById('edit_familia').value = familia;
                document.getElementById('edit_estado').value = estado;
                document.getElementById('edit_zona').value = zona;
                document.getElementById('formEditar').action = '/admin/especies/' + id;
                document.getElementById('modalEditar').classList.add('active');
            }

            function cerrarModal() {
                document.getElementById('modalEditar').classList.remove('active');
            }

            document.getElementById('modalEditar').addEventListener('click', function(e) {
                if (e.target === this) cerrarModal();
            });

            function confirmarEliminar(id) {
                Swal.fire({
                    title: '¿Eliminar especie?',
                    text: 'Se borrará de forma permanente.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '<i class="fas fa-trash"></i> Eliminar',
                    cancelButtonText: 'Cancelar'
                }).then(result => {
                    if (result.isConfirmed) {
                        document.getElementById('form-delete-' + id).submit();
                    }
                });
            }
        </script>

    </body>
</html>