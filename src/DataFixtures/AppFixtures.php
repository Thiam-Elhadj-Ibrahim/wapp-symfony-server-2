<?php

namespace App\DataFixtures;

use App\Entity\Keyword;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
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

            for ($k = 0; $k < random_int(2, 10); $k++) {
                $keyword = (new Keyword())->setValue($faker->text(30))
                    ->setUser($user)
                    ->setCreatedAt(0);

                $manager->persist($keyword);
            }
        }

        $manager->flush();
    }
}
