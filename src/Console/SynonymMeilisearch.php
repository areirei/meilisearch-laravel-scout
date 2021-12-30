<?php

namespace Meilisearch\Scout\Console;

use Illuminate\Console\Command;
use MeiliSearch\Client;
use MeiliSearch\Exceptions\ApiException;

class SynonymMeilisearch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scout:synonym
            {name : The name of the index}
            {--reset : Reset the list of synonyms of an index to its default value.}';
    //{attributes?* : Without this parameter, the attributes will be got.}

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get/Reset the synonyms.';

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
                    ->resetSynonyms();
                $this->info('Synonyms settings of the"'.$this->argument('name').'" deleted.');

                return;
            }
            //edit @todo the synonyms is Two-dimensional array
            // $attributes=$this->argument('attributes');
            // if(count($attributes)){
            //     $result=$client->index($this->argument('name'))
            //         ->updateSynonyms($this->argument('attributes'));
            //     $this->info('Index "'.$this->argument('name').'" have been synonyms settings.');
            //     return;
            // }
            //get
            $result = $client->index($this->argument('name'))
                ->getSynonyms();
            $result = json_encode($result);
            $this->info('Synonyms settings of "'.$this->argument('name').'" :'.$result);
        } catch (ApiException $exception) {
            $this->error($exception->getMessage());
        }
    }
}
