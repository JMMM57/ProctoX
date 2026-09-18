<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Salon;

class SalonTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $consulta;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->consulta = User::factory()->create(['role' => 'consulta']);
    }

    // 1. Observabilidad
    public function test_health_endpoint_returns_200_or_json(): void
    {
        $response = $this->get('/health');
        $response->assertStatus(200);
        $response->assertJsonFragment(['status' => 'OK']);
    }

    // 2. Autorización / CRUD (Listar)
    public function test_consulta_can_view_salones_index(): void
    {
        Salon::create([
            'codigo' => 'A-01',
            'edificio' => 'A',
            'capacidad' => 30,
            'estado' => 'activo'
        ]);

        $response = $this->actingAs($this->consulta)->get('/salones');
        $response->assertStatus(200);
        $response->assertSee('A-01');
    }

    // 3. Autorización / Validación (Consulta no puede crear)
    public function test_consulta_cannot_create_salon(): void
    {
        $response = $this->actingAs($this->consulta)->post('/salones', [
            'codigo' => 'B-01',
            'edificio' => 'B',
            'capacidad' => 40,
            'estado' => 'activo'
        ]);

        $response->assertForbidden();
    }

    // 4. CRUD (Crear por Admin)
    public function test_admin_can_create_salon(): void
    {
        $response = $this->actingAs($this->admin)->post('/salones', [
            'codigo' => 'C-01',
            'edificio' => 'C',
            'capacidad' => 50,
            'nombre' => 'Auditorio',
            'estado' => 'activo'
        ]);

        $response->assertRedirect('/salones');
        $this->assertDatabaseHas('salones', ['codigo' => 'C-01']);
    }

    // 5. Validación (Código único)
    public function test_codigo_must_be_unique(): void
    {
        Salon::create([
            'codigo' => 'D-01',
            'edificio' => 'D',
            'capacidad' => 20,
            'estado' => 'activo'
        ]);

        $response = $this->actingAs($this->admin)->post('/salones', [
            'codigo' => 'D-01', // Repetido
            'edificio' => 'E',
            'capacidad' => 30,
            'estado' => 'activo'
        ]);

        $response->assertSessionHasErrors('codigo');
    }

    // 6. Validación (Capacidad positiva)
    public function test_capacidad_must_be_positive(): void
    {
        $response = $this->actingAs($this->admin)->post('/salones', [
            'codigo' => 'F-01',
            'edificio' => 'F',
            'capacidad' => -5, // Inválido
            'estado' => 'activo'
        ]);

        $response->assertSessionHasErrors('capacidad');
    }

    // 7. Validación (Campos obligatorios)
    public function test_required_fields_are_validated(): void
    {
        $response = $this->actingAs($this->admin)->post('/salones', []);

        $response->assertSessionHasErrors(['codigo', 'edificio', 'capacidad', 'estado']);
    }

    // 8. CRUD & SoftDeletes (Baja Lógica por Admin)
    public function test_admin_can_soft_delete_salon(): void
    {
        $salon = Salon::create([
            'codigo' => 'G-01',
            'edificio' => 'G',
            'capacidad' => 15,
            'estado' => 'activo'
        ]);

        $response = $this->actingAs($this->admin)->delete("/salones/{$salon->id}");

        $response->assertRedirect('/salones');
        $this->assertSoftDeleted('salones', ['id' => $salon->id]);
    }
}
