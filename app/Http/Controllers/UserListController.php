<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Ownership\EnsureUserOwnsList;
use App\Http\Requests\UserListRequest;
use App\Models\UserList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserListController extends Controller
{
    public function __construct()
    {
        $this->middleware($this->authMiddleware);
        $this->middleware(EnsureUserOwnsList::class)->only(['show','update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return UserList::where('user_id', Auth::id())->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserListRequest $request)
    {
        $validated = $request->validated();

        $validated['user_id'] = Auth::id();

        return UserList::create($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        return $request->get('list');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserListRequest $request)
    {
        $userList = $request->get('list');
        $userList->update($request->input());

        return response('', 204);
//        return response($userList, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $userList = $request->get('list');
        $userList->delete();

        return response('', 204);
    }
}
