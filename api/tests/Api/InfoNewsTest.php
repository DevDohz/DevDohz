<?php

namespace App\Tests;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Core\OpenApi\Model\Info;
use App\Entity\InfoNews;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

class InfoNewsTest extends ApiTestCase
{
    // This trait provided by AliceBundle will take care of refreshing the database content to a known state before each test
    use RefreshDatabaseTrait;
    
    // Test Récupération des InfoNews
    public function testGetCollection(): void
    {
        // The client implements Symfony HttpClient's `HttpClientInterface`, and the response `ResponseInterface`
        $response = static::createClient()->request('GET', '/InfoNews');

        $this->assertResponseIsSuccessful();
        // Asserts that the returned content type is JSON-LD (the default)
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');

        // Asserts that the returned JSON is a superset of this one
        $this->assertJsonContains([
            '@context' => '/contexts/InfoNews',
            '@id' => '/infoNews',
            '@type' => 'hydra:Collection',
            'hydra:totalItems' => 100,
            'hydra:view' => [
                '@id' => '/InfoNews?page=1',
                '@type' => 'hydra:PartialCollectionView',
                'hydra:first' => '/InfoNews?page=1',
                'hydra:last' => '/InfoNews?page=4',
                'hydra:next' => '/InfoNews?page=2',
            ],
        ]);

        // Because test fixtures are automatically loaded between each test, you can assert on them
        $this->assertCount(30, $response->toArray()['hydra:member']);

        // Asserts that the returned JSON is validated by the JSON Schema generated for this resource by API Platform
        // This generated JSON Schema is also used in the OpenAPI spec!
        $this->assertMatchesResourceCollectionJsonSchema(InfoNews::class);
    }

    // Test de la création OK d'une InfoNews
    public function testCreateInfoNews(): void
    {
        $response = static::createClient()->request('POST', '/InfoNews', ['json' => [
            "description"=> "Coupe Technique : les 18 - 19 Juin à Léognan - Nationnal EAJJ",
            "dateValidite"=> "2022-05-07T09:30:29.765Z",
            "lienText"=> "Inscriptions",
            "lienURL"=> "/contact#idFormcontact",
            "lienIsTargetBlank"=> false,
        ]]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertJsonContains([
            '@context' => '/contexts/InfoNews',
            '@type' => 'InfoNews',
            "description"=> "Coupe Technique : les 18 - 19 Juin à Léognan - Nationnal EAJJ",
            "dateValidite"=> "2022-05-07T09:30:29.765Z",
            "lienText"=> "Inscriptions",
            "lienURL"=> "/contact#idFormcontact",
            "lienIsTargetBlank"=> false,
        ]);
        $this->assertMatchesRegularExpression('~^/InfoNews/\d+$~', $response->toArray()['@id']);
        $this->assertMatchesResourceItemJsonSchema(InfoNews::class);
    }

    // public function testCreateGreeting()
    // {
    //     $response = static::createClient()->request('POST', '/greetings', ['json' => [
    //         'name' => 'Kévin',
    //     ]]);

    //     $this->assertResponseStatusCodeSame(201);
    //     $this->assertJsonContains([
    //         '@context' => '/contexts/Greeting',
    //         '@type' => 'Greeting',
    //         'name' => 'Kévin',
    //     ]);
    // }
}