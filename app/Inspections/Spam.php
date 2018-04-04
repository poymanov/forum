<?php

namespace App\Inspections;

class Spam
{
    protected $inspections = [
        InvalidKeywords::class,
        KeyHeldDown::class
    ];

    public function detect($data)
    {
        foreach ($this->inspections as $class) {
            app($class)->detect($data);
        }

        return false;
    }
}
