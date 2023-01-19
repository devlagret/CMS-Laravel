<?php

namespace Database\Factories;

use App\Models\Branches;
use App\Models\Users;
use Illuminate\Database\Eloquent\Factories\Factory;

class BranchesFactory extends Factory
{
    protected $model = Branches::class;

    public function definition(): array
    {
        $uid = Users::all()->pluck('uid')->toArray();
    	return [
            'branch_id' => $this->faker->uuid(),
    	    'branch_name' => $this->faker->company(),
            'leader_name' => $this->faker->name(),
            'contact' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'uid' => $this->faker->randomElement($uid)
            // 'login_username' => $this->faker->word(),
            // 'login_password' => $this->faker->word(),
    	];
    }
}
