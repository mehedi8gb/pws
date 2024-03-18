<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function configure()
    {
        return $this->afterCreating(function (User $user) {
            $user->profile()->create([
                'first_name' => $this->faker->firstName,
                'last_name' => $this->faker->lastName,
                'date_of_birth' => $this->faker->date(),
                'gender' => $this->faker->randomElement(['male', 'female']),
                'bio' => $this->faker->paragraph,
                'avatar' => $this->faker->imageUrl(), // Generate a fake CDN link for the avatar
                'location' => $this->faker->address,
                'website' => $this->faker->url,
                'social_media_links' => json_encode([
                    'twitter' => $this->faker->url,
                    'facebook' => $this->faker->url,
                    'instagram' => $this->faker->url,
                ]),
            ]);

        $numFiles = rand(1, 100);

        // Create multiple user files for each user
        $files = [];
        for ($i = 0; $i < $numFiles; $i++) {
            $files[] = ['file_path' => $this->faker->imageUrl()];
        }

        $user->userFiles()->createMany($files);
        });
    }
}
