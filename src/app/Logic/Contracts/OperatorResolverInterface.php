<?php

namespace App\Logic\Contracts;


interface OperatorResolverInterface
{
    public function resolve(string $operator): OperatorInterface;
}
