<?php

namespace App;

class Spam
{
    public function detect($data)
    {
        $this->detectInvalidKeywords($data);

        return false;
    }

    private function detectInvalidKeywords($data)
    {
        $invalidKeywords = [
            'yahoo customer service'
        ];

        foreach ($invalidKeywords as $value) {
            if(stripos($data, $value) !== false) {
                throw new \Exception;
            }
        }
    }
}