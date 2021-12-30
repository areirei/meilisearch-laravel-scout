<?php

namespace Meilisearch\Scout;

use Illuminate\Support\ServiceProvider;
use Laravel\Scout\EngineManager;
use MeiliSearch\Client;
use Meilisearch\Scout\Console\DisplayMeilisearch;
use Meilisearch\Scout\Console\DistinctMeilisearch;
use Meilisearch\Scout\Console\FilterMeilisearch;
use Meilisearch\Scout\Console\IndexMeilisearch;
use Meilisearch\Scout\Console\RankingMeilisearch;
use Meilisearch\Scout\Console\SearchMeilisearch;
use Meilisearch\Scout\Console\SortMeilisearch;
use Meilisearch\Scout\Console\SynonymMeilisearch;
use Meilisearch\Scout\Engines\MeilisearchEngine;

class MeilisearchServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'meilisearch');

        $this->app->singleton(Client::class, function () {
            return new Client(config('meilisearch.host'), config('meilisearch.key'));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('meilisearch.php'),
            ], 'config');

            $this->commands([IndexMeilisearch::class, FilterMeilisearch::class, DisplayMeilisearch::class,
                DistinctMeilisearch::class, RankingMeilisearch::class, SearchMeilisearch::class,
                SortMeilisearch::class, SynonymMeilisearch::class, ]);
        }

        resolve(EngineManager::class)->extend('meilisearch', function () {
            return new MeilisearchEngine(
                resolve(Client::class),
                config('scout.soft_delete', false)
            );
        });
    }
}
