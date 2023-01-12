<?php

namespace Database\Factories;

use App\Models\Branches;
use Illuminate\Database\Eloquent\Factories\Factory;

class BranchesFactory extends Factory
{
    protected $model = Branches::class;

    public function definition(): array
    {
    	return [
    	    'branch_name' => $this->faker->company(),
            'leader_name' => $this->faker->name(),
            'contact' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'login_username' => $this->faker->word(),
            'login_password' => $this->faker->word(),
    	];
    }
}
