<?php

namespace App\Logic\Operator\Realization;

use App\Logic\Contracts\OperatorInterface;

final class Sub implements OperatorInterface
{
    /**
     * @param array<int, float> $operands
     */
    public function calculate(array $operands): float
    {
        foreach ($operands as $operand) {
            if (!isset($return)) {
                $return = $operand;
                continue;
            }
            $return -= $operand;
        }

        return $return ?? 0.00;
    }
}
