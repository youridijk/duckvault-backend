<?php

namespace App\Http\Controllers;

use App\Models\Inducks\Issue;
use App\Models\OwnedIssue;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Database\Eloquent\Collection;

class OwnedIssuesController extends Controller
{

    public function __construct()
    {
        $this->middleware($this->authMiddleware)->except('show_of_user');
    }

    private function get_private_collection_of_user(int $userId, bool $compact)
    {
        if ($compact) {
            /** @var Collection $ownedIssues */
            $ownedIssues = OwnedIssue::where('user_id', '=', $userId)
                ->select(['issue_code', 'created_at'])
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();

            return response()->json([
                'issues' => $ownedIssues,
                'summary' => $ownedIssues->implode('issue_code', ','),
            ]);
        } else {
            return OwnedIssue::with('issue:issuecode,title')
                ->where('user_id', '=', $userId)
                ->orderBy('created_at', 'desc')
                ->get();
        }
    }

    /**
     * Display the private collection of current user
     */
    public function index(Request $request)
    {
        $compact = $request->query('compact') === '1';
        return $this->get_private_collection_of_user(Auth::id(), $compact);
    }

    public function show_of_user(Request $request, int $userId)
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

        if ($user->private) {
            throw new UnauthorizedException('User has private account');
        }

        $compact = $request->query('compact') === '1';
        return $this->get_private_collection_of_user($userId, $compact);
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
