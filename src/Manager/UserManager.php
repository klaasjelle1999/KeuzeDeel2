<?php


namespace App\Manager;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserManager
{
    /** @var EntityManagerInterface $em */
    private $em;

    /** @var UserPasswordEncoderInterface $passwordEncoder */
    private $passwordEncoder;

    /**
     * UserManager constructor.
     * @param EntityManagerInterface $em
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->em = $em;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function createUser($data)
    {
        $user = new User();
        $password = $this->passwordEncoder->encodePassword($user, $data['password']);
        $user
            ->setRoles([$data['role']])
            ->setPassword($password)
            ->setEmail($data['email'])
        ;

        $this->em->persist($user);
        $this->em->flush();
    }

    public function removeUser(User $user)
    {
        $this->em->remove($user);
        $this->em->flush();
    }

    public function editUser(User $user, $data)
    {
        $password = $this->passwordEncoder->encodePassword($user, $data['password']);

        $user
            ->setEmail($data['email'])
            ->setPassword($password)
        ;

        $this->em->merge($user);
        $this->em->flush();
    }
}