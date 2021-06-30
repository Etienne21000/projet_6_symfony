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
        $etienne = (new User())->setUsername('Etienne')->setCreationDate(new\ DateTime())->setEmail('etienne@mail.com');
        $etienne->setRoles(['ROLE_ADMIN']);
        $etienne->setPassword($this->encodedPassword->encodePassword($etienne, 'Equinox75!'));
        $manager->persist($etienne);
        $Michel = (new User())->setUsername('Michel')->setCreationDate(new\ DateTime())->setEmail('michel@mail.com');
        $Michel->setRoles(['ROLE_USER']);
        $Michel->setPassword($this->encodedPassword->encodePassword($Michel, 'OpenClassrooms75!'));
        $manager->persist($Michel);
        $Admin = (new User())->setUsername('Admin')->setCreationDate(new\ DateTime())->setEmail('admin@mail.com');
        $Admin->setRoles(['ROLE_ADMIN']);
        $Admin->setPassword($this->encodedPassword->encodePassword($Admin, 'OpenClassrooms75!'));
        $manager->persist($Admin);
        $indy = (new Post())->setTitle('Indy')->setContent('Tout d\'abord, il faut savoir qu\'il y a deux positions sur sa planche: regular ou goofy. Un rider regular aura son pied gauche devant et un rider goofy aura son pied droit devant. Après un certain moment, les planchistes sont capables de descendre dans les deux positions. Un rider regular qui descend en position goofy, dira qu\'il descend « switch ». Généralement, une manœuvre sera considéré comme plus difficile quand elle est effectué « switch ». Saisie de la carre frontside de la planche, entre les deux pieds, avec la main arrière. Un grab est d\'autant plus réussi que la saisie est longue. De plus, le saut est d\'autant plus esthétique que la saisie du snowboard est franche, ce qui permet au rideur d\'accentuer la torsion de son corps grâce à la tension de sa main sur la planche. On dit alors que le grab est tweaké (le verbe anglais to tweak signifie « pincer » mais a également le sens de « peaufiner »).')->setStatus(1)->setUserId(1)->setCreationDate(new\ DateTime())->setCategory('grabs');
        $indy->setSlug($slugger->slug($indy->getTitle()));
        $manager->persist($indy);
        $indy_img = (new Media())->setPost($indy)->setCreationDate(new\ DateTime())->setPostSlug('indy')->setLink('stalefish.jpg');
        $manager->persist($indy_img);
        $indy_res = (new Ressource())->setStatus(1)->setMedia($indy_img)->setType(1);
        $manager->persist($indy_res);
        $indy_img->setRessource($indy_res);
        $Mute = (new Post())->setTitle('Mute')->setContent('saisie de la carre frontside de la planche entre les deux pieds avec la main avant')->setStatus(1)->setUserId(1)->setCreationDate(new\ DateTime())->setCategory('grabs');
        $Mute->setSlug($slugger->slug($Mute->getTitle()));
        $manager->persist($Mute);
        $mute_img = (new Media())->setPost($Mute)->setCreationDate(new\ DateTime())->setPostSlug('mute')->setLink('mute.jpeg');
        $manager->persist($mute_img);
        $mute_res = (new Ressource())->setStatus(1)->setMedia($mute_img)->setType(1);
        $manager->persist($mute_res);
        $mute_img->setRessource($mute_res);
        $Sad = (new Post())->setTitle('Sad')->setContent('Appelé aussi melancholie ou style week, saisie de la carre backside de la planche, entre les deux pieds, avec la main avant ')->setStatus(1)->setUserId(1)->setCreationDate(new\ DateTime())->setCategory('grabs');
        $Sad->setSlug($slugger->slug($Sad->getTitle()));
        $manager->persist($Sad);
        $sad_img = (new Media())->setPost($Sad)->setCreationDate(new\ DateTime())->setPostSlug('sad')->setLink('sad.jpg');
        $manager->persist($sad_img);
        $sad_res = (new Ressource())->setStatus(1)->setMedia($sad_img)->setType(1);
        $manager->persist($sad_res);
        $sad_img->setRessource($sad_res);
        $Stalefish = (new Post())->setTitle('Stalefish')->setContent('saisie de la carre backside de la planche entre les deux pieds avec la main arrière')->setStatus(1)->setUserId(1)->setCreationDate(new\ DateTime())->setCategory('grabs');
        $Stalefish->setSlug($slugger->slug($Stalefish->getTitle()));
        $manager->persist($Stalefish);
        $stalefish_img = (new Media())->setPost($Stalefish)->setCreationDate(new\ DateTime())->setPostSlug('stalefish')->setLink('stalefish.jpg');
        $manager->persist($stalefish_img);
        $stalefish_res = (new Ressource())->setStatus(1)->setMedia($stalefish_img)->setType(1);
        $manager->persist($stalefish_res);
        $stalefish_img->setRessource($stalefish_res);
        $Tail_grab = (new Post())->setTitle('Tail grab')->setContent('saisie de la partie arrière de la planche, avec la main arrière')->setStatus(1)->setUserId(1)->setCreationDate(new\ DateTime())->setCategory('grabs');
        $Tail_grab->setSlug($slugger->slug($Tail_grab->getTitle()));
        $manager->persist($Tail_grab);
        $tail_grab_img = (new Media())->setPost($Tail_grab)->setCreationDate(new\ DateTime())->setPostSlug('tail_grab')->setLink('tail-grab.jpg');
        $manager->persist($tail_grab_img);
        $tail_grab_res = (new Ressource())->setStatus(1)->setMedia($tail_grab_img)->setType(1);
        $manager->persist($tail_grab_res);
        $tail_grab_img->setRessource($tail_grab_res);
        $Nose_grab = (new Post())->setTitle('Nose grab')->setContent('saisie de la partie avant de la planche, avec la main avant')->setStatus(1)->setUserId(1)->setCreationDate(new\ DateTime())->setCategory('grabs');
        $Nose_grab->setSlug($slugger->slug($Nose_grab->getTitle()));
        $manager->persist($Nose_grab);
        $nose_grab_img = (new Media())->setPost($Nose_grab)->setCreationDate(new\ DateTime())->setPostSlug('nose_grab')->setLink('noseGrab.jpg');
        $manager->persist($nose_grab_img);
        $nose_grab_res = (new Ressource())->setStatus(1)->setMedia($nose_grab_img)->setType(1);
        $manager->persist($nose_grab_res);
        $nose_grab_img->setRessource($nose_grab_res);
        $Japan_air = (new Post())->setTitle('Japan air')->setContent('saisie de l\'avant de la planche, avec la main avant, du côté de la carre frontside.')->setStatus(1)->setUserId(1)->setCreationDate(new\ DateTime())->setCategory('grabs');
        $Japan_air->setSlug($slugger->slug($Japan_air->getTitle()));
        $manager->persist($Japan_air);
        $japan_air_img = (new Media())->setPost($Japan_air)->setCreationDate(new\ DateTime())->setPostSlug('japan_air')->setLink('japan.jpg');
        $manager->persist($japan_air_img);
        $japan_air_res = (new Ressource())->setStatus(1)->setMedia($japan_air_img)->setType(1);
        $manager->persist($japan_air_res);
        $japan_air_img->setRessource($japan_air_res);
        $Seat_belt = (new Post())->setTitle('Seat belt')->setContent('saisie du carre frontside à l\'arrière avec la main avant')->setStatus(1)->setUserId(1)->setCreationDate(new\ DateTime())->setCategory('grabs');
        $Seat_belt->setSlug($slugger->slug($Seat_belt->getTitle()));
        $manager->persist($Seat_belt);
        $seat_belt_img = (new Media())->setPost($Seat_belt)->setCreationDate(new\ DateTime())->setPostSlug('seatbelt')->setLink('seatbelt.jpg');
        $manager->persist($seat_belt_img);
        $seat_belt_res = (new Ressource())->setStatus(1)->setMedia($seat_belt_img)->setType(1);
        $manager->persist($seat_belt_res);
        $seat_belt_img->setRessource($seat_belt_res);
        $Truck_driver = (new Post())->setTitle('Truck driver')->setContent('saisie du carre avant et carre arrière avec chaque main (comme tenir un volant de voiture')->setStatus(1)->setUserId(1)->setCreationDate(new\ DateTime())->setCategory('grabs');
        $Truck_driver->setSlug($slugger->slug($Truck_driver->getTitle()));
        $manager->persist($Truck_driver);
        $truck_driver_img = (new Media())->setPost($Truck_driver)->setCreationDate(new\ DateTime())->setPostSlug('truck_driver')->setLink('truck-driver.jpg');
        $manager->persist($truck_driver_img);
        $truck_driver_res = (new Ressource())->setStatus(1)->setMedia($truck_driver_img)->setType(1);
        $manager->persist($truck_driver_res);
        $truck_driver_img->setRessource($truck_driver_res);
        $Cent_80 = (new Post())->setTitle('180')->setContent('On désigne par le mot « rotation » uniquement des rotations horizontales ; les rotations verticales sont des flips. Le principe est d\'effectuer une rotation horizontale pendant le saut, puis d\'attérir en position switch ou normal. La nomenclature se base sur le nombre de degrés de rotation effectués. Un 180 désigne un demi-tour, soit 180 degrés d\'angle')->setStatus(1)->setUserId(1)->setCreationDate(new\ DateTime())->setCategory('rotations');
        $Cent_80->setSlug($slugger->slug($Cent_80->getTitle()));
        $manager->persist($Cent_80);
        $cent_80_img = (new Media())->setPost($Cent_80)->setCreationDate(new\ DateTime())->setPostSlug('180')->setLink('180.jpg');
        $manager->persist($cent_80_img);
        $cent_80_res = (new Ressource())->setStatus(1)->setMedia($cent_80_img)->setType(1);
        $manager->persist($cent_80_res);
        $cent_80_img->setRessource($cent_80_res);
        $comment1 = (new Comment())->setContent('Super figure, je l\'ai testé cet hiver !')->setPost($indy)->setUser($etienne)->setCreationDate(new\ DateTime())->setStatus(1);
        $manager->persist($comment1);
        $comment2 = (new Comment())->setContent('Je tente ça sur les pistes en février')->setPost($indy)->setUser($Michel)->setCreationDate(new\ DateTime())->setStatus(1);
        $manager->persist($comment2);
        $comment3 = (new Comment())->setContent('J\'adore cette figure, je ne m\'en lasse pas')->setPost($indy)->setUser($etienne)->setCreationDate(new\ DateTime())->setStatus(1);
        $manager->persist($comment3);
        $comment4 = (new Comment())->setContent('On pourrait se retrouver dans les Alpes ?')->setPost($indy)->setUser($Michel)->setCreationDate(new\ DateTime())->setStatus(1);
        $manager->persist($comment4);
        $comment5 = (new Comment())->setContent('Oui très bonne idée')->setPost($indy)->setUser($etienne)->setCreationDate(new\ DateTime())->setStatus(1);
        $manager->persist($comment5);
        $comment6 = (new Comment())->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin blandit.')->setPost($indy)->setUser($Michel)->setCreationDate(new\ DateTime())->setStatus(1);
        $manager->persist($comment6);
        $comment7 = (new Comment())->setContent('Lorem ipsum dolor sit amet.')->setPost($indy)->setUser($etienne)->setCreationDate(new\ DateTime())->setStatus(1);
        $manager->persist($comment7);
        $comment8 = (new Comment())->setContent('Consectetur adipiscing elit')->setPost($indy)->setUser($Michel)->setCreationDate(new\ DateTime())->setStatus(1);
        $manager->persist($comment8);
        $comment9 = (new Comment())->setContent('Super')->setPost($indy)->setUser($etienne)->setCreationDate(new\ DateTime())->setStatus(1);
        $manager->persist($comment9);
        $comment10 = (new Comment())->setContent('Génial !')->setPost($indy)->setUser($Michel)->setCreationDate(new\ DateTime())->setStatus(1);
        $manager->persist($comment10);
        $comment11 = (new Comment())->setContent('Au top !')->setPost($indy)->setUser($etienne)->setCreationDate(new\ DateTime())->setStatus(1);
        $manager->persist($comment11);
        $comment12 = (new Comment())->setContent('Super fun !')->setPost($indy)->setUser($Michel)->setCreationDate(new\ DateTime())->setStatus(0);
        $manager->persist($comment12);
        $manager->flush();
    }
}
