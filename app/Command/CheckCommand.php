<?php declare(strict_types=1);
namespace App\Command;

use App\Task\CheckTask;
use Hyperf\Command\Annotation\Command;
use Hyperf\Command\Command as HyperfCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Hyperf\Di\Annotation\Inject;

#[Command]
class CheckCommand extends HyperfCommand
{
    #[Inject]
    protected CheckTask $checkTask;

    public function __construct()
    {
        parent::__construct('check:run');
        $this->setDescription('运行巡检(CheckTask)');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->checkTask->execute();
        $output->writeln('check done.');
        return 0;
    }
}
