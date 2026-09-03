<?php
declare(strict_types=1);

namespace App\Controller\Manager;

use App\Common\AbstractController;
use App\Service\CrudService;

abstract class BaseCrudController extends AbstractController
{
    abstract protected function model(): string;

    protected array $searchable = [];

    protected array $fields = [];

    protected function q_page(): array
    {
        return CrudService::list($this->model(), $this->request, $this->searchable);
    }

    protected function q_single(int $id): mixed
    {
        return CrudService::single($this->model(), $id);
    }

    protected function q_save(?int $id): mixed
    {
        return CrudService::save($this->model(), $id, $this->fields, $this->request);
    }

    protected function q_delete(int $id): bool
    {
        return CrudService::delete($this->model(), $id);
    }

    protected function q_deletes(): int
    {
        return CrudService::deletes($this->model(), $this->request);
    }
}
