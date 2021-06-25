<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\AsciiSlugger;
use App\Entity\Post;
use App\Entity\Comment;
use App\Entity\Media;
use App\Entity\Ressource;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encodedPassword;

    public function __construct(UserPasswordEncoderInterface $encodedPassword)
    {
        $this->encodedPassword = $encodedPassword;
    }

    public function load(ObjectManager $manager)
    {
        $slugger = new AsciiSlugger();

        $etienne = (new User())
            ->setUsername('Etienne')
            ->setCreationDate(new\ DateTime())
            ->setEmail('etienne@mail.com');
        $etienne->setRoles(['ROLE_ADMIN']);
        $etienne->setPassword($this->encodedPassword->encodePassword($etienne, 'Equinox75!'));
        $manager->persist($etienne);

        $Michel = (new User())
            ->setUsername('Michel')
            ->setCreationDate(new\ DateTime())
            ->setEmail('michel@mail.com');
        $Michel->setRoles(['ROLE_USER']);
        $Michel->setPassword($this->encodedPassword->encodePassword($Michel, 'OpenClassrooms75!'));
        $manager->persist($Michel);

        $Admin = (new User())
            ->setUsername('Admin')
            ->setCreationDate(new\ DateTime())
            ->setEmail('admin@mail.com');
        $Admin->setRoles(['ROLE_ADMIN']);
        $Admin->setPassword($this->encodedPassword->encodePassword($Admin, 'OpenClassrooms75!'));
        $manager->persist($Admin);

        $indy = (new Post())
            ->setTitle('Indy')
            ->setContent('Tout d\'abord, il faut savoir qu\'il y a deux positions sur sa planche: regular ou goofy. Un rider regular aura son pied gauche devant et un rider goofy aura son pied droit devant. Après un certain moment, les planchistes sont capables de descendre dans les deux positions. Un rider regular qui descend en position goofy, dira qu\'il descend « switch ». Généralement, une manœuvre sera considéré comme plus difficile quand elle est effectué « switch ». Saisie de la carre frontside de la planche, entre les deux pieds, avec la main arrière. Un grab est d\'autant plus réussi que la saisie est longue. De plus, le saut est d\'autant plus esthétique que la saisie du snowboard est franche, ce qui permet au rideur d\'accentuer la torsion de son corps grâce à la tension de sa main sur la planche. On dit alors que le grab est tweaké (le verbe anglais to tweak signifie « pincer » mais a également le sens de « peaufiner »).')
            ->setStatus(1)
            ->setUserId(1)
            ->setCreationDate(new\ DateTime())
            ->setCategory('grabs');

        $indy->setSlug($slugger->slug($indy->getTitle()));
        $manager->persist($indy);

        $Mute = (new Post())
            ->setTitle('Mute')
            ->setContent('saisie de la carre frontside de la planche entre les deux pieds avec la main avant')
            ->setStatus(1)
            ->setUserId(1)
            ->setCreationDate(new\ DateTime())
            ->setCategory('grabs');

        $Mute->setSlug($slugger->slug($Mute->getTitle()));
        $manager->persist($Mute);

        $Sad = (new Post())
            ->setTitle('Sad')
            ->setContent('Appelé aussi melancholie ou style week, saisie de la carre backside de la planche, entre les deux pieds, avec la main avant ')
            ->setStatus(1)
            ->setUserId(1)
            ->setCreationDate(new\ DateTime())
            ->setCategory('grabs');

        $Sad->setSlug($slugger->slug($Sad->getTitle()));
        $manager->persist($Sad);

        $Stalefish = (new Post())
            ->setTitle('Stalefish')
            ->setContent('saisie de la carre backside de la planche entre les deux pieds avec la main arrière')
            ->setStatus(1)
            ->setUserId(1)
            ->setCreationDate(new\ DateTime())
            ->setCategory('grabs');

        $Stalefish->setSlug($slugger->slug($Stalefish->getTitle()));
        $manager->persist($Stalefish);

        $Tail_grab = (new Post())
            ->setTitle('Tail grab')
            ->setContent('saisie de la partie arrière de la planche, avec la main arrière')
            ->setStatus(1)
            ->setUserId(1)
            ->setCreationDate(new\ DateTime())
            ->setCategory('grabs');

        $Tail_grab->setSlug($slugger->slug($Tail_grab->getTitle()));
        $manager->persist($Tail_grab);

        $Nose_grab = (new Post())
            ->setTitle('Nose grab')
            ->setContent('saisie de la partie avant de la planche, avec la main avant')
            ->setStatus(1)
            ->setUserId(1)
            ->setCreationDate(new\ DateTime())
            ->setCategory('grabs');

        $Nose_grab->setSlug($slugger->slug($Nose_grab->getTitle()));
        $manager->persist($Nose_grab);

        $Japan_air = (new Post())
            ->setTitle('Japan air')
            ->setContent('saisie de l\'avant de la planche, avec la main avant, du côté de la carre frontside.')
            ->setStatus(1)
            ->setUserId(1)
            ->setCreationDate(new\ DateTime())
            ->setCategory('grabs');

        $Japan_air->setSlug($slugger->slug($Japan_air->getTitle()));
        $manager->persist($Japan_air);

        $Seat_belt = (new Post())
            ->setTitle('Seat belt')
            ->setContent('saisie du carre frontside à l\'arrière avec la main avant')
            ->setStatus(1)
            ->setUserId(1)
            ->setCreationDate(new\ DateTime())
            ->setCategory('grabs');

        $Seat_belt->setSlug($slugger->slug($Seat_belt->getTitle()));
        $manager->persist($Seat_belt);

        $Truck_driver = (new Post())
            ->setTitle('Truck driver')
            ->setContent('saisie du carre avant et carre arrière avec chaque main (comme tenir un volant de voiture')
            ->setStatus(1)
            ->setUserId(1)
            ->setCreationDate(new\ DateTime())
            ->setCategory('grabs');

        $Truck_driver->setSlug($slugger->slug($Truck_driver->getTitle()));
        $manager->persist($Truck_driver);


        $comment1 = (new Comment())
            ->setContent('Super figure, je l\'ai testé cet hiver !')
            ->setPost($indy)
            ->setUser($etienne)
            ->setCreationDate(new\ DateTime())
            ->setStatus(0);

        $manager->persist($comment1);

        $comment2 = (new Comment())
            ->setContent('Je tente ça sur les pistes en février')
            ->setPost($indy)
            ->setUser($Michel)
            ->setCreationDate(new\ DateTime())
            ->setStatus(0);

        $manager->persist($comment2);

        $comment3 = (new Comment())
            ->setContent('J\'adore cette figure, je ne m\'en lasse pas')
            ->setPost($indy)
            ->setUser($etienne)
            ->setCreationDate(new\ DateTime())
            ->setStatus(0);

        $manager->persist($comment3);

        $comment4 = (new Comment())
            ->setContent('On pourrait se retrouver dans les Alpes ?')
            ->setPost($indy)
            ->setUser($Michel)
            ->setCreationDate(new\ DateTime())
            ->setStatus(0);

        $manager->persist($comment4);

        $comment5 = (new Comment())
            ->setContent('Oui très bonne idée')
            ->setPost($indy)
            ->setUser($etienne)
            ->setCreationDate(new\ DateTime())
            ->setStatus(0);

        $manager->persist($comment5);

        $comment6 = (new Comment())
            ->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin blandit.')
            ->setPost($indy)
            ->setUser($Michel)
            ->setCreationDate(new\ DateTime())
            ->setStatus(0);

        $manager->persist($comment6);

        $comment7 = (new Comment())
            ->setContent('Lorem ipsum dolor sit amet.')
            ->setPost($indy)
            ->setUser($etienne)
            ->setCreationDate(new\ DateTime())
            ->setStatus(0);

        $manager->persist($comment7);

        $comment8 = (new Comment())
            ->setContent('Consectetur adipiscing elit')
            ->setPost($indy)
            ->setUser($Michel)
            ->setCreationDate(new\ DateTime())
            ->setStatus(0);

        $manager->persist($comment8);

        $comment9 = (new Comment())
            ->setContent('Super')
            ->setPost($indy)
            ->setUser($etienne)
            ->setCreationDate(new\ DateTime())
            ->setStatus(0);

        $manager->persist($comment9);

        $comment10 = (new Comment())
            ->setContent('Génial !')
            ->setPost($indy)
            ->setUser($Michel)
            ->setCreationDate(new\ DateTime())
            ->setStatus(0);

        $manager->persist($comment10);

        $manager->flush();
    }
}
