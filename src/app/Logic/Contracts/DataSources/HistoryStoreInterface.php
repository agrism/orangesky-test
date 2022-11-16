<?php

namespace App\Logic\Contracts\DataSources;

interface HistoryStoreInterface
{
    public function store(string $statement): void;
}
