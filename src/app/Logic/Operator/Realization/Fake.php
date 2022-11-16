<?php

namespace App\Logic\Operator\Realization;

use App\Logic\Contracts\OperatorInterface;
use Exception;

final class Fake implements OperatorInterface
{
    /**
     * @param array<int, float> $operands
     * @throws Exception
     */
    public function calculate(array $operands): float
    {
        throw new Exception;
    }
}
