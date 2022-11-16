<?php

namespace App\Logic\Contracts\DataSources;

interface HistoryReadInterface
{
    public function read(?int $limit = null): array;
}
