<?php

namespace App\Repositories\Auth;

use App\Contracts\Repository\AbstractRepository;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Builder;

class AuthRepository extends AbstractRepository
{
    public function __construct()
    {
        $this->setModel(User::class);
    }

    public function login($authLoginRequest): Model|Builder|null
    {
        return $this->getModel()::where('email', $authLoginRequest['email'])->first();
    }

}
