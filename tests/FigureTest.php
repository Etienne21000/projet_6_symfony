<?php

namespace App\Tests;

use App\Entity\Post;
use PHPUnit\Framework\TestCase;

class FigureTest extends TestCase
{

    public function test_figures(){
        $figure = new Post();
        $title = 'Indy';
        $content = 'Salut';
        $id = 3;
        $figure->setTitle($title);
        $this->assertEquals('Indy', $figure->getTitle());
    }

    public function test_valid(){
//        $figure = new Post();
//        $this->assertContains($figure->getId(), );
    }

    /*public function test_user(){
        $this->title = 'Indy';
        echo $this->figure->getTitle();
    }*/
}
