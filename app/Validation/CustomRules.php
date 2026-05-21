<?php

namespace App\Validation;

class CustomRules
{
    public function future_date(string $value): bool
    {
        return strtotime($value)>=time();
    }

    public function greater_than_start(string $value,string $field,array $data): bool
    {
        return strtotime($value)>=strtotime($data[$field]);
    }
}