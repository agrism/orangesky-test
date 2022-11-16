<?php

namespace App\Logic\Operator\Realization;

use App\Logic\Contracts\OperatorInterface;

final class Add implements OperatorInterface
{
    /**
     * @param array<int, float> $operands
     */
    public function calculate(array $operands): float
    {
        return array_sum($operands);
    }
}
