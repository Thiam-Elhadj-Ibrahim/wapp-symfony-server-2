<?php


namespace App\Controller\Api;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserKeywordsController
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param User $data
     */
    public function __invoke(User $data)
    {
        dd($data);
    }
}