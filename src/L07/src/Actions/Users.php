<?php

namespace App\Actions;

use Illuminate\Support\Collection;
use App\Models\User;

class Users
{
    public static function index($params = []): Collection
    {
        // BEGIN (write your solution here)
        $scope = User::query();

        if (isset($params['q'])) {
            $conditions = $params['q'];
            $scope->orWhere($conditions);
        }
        if (isset($params['s'])) {
            [$fieldName, $direction] = explode(':', $params['s']);
            $scope->orderBy($fieldName, $direction);
        }
        return $scope->get();
        // END
    }
}
