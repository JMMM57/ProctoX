<?php

namespace App\Http\Controllers;

use App\Models\Salon;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SalonController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $salones = Salon::all();
        return view('classrooms.index', compact('salones'));
    }

    public function create()
    {
        $this->authorize('create', Salon::class);
        return view('classrooms.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Salon::class);

        $validated = $request->validate([
            'codigo' => 'required|string|unique:salones,codigo',
            'edificio' => 'required|string|max:255',
            'capacidad' => 'required|integer|min:1',
            'nombre' => 'nullable|string|max:255',
            'tipo' => 'nullable|string|max:255',
            'estado' => 'required|string|max:50',
        ]);

        Salon::create($validated);

        return redirect()->route('salones.index')->with('success', 'Salón creado exitosamente.');
    }

    public function edit(Salon $salon)
    {
        $this->authorize('update', $salon);
        return view('classrooms.edit', compact('salon'));
    }

    public function update(Request $request, Salon $salon)
    {
        $this->authorize('update', $salon);

        $validated = $request->validate([
            'codigo' => 'required|string|unique:salones,codigo,' . $salon->id,
            'edificio' => 'required|string|max:255',
            'capacidad' => 'required|integer|min:1',
            'nombre' => 'nullable|string|max:255',
            'tipo' => 'nullable|string|max:255',
            'estado' => 'required|string|max:50',
        ]);

        $salon->update($validated);

        return redirect()->route('salones.index')->with('success', 'Salón actualizado exitosamente.');
    }

    public function destroy(Salon $salon)
    {
        $this->authorize('delete', $salon);
        
        $salon->delete();

        return redirect()->route('salones.index')->with('success', 'Salón dado de baja exitosamente.');
    }
}
