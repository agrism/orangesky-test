<?php

namespace App\Logic\Contracts;

interface CalculatorInterface
{
    public function __construct(OperatorResolverInterface $operatorResolver);
    public function setOperand(float $operand): self;
    public function setOperator(string $operator): self;
    public function calculate(): self;
    public function result(): float;
}
