<?php

namespace App\Inspections;

class InvalidKeywords
{
    public $invalidKeywords = [
        'yahoo customer support'
    ];

    public function detect($data)
    {
        foreach ($this->invalidKeywords as $value) {
            if (stripos($data, $value) !== false) {
                throw new \Exception('Detect spam');
            }
        }
    }
}
