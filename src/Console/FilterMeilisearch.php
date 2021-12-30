<?php

namespace Meilisearch\Scout\Console;

use Illuminate\Console\Command;
use MeiliSearch\Client;
use MeiliSearch\Exceptions\ApiException;

class FilterMeilisearch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scout:filter
            {name : The name of the index}
            {attributes?* : Attributes that can be used as filters for filtering and faceted search.Without this parameter, the attributes will be got.}
            {--reset : Reset an index filterable attributes list back to its default value.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create/Get/Reset the filterable attributes.';

    /**
     * Execute the console command.
     *
     * @param \Illuminate\Contracts\Events\Dispatcher $events
     *
     * @return void
     */
    public function handle(Client $client)
    {
        try {
            //delete
            if ($this->option('reset')) {
                $client->index($this->argument('name'))
                    ->resetFilterableAttributes();
                $this->info('Filterable settings of the"'.$this->argument('name').'" deleted.');

                return;
            }
            //edit
            $attributes = $this->argument('attributes');
            if (count($attributes)) {
                $result = $client->index($this->argument('name'))
                    ->updateFilterableAttributes($this->argument('attributes'));
                $this->info('Index "'.$this->argument('name').'" have been filterable settings.');

                return;
            }
            //get
            $result = $client->index($this->argument('name'))
                ->getFilterableAttributes();
            $result = json_encode($result);
            $this->info('Filterable settings of "'.$this->argument('name').'" :'.$result);
        } catch (ApiException $exception) {
            $this->error($exception->getMessage());
        }
    }
}
