<?php

namespace App\Logic\DataSources\Fake;


use App\Logic\Contracts\DataSources\HistoryStoreInterface;

final class FakeHistoryStore implements HistoryStoreInterface
{
    public function store(string $statement): void
    {
    }
}
