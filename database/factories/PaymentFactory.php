<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition(): array
    {
        return [
            'payment_id' => $this->faker->uuid(),
            'user_id' => User::factory(),
            'product_id' => Product::factory(),
            'product_name' => $this->faker->words(3, true),
            'quantity' => $this->faker->numberBetween(1, 5),
            'amount' => $this->faker->randomFloat(2, 10, 500),
            'currency' => 'EUR',
            'payer_name' => $this->faker->name(),
            'payer_email' => $this->faker->safeEmail(),
            'payment_status' => $this->faker->randomElement(['completed', 'pending', 'failed']),
            'payment_method' => $this->faker->randomElement(['paypal', 'credit_card', 'bank_transfer']),
        ];
    }
}
