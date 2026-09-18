<x-app-layout>
    <section class="card" style="max-width: 600px; margin: 0 auto;">
        <h2 style="color: var(--accent-color); margin-bottom: 1.5rem;">Nuevo Salón</h2>

        @if($errors->any())
            <div style="background-color: rgba(239, 68, 68, 0.2); color: #ef4444; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('salones.store') }}" method="POST" style="display: flex; flex-direction: column; gap: 1rem;">
            @csrf
            
            <div>
                <label for="codigo">Código/Clave*</label><br>
                <input type="text" id="codigo" name="codigo" value="{{ old('codigo') }}" required style="width: 100%; padding: 0.5rem; border-radius: 4px; border: 1px solid var(--border-color); background: var(--bg-color); color: var(--text-color);">
            </div>

            <div>
                <label for="nombre">Nombre</label><br>
                <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" style="width: 100%; padding: 0.5rem; border-radius: 4px; border: 1px solid var(--border-color); background: var(--bg-color); color: var(--text-color);">
            </div>

            <div>
                <label for="edificio">Edificio*</label><br>
                <input type="text" id="edificio" name="edificio" value="{{ old('edificio') }}" required style="width: 100%; padding: 0.5rem; border-radius: 4px; border: 1px solid var(--border-color); background: var(--bg-color); color: var(--text-color);">
            </div>

            <div>
                <label for="capacidad">Capacidad* (Num positivo)</label><br>
                <input type="number" id="capacidad" name="capacidad" value="{{ old('capacidad') }}" required min="1" style="width: 100%; padding: 0.5rem; border-radius: 4px; border: 1px solid var(--border-color); background: var(--bg-color); color: var(--text-color);">
            </div>

            <div>
                <label for="tipo">Tipo</label><br>
                <input type="text" id="tipo" name="tipo" value="{{ old('tipo') }}" style="width: 100%; padding: 0.5rem; border-radius: 4px; border: 1px solid var(--border-color); background: var(--bg-color); color: var(--text-color);">
            </div>

            <div>
                <label for="estado">Estado*</label><br>
                <select id="estado" name="estado" required style="width: 100%; padding: 0.5rem; border-radius: 4px; border: 1px solid var(--border-color); background: var(--bg-color); color: var(--text-color);">
                    <option value="activo" {{ old('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                    <option value="mantenimiento" {{ old('estado') == 'mantenimiento' ? 'selected' : '' }}>Mantenimiento</option>
                </select>
            </div>

            <div style="margin-top: 1rem;">
                <button type="submit" class="btn-primary">Guardar</button>
                <a href="{{ route('salones.index') }}" style="color: var(--text-muted); margin-left: 1rem; text-decoration: none;">Cancelar</a>
            </div>
        </form>
    </section>
</x-app-layout>
