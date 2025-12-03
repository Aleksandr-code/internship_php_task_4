<?php

namespace App\Command;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'test',
    description: 'Add a short description for your command',
)]
class TestCommand extends Command
{
    public function __construct(private EntityManagerInterface $em, private UserRepository $repository)
    {
        parent::__construct();
    }

    protected function configure(): void
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
//        $user = new User();
//        $user->setEmail('test@mail.ru');
//        $user->setPassword('123');
//        $user->setRoles(['ROLE_USER_ACTIVE']);

//        $this->em->persist($user);
//        $this->em->flush();
        $user = $this->repository->find(5);
        $test = $user->isBlocked();
        dd($test);

        return Command::SUCCESS;
    }
}
