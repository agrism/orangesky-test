<?php

namespace App\Logic\Operator;

use App\Exceptions\OperatorNotImplementedException;
use App\Logic\Contracts\OperatorInterface;
use App\Logic\Contracts\OperatorResolverInterface;
use App\Logic\Operator\Realization\Add;
use App\Logic\Operator\Realization\Div;
use App\Logic\Operator\Realization\Mul;
use App\Logic\Operator\Realization\Sub;

final class OperatorResolver implements OperatorResolverInterface
{
    /**
     * @throws OperatorNotImplementedException
     */
    public function resolve(string $operator): OperatorInterface
    {
        return match ($operator) {
            '+' => new Add,
            '-' => new Sub,
            '*' => new Mul,
            '/' => new Div,
            default => throw new OperatorNotImplementedException,
        };
    }
}
