<?php

namespace App\Http\Controllers;

use App\Models\User;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show_user(int $userId)
    {
        $user = User::select('id', 'username', 'created_at', 'private')->find($userId);

        if (!$user) {
            throw new NotFoundHttpException(
                sprintf(
                    'User with id \'%s\' not found',
                    $userId,
                )
            );
        }

        return $user;
    }
}
