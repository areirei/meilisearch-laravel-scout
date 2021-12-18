<?php

namespace Meilisearch\Scout\Console;

use Illuminate\Console\Command;
use MeiliSearch\Client;
use MeiliSearch\Exceptions\ApiException;

class SortMeilisearch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scout:sort
            {name : The name of the index}
            {attributes?* : Without this parameter, the attributes will be got.}
            {--reset : Reset an index sortable attributes list back to its default value.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create/Get/Reset the sortable attributes.';

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
            if($this->option('reset')){
                $client->index($this->argument('name'))
                    ->resetSortableAttributes();
                $this->info('Sortable settings of the"'.$this->argument('name').'" deleted.');
                return ;
            }
            //edit
            $attributes=$this->argument('attributes');
            if(count($attributes)){
                $result=$client->index($this->argument('name'))
                    ->updateSortableAttributes($this->argument('attributes'));
                $this->info('Index "'.$this->argument('name').'" have been Sortable settings.');
                return;
            }
            //get
            $result=$client->index($this->argument('name'))
                ->getSortableAttributes();
            $result=json_encode($result);
            $this->info('Sortable settings of "'.$this->argument('name').'" :'.$result);
        } catch (ApiException $exception) {
            $this->error($exception->getMessage());
        }
    }
}
