<?php

namespace App\Tests\Entity;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use App\Entity\InfoNews;


class InfoNewsEntityTest extends ApiTestCase
{
    // This trait provided by AliceBundle will take care of refreshing the database content to a known state before each test
    use RefreshDatabaseTrait;

    public function testGetCollection(): void
    {
        // The client implements Symfony HttpClient's `HttpClientInterface`, and the response `ResponseInterface`
        $response = static::createClient()->request('GET', '/InfoNews');

        $this->assertResponseIsSuccessful();
        // Asserts that the returned content type is JSON-LD (the default)
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');

        // // Asserts that the returned JSON is a superset of this one
        // $this->assertJsonContains([
        //     '@context' => '/contexts/InfoNews',
        //     '@id' => '/InfoNews',
        //     '@type' => 'hydra:Collection',
        //     'hydra:totalItems' => 100,
        //     'hydra:view' => [
        //         '@id' => '/InfoNews?page=1',
        //         '@type' => 'hydra:PartialCollectionView',
        //         'hydra:first' => '/InfoNews?page=1',
        //         'hydra:last' => '/InfoNews?page=4',
        //         'hydra:next' => '/InfoNews?page=2',
        //     ],
        // ]);

        // // Because test fixtures are automatically loaded between each test, you can assert on them
        // $this->assertCount(30, $response->toArray()['hydra:member']);

        // // Asserts that the returned JSON is validated by the JSON Schema generated for this resource by API Platform
        // // This generated JSON Schema is also used in the OpenAPI spec!
        // $this->assertMatchesResourceCollectionJsonSchema(InfoNews::class);
    }

    /*
    public function testCreateInfoNews() : void
    {
        $InfN = new InfoNews();
        $InfN->request('POST', '/InfoNews', ['json' => [
            'description' => '27 Aout 2022 : Journée Portes ouvertes au Dojo. RDV 12h sur le tapis pour un cours d\'essaie.',
            'dateValidite' => '2022-08-31T00:00:00+00:00',
            'lienText' => 'Information',
            'lienURL' => 'https://www.openjujitsu.fr',
            'lienIsTargetBlank' => 'true']
        ]);
        $this->assertResponseStatusCodeSame(201);
        $this->logIn($InfN, 'cheeseplease@example.com', 'brie');

        $response = static::createClient()->request('POST', '/InfoNews', ['json' => [
            'description' => '27 Aout 2022 : Journée Portes ouvertes au Dojo. RDV 12h sur le tapis pour un cours d\'essaie.',
            'dateValidite' => '2022-08-31T00:00:00+00:00',
            'lienText' => 'Information',
            'lienURL' => 'https://www.openjujitsu.fr',
            'lienIsTargetBlank' => 'true',
        ]]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
    } */
}