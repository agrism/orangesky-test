<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

final class CalculatorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function toArray($request): array
    {
        return [
            'result' => data_get($this, 'result'),
            'history' => collect((array)data_get($this, 'history'))->map(function ($item): array {
                return [
                    'statement' => data_get($item, 'statement'),
                ];
            }),
        ];
    }
}
