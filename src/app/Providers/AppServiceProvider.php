<?php

namespace App\Providers;

use App\Http\Resources\CalculatorResource;
use App\Logic\Calc;
use App\Logic\Contracts\CalculatorInterface;
use App\Logic\Contracts\DataSources\HistoryReadInterface;
use App\Logic\Contracts\DataSources\HistoryStoreInterface;
use App\Logic\Contracts\OperatorResolverInterface;
use App\Logic\DataSources\Fake\FakeHistoryRead;
use App\Logic\DataSources\Fake\FakeHistoryStore;
use App\Logic\DataSources\File\FileHistoryRead;
use App\Logic\DataSources\File\FileHistoryStore;
use App\Logic\DataSources\Sql\SqlHistoryRead;
use App\Logic\DataSources\Sql\SqlHistoryStore;
use App\Logic\Operator\OperatorResolver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     * @var array<int, array{config: string,default: string,abstract: string, concrete: array{sql:string, file:string, fake:string}}> $toResolve
     */
    private array $toResolve = [];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->toResolve = [
            [
                'config' => strval(config('resolver.storage')),
                'default' => FakeHistoryStore::class,
                'abstract' => HistoryStoreInterface::class,
                'concrete' => [
                    'sql' => SqlHistoryStore::class,
                    'file' => FileHistoryStore::class,
                    'fake' => FakeHistoryStore::class
                ],
            ],
            [
                'config' => strval(config('resolver.storage')),
                'default' => FakeHistoryRead::class,
                'abstract' => HistoryReadInterface::class,
                'concrete' => [
                    'sql' => SqlHistoryRead::class,
                    'file' => FileHistoryRead::class,
                    'fake' => FakeHistoryRead::class
                ],
            ],
        ];

        $this->resolve()->app->bind(OperatorResolverInterface::class, OperatorResolver::class);
        $this->resolve()->app->bind(CalculatorInterface::class, Calc::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        CalculatorResource::withoutWrapping();
    }

    private function resolve(): self
    {
        foreach ($this->toResolve as $item) {
            $this->app->bind($item['abstract'], function () use ($item): mixed {
                return app($item['concrete'][$item['config']] ?? $item['default']);
            });
        }

        return $this;
    }
}
