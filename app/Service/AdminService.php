<?php
declare(strict_types=1);

namespace App\Service;

use App\Model\Admin;

class AdminService
{
    public function findByUser(string $user): ?Admin
    {
        return Admin::query()->where('user', $user)->first();
    }
}
