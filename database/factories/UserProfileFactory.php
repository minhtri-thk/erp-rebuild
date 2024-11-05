<?php

namespace Database\Factories;

use App\Models\UserProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserProfileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = UserProfile::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'employee_code' => $this->faker->unique()->numerify('thk-###'),
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'phone_number' => $this->generatePhoneNumber(),
            'date_of_birth' => $this->faker->date('Y-m-d', '2000-01-01'),
            'gender' => $this->faker->numberBetween(0, 1),
            'avatar_url' => $this->faker->imageUrl(200, 200),
            'language' => $this->faker->numberBetween(0, 1),
            'address' => $this->faker->address,
        ];
    }

    /**
     * Generate a random phone number starting with '09'
     *
     * @return string
     */
    private function generatePhoneNumber()
    {
        // Generate a random number between 0 and 1 to decide on length
        $length = rand(10, 11); // Randomly choose between 10 or 11 digits

        // Generate the rest of the phone number after '09'
        $number = '';
        for ($i = 0; $i < ($length - 2); $i++) {
            $number .= rand(0, 9); // Append random digit
        }

        return '09' . $number; // Concatenate '09' with the rest of the number
    }
}
