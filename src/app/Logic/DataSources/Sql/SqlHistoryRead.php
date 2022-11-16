<?php

namespace App\Logic\DataSources\Sql;

use App\Logic\Contracts\DataSources\HistoryReadInterface;
use Illuminate\Support\Facades\DB;

final class SqlHistoryRead implements HistoryReadInterface
{
    public function read(?int $limit = null): array
    {
        $return = DB::table('histories');
        if ($limit) {
            $return->take($limit);
        }
        return $return->orderBy('created_at', 'desc')->get('statement')->all();
    }
}
