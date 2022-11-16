<?php

namespace App\Logic;

use App\Exceptions\OperatorNotSetException;
use App\Logic\Contracts\CalculatorInterface;
use App\Logic\Contracts\OperatorResolverInterface;

final class Calc implements CalculatorInterface
{
    /** @var array<int, float> */
    private array $operands = [];
    private string $operator = '';
    private float $result = 0;

    public function __construct(public OperatorResolverInterface $operatorResolver)
    {
    }

    public function setOperand(float $operand): self
    {
        $this->operands[] = $operand;
        return $this;
    }

    public function setOperator(string $operator): self
    {
        $this->operator = $operator;
        return $this;
    }

    public function calculate(): self
    {
        if(empty($this->operator)){
            throw new OperatorNotSetException;
        }

        $this->result = $this->operatorResolver->resolve($this->operator)->calculate($this->operands);
        return $this;
    }

    public function result(): float
    {
        return $this->result;
    }
}
