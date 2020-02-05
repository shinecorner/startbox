<?php

namespace Tests;

use Faker\Factory;

use App\Models\User;
use Laravel\Airlock\Airlock;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $faker;
}
