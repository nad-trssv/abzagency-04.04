<?php

namespace Database\Factories;

use App\Models\Position;
use App\Services\ImageOptimizationService;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $randomPhotoUrl = 'https://randomuser.me/api/portraits/women/' . fake()->randomNumber(1, 99) . '.jpg';
        $photoContent = file_get_contents($randomPhotoUrl);
    
        $tempFileName = tempnam(sys_get_temp_dir(), 'user_photo');
        file_put_contents($tempFileName, $photoContent);
    
        $originalPath = 'uploads/originals/' . Str::random(10) . '.jpg';
        Storage::disk('public')->put($originalPath, file_get_contents($tempFileName));
    
        $imageOptimizer = app(ImageOptimizationService::class);
        $fullPath = storage_path('app/public/' . $originalPath);
        $optimizedPath = $imageOptimizer->optimizeImage($originalPath, $fullPath);
        unlink($tempFileName);

        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => '+380' . fake()->randomNumber(9, true),
            'position_id' => Position::count() > 0 ? Position::inRandomOrder()->first()->id : null,
            'photo' => $optimizedPath,
        ];
    }
}
