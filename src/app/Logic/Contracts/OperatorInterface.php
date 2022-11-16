<?php

namespace App\Logic\Contracts;

interface OperatorInterface
{
    /**
     * @param array<int, float> $operands
     */
    public function calculate(array $operands): float;
}
