<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Position;
use App\Services\TinifyImageOptimization;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
        $imageOptimization = new TinifyImageOptimization();
        $photo = file_get_contents('https://static.vecteezy.com/system/resources/thumbnails/009/292/244/small/default-avatar-icon-of-social-media-user-vector.jpg');
        $photoName = 'default_profile_picture.jpg';
        $imageOptimization->profilePictureOptimizationAction($photo, public_path('images/') . $photoName);
        $photoPath = 'images/' . $photoName;
        $faker = \Faker\Factory::create('uk_UA');
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => $faker->phoneNumber(),
            'photo' => $photoPath,
            'position_id' => Position::inRandomOrder()->first()->id,
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
}