<?php

namespace App\Tests;

use App\Controller\PostController;
use App\Entity\Post;
use PHPUnit\Framework\TestCase;

class TestUnitaire extends TestCase
{
    public function test_all_figures(){
        //$controller = new PostController('Indy', );
        $figure = new Post();
        $this->assertSame('Indy', $figure->getTitle());
    }

}