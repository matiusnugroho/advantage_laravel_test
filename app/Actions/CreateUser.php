<?php

namespace App\Actions;
use Inertia\Inertia;

use Lorisleiva\Actions\Concerns\AsAction;

class CreateUser
{
    use AsAction;

    public function handle()
    {
        return Inertia::render('Auth/Register');
    }
}
