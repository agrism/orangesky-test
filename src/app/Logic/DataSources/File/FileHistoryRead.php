<?php

namespace App\Logic\DataSources\File;

use App\Logic\Contracts\DataSources\HistoryReadInterface;
use Illuminate\Support\Facades\Storage;

final class FileHistoryRead implements HistoryReadInterface
{
    public function read(?int $limit = null): array
    {
        $return = Storage::disk('local')->get('history.json');
        $return = json_decode(strval($return), true);
        $return =  array_slice((array)$return, $limit * -1);
        return array_reverse($return);
    }
}
