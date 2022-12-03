<?php

namespace Sfolador\Locked\Tests\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Sfolador\Locked\Tests\TestClasses\TestModel;

class TestModelFactory extends Factory
{
    protected $model = TestModel::class;

    public function definition(): array
    {
        return [
            'email' => $this->faker->email,
        ];
    }

    public function locked(): self
    {
        return $this->state(function (array $attributes) {
            return [
                app('locked')->getLockedColumnName() => now(),
            ];
        });
    }

    public function unlocked(): self
    {
        return $this->state(function (array $attributes) {
            return [
                app('locked')->getLockedColumnName() => null,
            ];
        });
    }
}
