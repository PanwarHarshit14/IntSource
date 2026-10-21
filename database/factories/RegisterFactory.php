<?php

namespace Database\Factories;

use App\Models\Register;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Register>
 */
class RegisterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $courses = [
            'MERN Stack Web Development',
            'Python & Django Full Stack',
            'Cloud Computing & DevOps',
            'AI, Machine Learning & Data Science',
            'Mobile App Development (Flutter / React Native)',
            'UI/UX Design & Frontend Engineering',
            'Cyber Security & Ethical Hacking',
        ];

        return [
            'course' => fake()->randomElement($courses),
            'student_name' => fake()->name(),
            'father_name' => fake()->name('male'),
            'gender' => fake()->randomElement(['Male', 'Female', 'Other']),
            'dob' => fake()->dateTimeBetween('-28 years', '-17 years')->format('Y-m-d'),
            'mobile' => '+91 '.fake()->numerify('##### #####'),
            'email' => fake()->safeEmail(),
        ];
    }
}
