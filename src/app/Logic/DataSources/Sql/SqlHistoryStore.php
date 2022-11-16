<?php

namespace App\Logic\DataSources\Sql;

use App\Logic\Contracts\DataSources\HistoryStoreInterface;
use Illuminate\Support\Facades\DB;

final class SqlHistoryStore implements HistoryStoreInterface
{
    public function store(string $statement): void
    {
        DB::table('histories')->insert([
            'statement' => $statement,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
