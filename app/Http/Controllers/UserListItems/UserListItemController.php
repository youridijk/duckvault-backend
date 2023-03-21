<?php

namespace App\Http\Controllers\UserListItems;

use App\Http\Controllers\Controller;
use App\Http\Middleware\EnsureUserOwnsList;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

abstract class UserListItemController extends Controller
{
    protected string $shortClassName;

    protected string $itemModel;

    protected string $relationKey;

    protected string $itemModelKey;

    public function __construct()
    {
        $this->middleware('auth:api');
        $this->middleware(EnsureUserOwnsList::class);
    }

    public function getAll(int $listId)
    {
        return $this->itemModel::whereHas('lists', function (Builder $query) use ($listId) {
            return $query->where('user_list_id', $listId);
        })->get();
    }

    public function add(Request $request, int $listId, string $userListItemId)
    {
        try {
            $this->itemModel::findOrFail($userListItemId);
            $userList = $request->get('user_list');

            $items = call_user_func(array($userList, $this->relationKey));
            $itemAlreadyAdded = $items->find($userListItemId);

            if ($itemAlreadyAdded) {
                throw new BadRequestHttpException(
                    sprintf(
                        '%s with id \'%s\' already added to list with id %s',
                        $this->shortClassName,
                        $userListItemId,
                        $listId
                    )
                );
            }

            $items->attach($userListItemId);

            return response('', 201);
        } catch (ModelNotFoundException) {
            throw new NotFoundHttpException(
                sprintf(
                    '%s with id \'%s\' couldn\'t be found',
                    $this->shortClassName,
                    $userListItemId
                )
            );
        }
    }

    public function delete(Request $request, int $listId, string $userListItemId): Response
    {
        $userList = $request->get('user_list');
        $items = call_user_func(array($userList, $this->relationKey));
        $numberOfDeletedRows = $items->detach($userListItemId);

        if ($numberOfDeletedRows) {
            return response('', 204);
        } else {
            throw new NotFoundHttpException(
                sprintf(
                    '%s with id \'%s\' couldn\'t be found on list with id %s',
                    $this->shortClassName,
                    $userListItemId,
                    $listId
                )
            );
        }
    }
}
