<?php

namespace App\Inspections;

class KeyHeldDown
{
    public function detect($data)
    {
        if (preg_match('/(.)\\1{4,}/', $data)) {
            throw new \Exception('Detect spam');
        }
    }
}
