<?php

namespace App\Http\Controllers;

use App\Models\Inducks\Issue;
use App\Models\OwnedIssue;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class OwnedIssuesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->show_of_user(Auth::id());
    }

    public function show_of_user(int $userId)
    {
        $user = User::find($userId);

        if (!$user) {
            throw new NotFoundHttpException(
                sprintf(
                    'User with id \'%s\' not found',
                    $userId,
                )
            );
        }

        if ($user->private && $userId !== Auth::id()) {
            throw new BadRequestHttpException('User has private account');
        }

        return OwnedIssue::with('issue:issuecode,title')
            ->where('user_id', '=', $userId)
            ->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(string $issueCode)
    {
        if (!Issue::find($issueCode)) {
            throw new NotFoundHttpException(
                sprintf(
                    'Issue with issue code \'%s\' not found',
                    $issueCode,
                )
            );
        }

        $exisingOwnedIssue = OwnedIssue::find($issueCode, Auth::id());

        if ($exisingOwnedIssue) {
            throw new BadRequestHttpException(
                sprintf(
                    'Issue with code issue code \'%s\' already added',
                    $issueCode,
                )
            );
        }

        return OwnedIssue::create([
            'issue_code' => $issueCode,
            'user_id' => Auth::id(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $issueCode)
    {
        $deleted = OwnedIssue::where('issue_code', '=', $issueCode)
            ->where('user_id', '=', Auth::id())
            ->delete();

        if (!$deleted) {
            throw new NotFoundHttpException(
                sprintf(
                    'Issue with issue code \'%s\' not found in owned issues',
                    $issueCode,
                )
            );
        }

        return response('', 204);
    }
}
