<?php

namespace App\Logic\DataSources\File;

use App\Logic\Contracts\DataSources\HistoryStoreInterface;
use Illuminate\Support\Facades\Storage;

final class FileHistoryStore implements HistoryStoreInterface
{
    public function store(string $statement): void
    {
        $data = Storage::disk('local')->get('history.json');
        $data = $data ? json_decode($data, true) : [];
        $data = is_array($data) ? $data : [];
        $data[] = [
            'statement' => $statement,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        Storage::disk('local')->put('history.json', strval(json_encode($data)));
    }
}
