<?php


namespace App\Domains\Validators;


use Photon\Foundation\Job;
use Laravel\Lumen\Routing\ProvidesConvenienceMethods;

abstract class Validator extends Job
{
    use ProvidesConvenienceMethods;
}
