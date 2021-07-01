<?php

namespace App\Tests;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FAQTest extends WebTestCase
{
    public function testAddFAQ(): void
    {
       
        $json = '{
            "title": "question 1",
            "promoted": "true",
            "status": "draft",
            "answers": [{
                "channel": "faq",
                "body": "ceci est la première réponse à la question 1"
            },
            {
                "channel": "faq",
                "body": "ceci est la deuxième réponse à la question 1"
            }]
        }';
        $client = static::createClient();
        $client->request('POST', '/FAQ/add',array(),array(),array('CONTENT_TYPE'=>'application/json'),$json);
        $response = $client->getResponse();
        $this->assertJsonResponse($response, 201, false);
        
    }

    public function testUpdateFAQ(): void
    {
       
        $json = '{
            "id": "1",
            "title": "question test",
            "status": "draft"
        }';
        $client = static::createClient();
        $client->request('POST', '/FAQ/update',array(),array(),array('CONTENT_TYPE'=>'application/json'),$json);
        $response = $client->getResponse();
        $this->assertJsonResponse($response, 201, false);
        
    }

    protected function assertJsonResponse($response, $statusCode = 200)
    {
        $this->assertEquals(
            $statusCode, $response->getStatusCode(),
            $response->getContent()
        );
        $this->assertTrue(
            $response->headers->contains('Content-Type', 'application/json'),
            $response->headers
        );
    }

}
