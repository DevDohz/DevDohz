<?php

namespace App\Tests\Entity;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use App\Entity\InfoNews;
use Symfony\Component\Console\Output\OutputInterface;
// use DateTime;
// use phpDocumentor\Reflection\Types\Null_;
// use SebastianBergmann\Environment\Console;

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
            'hydra:totalItems' => 100,
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

        // Asserts that the returned JSON is validated by the JSON Schema generated for this resource by API Platform
        // This generated JSON Schema is also used in the OpenAPI spec!
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
            'dateValidite' => '2100-01-01T00:00:00.000Z',
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
        $client = self::createClient();
        // Through the container, you can access all your services from the tests, including the ORM, the mailer, remote API clients...
        $repo = static::getContainer()->get('doctrine')->getRepository(InfoNews::class);

        // Test la création d'une InfoNews
        $client->request('POST', '/info_news', ['json' => [
            'description' => '27 Aout 2022 : Journée Portes ouvertes au Dojo. RDV 12h sur le tapis pour un cours d\'essaie.',
            'dateValidite' => '1985-09-04T00:00:00.000Z',
            'lienText' => 'LienTextUniquePourTestDelete',
            'lienURL' => null,
            'lienIsTargetBlank' => null,
        ]]);
        $this->assertResponseStatusCodeSame(201);
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertMatchesResourceItemJsonSchema(InfoNews::class);
        

        // Retrouve l'infoNews créée
        $iri = $this->findIriBy(InfoNews::class, ['lienText' => 'LienTextUniquePourTestDelete']);
        $InfoN = $repo->findOneBy(['lienText' => 'LienTextUniquePourTestDelete']);
        $this->assertNotNull($repo->findOneBy(['lienText' => 'LienTextUniquePourTestDelete']));

        
        // Test la suppression de l'InfoNews
        $client->request('DELETE', $iri);
        $this->assertResponseStatusCodeSame(204);
        $this->assertNull($repo->findOneBy(['lienText' => 'LienTextUniquePourTestDelete']));        
    }
}