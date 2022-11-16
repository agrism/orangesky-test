<?php

namespace App\Logic\DataSources\Fake;


use App\Logic\Contracts\DataSources\HistoryReadInterface;

final class FakeHistoryRead implements HistoryReadInterface
{
    public function read(?int $limit = null): array
    {
        return [];
    }
}
