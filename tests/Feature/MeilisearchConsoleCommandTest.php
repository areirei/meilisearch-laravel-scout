<?php

namespace Meilisearch\Scout\Tests\Feature;

use MeiliSearch\Client;
use MeiliSearch\Exceptions\ApiException;

class MeilisearchConsoleCommandTest extends FeatureTestCase
{
    /** @test */
    public function nameArgumentIsRequired()
    {
        $this->expectExceptionMessage('Not enough arguments (missing: "name").');
        $this->artisan('scout:index')
            ->execute();
    }

    /** @test */
    public function indexCanBeCreatedAndDeleted()
    {
        $indexUid = $this->getPrefixedIndexUid('testindex');

        $this->artisan('scout:index', [
            'name' => $indexUid,
        ])
            ->expectsOutput('Index "'.$indexUid.'" created.')
            ->assertExitCode(0)
            ->run();

        $indexResponse = resolve(Client::class)->index($indexUid)->fetchRawInfo();

        $this->assertIsArray($indexResponse);
        $this->assertSame($indexUid, $indexResponse['uid']);

        $this->artisan('scout:index', [
            'name' => $indexUid,
            '--delete' => true,
        ])
            ->expectsOutput('Index "'.$indexUid.'" deleted.')
            ->assertExitCode(0)
            ->run();

        try {
            resolve(Client::class)->index($indexUid)->fetchRawInfo();
            $this->fail('Exception should be thrown that index doesn\'t exist!');
        } catch (ApiException $exception) {
            $this->assertTrue(true);
        }
    }
    /** @test */
    public function displayCanBeCreatedAndDeleted()
    {
        $indexUid = $this->getPrefixedIndexUid('testindex');
        //edit
        $attributes=['name'];
        $this->artisan('scout:display', [
            'name' => $indexUid,
            'attributes'=>$attributes
        ])
            ->expectsOutput('Index "'.$indexUid.'" have been displayed.')
            ->assertExitCode(0)
            ->run();
        //reset
        $this->artisan('scout:display', [
            'name' => $indexUid,
            '--reset' => true
        ])
            ->expectsOutput('Displayed settings of the"'.$indexUid.'" deleted.')
            ->assertExitCode(0)
            ->run();
    }
    /** @test */
    public function distinctCanBeCreatedAndDeleted()
    {
        $indexUid = $this->getPrefixedIndexUid('testindex');
        //edit
        $attributes=['name'];
        $this->artisan('scout:distinct', [
            'name' => $indexUid,
            'attribute'=>$attributes[0]
        ])
            ->expectsOutput('Index "'.$indexUid.'" have been distinct settings.')
            ->assertExitCode(0)
            ->run();
        //reset
        $this->artisan('scout:distinct', [
            'name' => $indexUid,
            '--reset' => true
        ])
            ->expectsOutput('Distinct settings of the"'.$indexUid.'" deleted.')
            ->assertExitCode(0)
            ->run();
    }
    /** @test */
    public function filterCanBeCreatedAndDeleted()
    {
        $indexUid = $this->getPrefixedIndexUid('testindex');
        //edit
        $attributes=['name'];
        $this->artisan('scout:filter', [
            'name' => $indexUid,
            'attributes'=>$attributes
        ])
            ->expectsOutput('Index "'.$indexUid.'" have been filterable settings.')
            ->assertExitCode(0)
            ->run();
        //reset
        $this->artisan('scout:filter', [
            'name' => $indexUid,
            '--reset' => true
        ])
            ->expectsOutput('Filterable settings of the"'.$indexUid.'" deleted.')
            ->assertExitCode(0)
            ->run();
    }
    /** @test */
    public function rankingCanBeCreatedAndDeleted()
    {
        $indexUid = $this->getPrefixedIndexUid('testindex');
        //edit
        $attributes=['name'];
        $this->artisan('scout:ranking', [
            'name' => $indexUid,
            'attributes'=>$attributes
        ])
            ->expectsOutput('Index "'.$indexUid.'" have been ranking rules.')
            ->assertExitCode(0)
            ->run();
        //reset
        $this->artisan('scout:ranking', [
            'name' => $indexUid,
            '--reset' => true
        ])
            ->expectsOutput('Ranking rules of the"'.$indexUid.'" deleted.')
            ->assertExitCode(0)
            ->run();
    }
    /** @test */
    public function searchCanBeCreatedAndDeleted()
    {
        $indexUid = $this->getPrefixedIndexUid('testindex');
        //edit
        $attributes=['name'];
        $this->artisan('scout:search', [
            'name' => $indexUid,
            'attributes'=>$attributes
        ])
            ->expectsOutput('Index "'.$indexUid.'" have been searchable settings.')
            ->assertExitCode(0)
            ->run();
        //reset
        $this->artisan('scout:search', [
            'name' => $indexUid,
            '--reset' => true
        ])
            ->expectsOutput('Searchable settings of the"'.$indexUid.'" deleted.')
            ->assertExitCode(0)
            ->run();
    }
    /** @test */
    public function sortCanBeCreatedAndDeleted()
    {
        $indexUid = $this->getPrefixedIndexUid('testindex');
        //edit
        $attributes=['name'];
        $this->artisan('scout:sort', [
            'name' => $indexUid,
            'attributes'=>$attributes
        ])
            ->expectsOutput('Index "'.$indexUid.'" have been Sortable settings.')
            ->assertExitCode(0)
            ->run();
        //reset
        $this->artisan('scout:sort', [
            'name' => $indexUid,
            '--reset' => true
        ])
            ->expectsOutput('Sortable settings of the"'.$indexUid.'" deleted.')
            ->assertExitCode(0)
            ->run();
    }
    /** @test */
    public function synonymCanBeCreatedAndDeleted()
    {
        $indexUid = $this->getPrefixedIndexUid('testindex');
        //reset
        $this->artisan('scout:synonym', [
            'name' => $indexUid,
            '--reset' => true
        ])
            ->expectsOutput('Synonyms settings of the"'.$indexUid.'" deleted.')
            ->assertExitCode(0)
            ->run();
    }
}
