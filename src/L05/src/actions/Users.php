<?php

namespace App\actions;

use App\Models\User;
use Illuminate\Support\Collection;

class Users
{
    public static function index(): Collection
    {
        // BEGIN (write your solution here)
        return User::all();
        // END
    }

    public static function create(array $params): User
    {
        // BEGIN (write your solution here)
        $user = new User();
        $user->first_name = $params['first_name'] ?? null;
        $user->last_name = $params['last_name'] ?? null;
        $user->email = $params['email'] ?? null;
        $user->password = password_hash($params['password'], PASSWORD_DEFAULT) ?? null;
        $user->save();
        return $user;
        // END
    }

    public static function update(int $id, array $params): User
    {
        // BEGIN (write your solution here)
        $user = User::findOrFail($id);
        if (isset($params['first_name'])) {
            $user->first_name = $params['first_name'];
        };
        if (isset($params['last_name'])) {
            $user->last_name = $params['last_name'];
        };
        if (isset($params['email'])) {
            $user->email = $params['email'];
        };
        if (isset($params['password'])) {
            $user->password = password_hash($params['password'], PASSWORD_DEFAULT);
        };
        $user->save();
        return $user;
        // END
    }

    public static function delete(int $id): bool
    {
        // BEGIN (write your solution here)
        if ($user = User::find($id)) {
            return $user->delete();
        }
        return false;
        // END
    }
}
