<?php

namespace Database\Factories;

use App\Models\Campaign;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition(): array
    {
        /** @var Campaign $campaign */
        $campaign = Campaign::factory()->create();

        return [
            'campaign_id' => $campaign->value('id'),
            'user_name' => $this->faker->lastName(),
            'user_email' => $this->faker->freeEmail(),
            'user_phone' => $this->faker->e164PhoneNumber(),
            'message' => $this->faker->text(100),
            'amount' => str_pad(random_int(1000, 9999999), 7, 0, STR_PAD_LEFT),
            'status' => $this->faker->randomElement(Transaction::STATUSES),
        ];
    }
}
