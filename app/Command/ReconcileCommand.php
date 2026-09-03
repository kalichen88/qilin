<?php declare(strict_types=1);
namespace App\Command;

use App\Payment\PaymentReconcileService;
use Hyperf\Command\Annotation\Command;
use Hyperf\Command\Command as HyperfCommand;
use Hyperf\Di\Annotation\Inject;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[Command]
class ReconcileCommand extends HyperfCommand
{
    #[Inject]
    protected PaymentReconcileService $reconcile;

    public function __construct()
    {
        parent::__construct('pay:reconcile');
        $this->setDescription('支付对账(settle 超时待付单)');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $result = $this->reconcile->run();
        $output->writeln(json_encode($result));
        return 0;
    }
}
