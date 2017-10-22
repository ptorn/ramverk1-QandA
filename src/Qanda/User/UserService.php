<?php

namespace Peto16\Qanda\User;

/**
 * Service class for user.
 */
class UserService
{


    public function filterDeleted($data)
    {
        return array_filter($data, function ($item) {
            return $item->deleted === null;
        });
    }
}
