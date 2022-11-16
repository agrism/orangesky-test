<?php

namespace App\Logic\Operator\Realization;

use App\Exceptions\DivisionByZeroException;
use App\Logic\Contracts\OperatorInterface;
use Exception;

final class Div implements OperatorInterface
{
    /**
     * @param array<int, float> $operands
     * @throws Exception
     */
    public function calculate(array $operands): float
    {
        foreach ($operands as $operand) {
            if (!isset($return)) {
                $return = $operand;
                continue;
            }

            if ($operand == 0.00) {
                throw new DivisionByZeroException;
            }
            $return /= $operand;
        }

        return $return ?? 0.00;
    }
}
