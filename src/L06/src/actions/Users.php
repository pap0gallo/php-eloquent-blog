<?php

namespace App\actions;

use App\Models\User;

class Users
{
    public static function create(array $params): User
    {
        // BEGIN (write your solution here)
        $user = new User($params);
        $user->password = password_hash($params['password'], PASSWORD_DEFAULT) ?? null;
        $user->save();
        return $user;
        // END
    }

    public static function update(int $id, array $params): User
    {
        // BEGIN (write your solution here)
        $user = User::findOrFail($id);
        $user->update($params);
        $user->password = password_hash($params['password'], PASSWORD_DEFAULT) ?? null;
        $user->save();
        return $user;
        // END
    }
}
