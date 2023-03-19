<?php

namespace App\Http\Controllers\UserListItems;

use App\Http\Controllers\Controller;
use App\Http\Middleware\EnsureUserOwnsList;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use ReflectionClass;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

abstract class UserListItemController extends Controller
{
    protected string $shortClassName;

    public function __construct(
        protected string $itemModel,
        protected string $userListItemModel,
        protected string $itemModelKey,
    )
    {
        $this->middleware('auth:api');
        $this->middleware(EnsureUserOwnsList::class);
        $this->shortClassName = (new ReflectionClass($this->itemModel))->getShortName();
    }

    public function add(int $listId, string $userListItemId)
    {
        try {
            $this->itemModel::findOrFail($userListItemId);

            $itemAlreadyAdded =  !!$this->userListItemModel::where([
                'user_list_id' => $listId,
                $this->itemModelKey => $userListItemId,
            ])->count();

            if ($itemAlreadyAdded) {
                throw new BadRequestHttpException($this->shortClassName . ' with id \'' . $userListItemId . '\' already added to list with id ' . $listId);
            }

            $this->userListItemModel::create([
                'user_list_id' => $listId,
                $this->itemModelKey => $userListItemId
            ]);

            return response('', 201);
        } catch (ModelNotFoundException) {
            throw new NotFoundHttpException($this->shortClassName . ' with id \'' . $userListItemId . '\' couldn\'t be found');
        }
    }

    public function delete(int $listId, string $userListItemId): Response
    {
        $numberOfDeletedRows = $this->userListItemModel::where([
            'user_list_id' => $listId,
            $this->itemModelKey => $userListItemId,
        ])->delete();

        if ($numberOfDeletedRows) {
            return response('', 204);
        } else {
            throw new NotFoundHttpException($this->shortClassName . ' with id \'' . $userListItemId . '\' couldn\'t be found on list with id ' . $listId);
        }
    }
}
