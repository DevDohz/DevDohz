<?php

namespace App\Tests\Entity;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use App\Entity\InfoNews;
use SebastianBergmann\Environment\Console;

class InfoNewsEntityTest extends ApiTestCase
{
    // This trait provided by AliceBundle will take care of refreshing the database content to a known state before each test
    use RefreshDatabaseTrait;

    public function testGetCollection(): void
    {
        // The client implements Symfony HttpClient's `HttpClientInterface`, and the response `ResponseInterface`
        $response = static::createClient()->request('GET', '/info_news');

        $this->assertResponseIsSuccessful();
        // Asserts that the returned content type is JSON-LD (the default)
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');

        // Asserts that the returned JSON is a superset of this one
        $this->assertJsonContains([
            '@context' => '/contexts/InfoNews',
            '@id' => '/info_news',
            '@type' => 'hydra:Collection',
            'hydra:totalItems' => 105,
            'hydra:view' => [
                '@id' => '/info_news?page=1',
                '@type' => 'hydra:PartialCollectionView',
                'hydra:first' => '/info_news?page=1',
                'hydra:last' => '/info_news?page=4',
                'hydra:next' => '/info_news?page=2',
            ],
        ]);

        // Because test fixtures are automatically loaded between each test, you can assert on them
        $this->assertCount(30, $response->toArray()['hydra:member']);
        $this->assertMatchesResourceCollectionJsonSchema(InfoNews::class);
    }

    public function testCreateInfoNewsFull() : void
    {
        // Test la création d'une InfoNews
        $response = static::createClient()->request('POST', '/info_news', ['json' => [
            'description' => '27 Aout 2022 : Journée Portes ouvertes au Dojo. RDV 12h sur le tapis pour un cours d\'essaie.',
            'dateValidite' => '2022-08-31T09:47:42.295Z',
            'lienText' => 'LienTextUniquePourTest',
            'lienURL' => 'https://www.openjujitsu.fr',
            'lienIsTargetBlank' => true,
        ]]);
        $this->assertResponseStatusCodeSame(201);
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertMatchesResourceItemJsonSchema(InfoNews::class);
    }
    public function testCreateInfoNewsMinimal() : void
    {
        // Test la création d'une InfoNews
        $response = static::createClient()->request('POST', '/info_news', ['json' => [
            'description' => '27 Aout 2022 : Journée Portes ouvertes au Dojo. RDV 12h sur le tapis pour un cours d\'essaie.',
            'dateValidite' => '2100-01-01T00:00:00.000Z',
            'lienText' => '',
            'lienURL' => null,
            'lienIsTargetBlank' => null,
        ]]);
        $this->assertResponseStatusCodeSame(201);
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertMatchesResourceItemJsonSchema(InfoNews::class);
    }
    public function testCreateInfoNewsErrDescBlank() : void
    {
        // Test la création d'une InfoNews
        $response = static::createClient()->request('POST', '/info_news', ['json' => [
            'description' => '',
            'dateValidite' => '1985-09-04T00:00:00.000Z',
            'lienText' => '',
            'lienURL' => null,
            'lienIsTargetBlank' => null,
        ]]);
        $this->assertResponseStatusCodeSame(422);
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertJsonContains([
            '@context' => '/contexts/ConstraintViolationList',
            '@type' => 'ConstraintViolationList',
            'hydra:title' => 'An error occurred',
            'hydra:description' => 'description: This value should not be blank.'            
        ]);
    }
    public function testDeleteInfoNewsMinimal() : void
    {
        $client = static::createClient();
        // Through the container, you can access all your services from the tests, including the ORM, the mailer, remote API clients...
        $repo = static::getContainer()->get('doctrine')->getRepository(InfoNews::class);

        // Retrouve l'infoNews
        $iri = $this->findIriBy(InfoNews::class, ['lienText' => 'LienTextUniquePourTest']);
        $this->assertNotNull($repo->findOneBy(['lienText' => 'LienTextUniquePourTest']));
        
        // Test la suppression de l'InfoNews
        $client->request('DELETE', $iri);
        $this->assertResponseStatusCodeSame(204);
        $this->assertNull($repo->findOneBy(['lienText' => 'LienTextUniquePourTest']));        
    }
    public function testUpdateInfoNews() : void
    {
        $client = static::createClient();
        // Through the container, you can access all your services from the tests, including the ORM, the mailer, remote API clients...
        $repo = static::getContainer()->get('doctrine')->getRepository(InfoNews::class);

        // Retrouve l'infoNews
        $iri = $this->findIriBy(InfoNews::class, ['lienText' => 'LienTextUniquePourTest']);
        $this->assertNotNull($repo->findOneBy(['lienText' => 'LienTextUniquePourTest']));
        $client->request('GET', $iri);
        $this->assertJsonContains([
            '@id' => $iri,
            'description' => '27 Aout 2022 : Journée Portes ouvertes au Dojo.',
            'lienText' => 'LienTextUniquePourTest',
        ]);
        
        // Test la MaJ de l'InfoNews
        $client->request('PUT', $iri,  ['json' => [
            'description' => 'Updated Description',
            'lienURL' => 'www.openjujitsu.test',
        ]]);
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            '@id' => $iri,
            'description' => 'Updated Description',
            'lienText' => 'LienTextUniquePourTest',
            'lienURL' => 'www.openjujitsu.test',
        ]);        
    }

    // Test les Filters : sur une date antérieur à + tri ascendant
    public function testGetCollectionByFilterDate(): void
    {        
        $response = static::createClient()->request('GET', '/info_news?dateValidite[after]=2950-09-01&order[dateValidite]&lienText=LienTextUniquePourTest');

        $this->assertResponseIsSuccessful();
        // Asserts that the returned content type is JSON-LD (the default)
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        print_r($response->toArray()['hydra:member']);

        // Asserts that the returned JSON is a superset of this one
        $this->assertJsonContains([
            '@context' => '/contexts/InfoNews',
            '@id' => '/info_news',
            '@type' => 'hydra:Collection',
            'hydra:totalItems' => 3,
            'hydra:view' => [
                '@id' => '/info_news?dateValidite%5Bafter%5D=2950-09-01&order%5BdateValidite%5D=&lienText=LienTextUniquePourTest',
                '@type' => 'hydra:PartialCollectionView',
            ],
        ]);

        // Because test fixtures are automatically loaded between each test, you can assert on them
        $this->assertCount(3, $response->toArray()['hydra:member']);
        $this->assertMatchesResourceCollectionJsonSchema(InfoNews::class);
        $tabInfoNews = $response->toArray()['hydra:member'];
        // on s'attend à avoir les dates triées la 4 avant la 5, contrairement au chargement des fixtures
        $this->assertEquals($tabInfoNews[1]['lienText'], '4LienTextUniquePourTest');      
    }

}
