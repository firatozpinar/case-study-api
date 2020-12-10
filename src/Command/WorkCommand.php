<?php

namespace App\Command;

use App\Entity\Works;
use App\Services\ProviderFacede;
use App\Services\ProviderFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class WorkCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'app:works';

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * WorkCommand constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();

        $this->entityManager = $em;
    }

    /**
     * @return void
     */
    protected function configure(): void
    {
        $this->addArgument('process', InputArgument::REQUIRED, 'Argument description');
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
        $process = $input->getArgument('process');

        if (!$process) {
            $io->error('Please write process type. [all, Provider1, Provider2]');

            return Command::FAILURE;
        }

        if ($process === 'all') {
            $this->all($io);
        } else {
            $this->provider($io, $process);
        }

        $io->success('Completed provider load');

        return Command::SUCCESS;
    }

    /**
     * @param $io
     * @return int
     * @throws \Exception
     */
    protected function all($io): int
    {
        $io->info('Start provider load');

        foreach (['Provider1', 'Provider2'] as $provider) {
            $this->provider($io, $provider);
        }

        $io->info('End provider load');

        return Command::FAILURE;
    }

    /**
     * @param $io
     * @param $provider
     * @return int
     * @throws \Exception
     */
    protected function provider($io, $provider): int
    {
        $io->info('Start: ' . $provider);

        $api = new ProviderFacede(new ProviderFactory($provider));

        foreach ($api->get() as $item) {

            $work = new Works();
            $work->setTitle($item->title);
            $work->setTime($item->time);
            $work->setLevel($item->level);
            $work->setCreatedAt(new \DateTime());
            $work->setUpdatedAt(new \DateTime());

            $this->entityManager->persist($work);
            $this->entityManager->flush();

            $io->info('Added: ' . $item->title);
        }

        $io->info('End: ' . $provider);

        return Command::FAILURE;
    }
}
