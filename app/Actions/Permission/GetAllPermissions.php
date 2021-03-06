<?php

declare(strict_types=1);

namespace App\Actions\Permission;

use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsAction;
use Spatie\Permission\Models\Permission;

class GetAllPermissions
{
    use AsAction;

    public function handle(): Collection
    {
        return Permission::orderBy('category')->get();
    }
}
