<?php


namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class FigureControllerTest extends WebTestCase
{

    public function single_figure_test(){
        $client = static::createClient();

        $client->request('GET', '/figure/indy/');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

}