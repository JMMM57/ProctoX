<x-app-layout>
    <section class="hero">
        <h1>Gestión de Aulas</h1>
        <p>Catálogo completo de salones</p>

        @if(session('success'))
            <div class="badge success" style="margin-bottom: 1rem;">
                {{ session('success') }}
            </div>
        @endif

        @can('create', App\Models\Salon::class)
            <a href="{{ route('salones.create') }}" class="btn-primary" style="text-decoration: none;">Nuevo Salón</a>
        @endcan
    </section>

    <section class="cards-grid">
        @forelse($salones as $salon)
            <div class="card">
                <h3>{{ $salon->codigo }}</h3>
                <p><strong>Edificio:</strong> {{ $salon->edificio }}</p>
                <p><strong>Capacidad:</strong> {{ $salon->capacidad }} personas</p>
                <p><strong>Tipo:</strong> {{ $salon->tipo ?? 'N/A' }}</p>
                <p><strong>Estado:</strong> {{ $salon->estado }}</p>
                
                @can('update', $salon)
                    <div style="margin-top: 1rem; display: flex; gap: 0.5rem;">
                        <a href="{{ route('salones.edit', $salon) }}" class="btn-primary" style="text-decoration: none; padding: 0.5rem 1rem; font-size: 0.85rem;">Editar</a>
                        
                        <form action="{{ route('salones.destroy', $salon) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-primary" style="background-color: #ef4444; padding: 0.5rem 1rem; font-size: 0.85rem;" onclick="return confirm('¿Dar de baja este salón?');">Eliminar</button>
                        </form>
                    </div>
                @endcan
            </div>
        @empty
            <p>No hay salones registrados.</p>
        @endforelse
    </section>
</x-app-layout>
