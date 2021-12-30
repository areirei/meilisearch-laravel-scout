<?php

namespace Meilisearch\Scout\Console;

use Illuminate\Console\Command;
use MeiliSearch\Client;
use MeiliSearch\Exceptions\ApiException;

class DisplayMeilisearch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scout:display
            {name : The name of the index}
            {attributes?* : Without this parameter, the attributes will be got.}
            {--reset : Reset an index displayed attributes list back to its default value.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create/Get/Reset the display attributes.';

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
                    ->resetDisplayedAttributes();
                $this->info('Displayed settings of the"'.$this->argument('name').'" deleted.');

                return;
            }
            //edit
            $attributes = $this->argument('attributes');
            if (count($attributes)) {
                $result = $client->index($this->argument('name'))
                    ->updateDisplayedAttributes($this->argument('attributes'));
                $this->info('Index "'.$this->argument('name').'" have been displayed settings.');

                return;
            }
            //get
            $result = $client->index($this->argument('name'))
                ->getDisplayedAttributes();
            $result = json_encode($result);
            $this->info('Displayed settings of "'.$this->argument('name').'" :'.$result);
        } catch (ApiException $exception) {
            $this->error($exception->getMessage());
        }
    }
}
