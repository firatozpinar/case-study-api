<?php

namespace App\Command;

use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class UserCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'app:user';

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * UserCommand constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();

        $this->entityManager = $em;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @return int
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $users = [
            [
                'name'  => 'DEV1',
                'time'  => '1',
                'level' => '1',
            ],
            [
                'name'  => 'DEV2',
                'time'  => '1',
                'level' => '1',
            ],
            [
                'name'  => 'DEV3',
                'time'  => '1',
                'level' => '1',
            ],
            [
                'name'  => 'DEV4',
                'time'  => '1',
                'level' => '1',
            ],
            [
                'name'  => 'DEV5',
                'time'  => '1',
                'level' => '1',
            ]
        ];

        foreach ($users as $data) {
            $user = new Users();
            $user->setName($data['name']);
            $user->setTime($data['time']);
            $user->setLevel($data['level']);

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $io->info('Added: ' . $data['name']);
        }

        $io->success('Completed users added!');

        return Command::SUCCESS;
    }
}
