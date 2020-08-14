<?php

namespace App\DataFixtures;

use App\Entity\Chat;
use App\Entity\Conversation;
use App\Entity\Image;
use App\Entity\Keyword;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class AppFixtures
 * @package App\DataFixtures
 */
class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * AppFixtures constructor.
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $tempUser = null;

        for ($u = 0; $u < 10; $u++) {
            $user = new User();
            $user->setEmail($faker->email)
                ->setPassword($this->encoder->encodePassword($user, "Password"))
                ->setDisplayName($faker->name)
                ->setProfile("Particular")
                ->setRoles(["ROLE_USER"])
                ->setAreaVisibility(true)
                ->setCreatedAt(0)
                ->setEmailVisibility(true)
                ->setGender("Male")
                ->setImageCount(4)
                ->setKeywordCount(4)
                ->setPhoneVisibility(true);

            $manager->persist($user);
            $tempUser = $user;

            for ($k = 0; $k < random_int(2, 4); $k++) {
                $keyword = (new Keyword())->setValue($faker->text(30))
                    ->setUser($user)
                    ->setCreatedAt(0);

                $manager->persist($keyword);
            }

            for ($i = 0; $i < random_int(2, 4); $i++) {
                $image = (new Image())->setUrl($faker->url)
                    ->setUser($user)
                    ->setCreatedAt(0);

                $manager->persist($image);
            }

            if ($u > 0) {
                $conversation = (new Conversation())
                    ->setUserFrom($user)
                    ->setUserTo($tempUser)
                    ->setCreatedAt(0);

                $manager->persist($conversation);

                for ($c = 0; $c < random_int(2, 8); $c++) {
                    $chat = (new Chat())
                        ->setConversation($conversation)
                        ->setCreatedAt((integer) $c)
                        ->setMessage($faker->text(150))
                        ->setType("Message")
                        ->setSource( "From");

                    $manager->persist($chat);
                }
            }
        }

        $manager->flush();
    }
}
