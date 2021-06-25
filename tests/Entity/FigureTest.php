<?php

namespace App\Tests\Entity;

use App\Entity\Media;
use App\Entity\Post;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class FigureTest extends KernelTestCase
{

    public function get_entity(): Post
    {
        return $figure = (new Post())
            ->setTitle('Test')
            ->setContent('Test d\'une entité')
            ->setStatus(0)
            ->setCreationDate(new\ DateTime())
            ->setCategory('Grab')
            ->setSlug('test')
            ->setUserId(3);
    }

    public function assertKernet(Post $figure, int $number = 0){
        self::bootKernel();
        $error = self::$container->get('validator')->validate($figure);
        $this->assertCount($number, $error);
    }

    public function test_valid(){
        $this->assertKernet($this->get_entity(), 0);
    }

    public function test_invalid_unique(){

        $figure = ($this->get_entity())
            ->setTitle('Indy');
        $this->assertKernet($figure, 1);
    }

    public function test_invalid_notBlank(){

        $figure = ($this->get_entity())
            ->setContent('');
        $this->assertKernet($figure, 1);
    }

    public function test_media(){
        $media = (new Media())
            //->setPost(3)
            ->setCreationDate(new\ DateTime())
            ->setPostId(3)
            ->setPostSlug('Indy')
            ->setLink('Some link');
            //->setRessource()
        self::bootKernel();
        $error = self::$container->get('validator')->validate($media);
        $this->assertCount(0, $error);
    }
}
