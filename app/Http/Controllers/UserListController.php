<?php

namespace App\Http\Controllers;

use App\Http\Middleware\EnsureUserOwnsList;
use App\Http\Requests\UserListRequest;
use App\Models\UserList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserListController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
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
        return $request->get('user_list');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserListRequest $request)
    {
        $userList = $request->get('user_list');
        $userList->update($request->input());

        return response('', 204);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $userList = $request->get('user_list');
        $userList->delete();

        return response('', 204);
    }
}
