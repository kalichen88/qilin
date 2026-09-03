<?php
declare(strict_types=1);

namespace App\Common;

use Hyperf\Di\Annotation\Inject;
use Hyperf\View\RenderInterface;

abstract class ViewAbstractController extends AbstractController
{
    #[Inject]
    protected RenderInterface $view;
}
