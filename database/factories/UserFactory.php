<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;
use Spatie\Permission\Models\Role;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected static ?string $password = null;

    /**
     * Define el estado por defecto del modelo.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => bcrypt('12345678'),
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'remember_token' => Str::random(10),
            'profile_photo_path' => null,
            'current_team_id' => null,
        ];
    }

    /**
     * Indicar que el usuario no ha verificado su email.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Indicar que el usuario tiene un equipo personal.
     */
    public function withPersonalTeam(?callable $callback = null): static
    {
        if (!Features::hasTeamFeatures()) {
            return $this->state([]);
        }

        return $this->has(
            Team::factory()
                ->state(fn(array $attributes, User $user) => [
                    'name' => $user->name . '\'s Team',
                    'user_id' => $user->id,
                    'personal_team' => true,
                ])
                ->when(is_callable($callback), $callback),
            'ownedTeams'
        );
    }

    /**
     * Configuración adicional después de crear el usuario.
     */
    public function configure(): static
    {
        return $this->afterCreating(function (User $user) {
            // 🔹 Asegurar que el rol "Customer" existe y asignarlo
            $role = Role::firstOrCreate(['name' => 'Customer']);
            if (!$user->hasRole($role)) {
                $user->assignRole($role);
            }

            // 🔹 Asignar dirección al 50% de los usuarios
            if (rand(0, 1)) {
                Address::create([
                    'user_id' => $user->id,
                    'name' => fake()->randomElement(['Casa', 'Trabajo', 'Oficina', 'Departamento']),
                    'street' => fake()->streetAddress(),
                    'city' => fake()->city(),
                    'postal_code' => fake()->postcode(),
                    'country' => 'España',
                    'is_default' => true,
                ]);
            }
        });
    }
}
