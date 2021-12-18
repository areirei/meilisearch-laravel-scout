<?php

namespace Meilisearch\Scout\Console;

use Illuminate\Console\Command;
use MeiliSearch\Client;
use MeiliSearch\Exceptions\ApiException;

class DistinctMeilisearch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scout:distinct
            {name : The name of the index}
            {attribute? : Without this parameter, the attribute will be got.}
            {--reset : Reset an index distinct attribute list back to its default value.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create/Get/Reset the distinct attributes.';

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
                    ->resetDistinctAttribute();
                $this->info('Distinct settings of the"'.$this->argument('name').'" deleted.');
                return ;
            }
            //edit
            $attribute=$this->argument('attribute');
            if($attribute){
                $result=$client->index($this->argument('name'))
                    ->updateDistinctAttribute($this->argument('attribute'));
                $this->info('Index "'.$this->argument('name').'" have been distinct settings.');
                return;
            }
            //get
            $result=$client->index($this->argument('name'))
                ->getDistinctAttribute();
            $result=json_encode($result);
            $this->info('Distinct settings of "'.$this->argument('name').'" :'.$result);
        } catch (ApiException $exception) {
            $this->error($exception->getMessage());
        }
    }
}
