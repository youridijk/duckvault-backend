<?php

namespace App\Http\Controllers\Diary;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Ownership\EnsureUserOwnsDiaryEntry;
use App\Http\Requests\DiaryEntryRequest;
use App\Models\Diary\DiaryEntry;
use App\Models\Inducks\Issue;
use App\Models\Inducks\StoryVersion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DiaryEntryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->middleware(EnsureUserOwnsDiaryEntry::class)
            ->only(['show', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return DiaryEntry::with([
            'diaryEntryIssue.issue:issuecode,title',
            'diaryEntryStoryVersion:diary_entry_id,story_version_code',
            'diaryEntryStoryVersion.storyVersion:storyversioncode,storycode',
            'diaryEntryStoryVersion.storyVersion.story:storycode,title',
        ])
            ->where('user_id', Auth::id())
            ->get();
    }

    protected array $data = [
        'i' => [
            'model' => Issue::class,
            'table' => 'diary_entries_issues',
            'modelColumn' => 'issue_code',
        ],
        's' => [
            'model' => StoryVersion::class,
            'table' => 'diary_entries_story_versions',
            'modelColumn' => 'story_version_code',
        ],
    ];

    /**
     * Store a newly created resource in storage.
     */
    public function store(DiaryEntryRequest $request)
    {
        $validated = $request->validate(
            [
                ...$request->rules(),
                'story_version_code' => [
                    'prohibited_unless:issue_code,null',
                    'required_without:issue_code',
                ],
                'issue_code' => [
                    'prohibited_unless:story_version_code,null',
                    'required_without:story_version_code',
                ],
            ],
        );

        $validated['user_id'] = Auth::id();
        $relatedEntityType = '';

        if (isset($validated['issue_code'])) {
            $relatedEntityType = 'i';
        } else if (isset($validated['story_version_code'])) {
            $relatedEntityType = 's';
        }

        $validated['related_entity_type'] = $relatedEntityType;

        $data = $this->data[$relatedEntityType];
        $id = $validated[$data['modelColumn']];

        if (!$data['model']::find($id)) {
            throw new NotFoundHttpException(
                sprintf(
                    '%s with id \'%s\' couldn\'t be found',
                    $data['model'],
                    $id
                )
            );
        }

        $diaryEntry = DiaryEntry::create($validated);
        DB::table($data['table'])->insert([
            'diary_entry_id' => $diaryEntry->id,
            $data['modelColumn'] => $id
        ]);

        return $diaryEntry;
    }



    protected string $storeModel;
    protected string $storeTable;
    protected string $storeModelColumn;
    protected string $storeRelatedEntityType;

    public function store_v2(DiaryEntryRequest $request)
    {
        $validated = $request->validate(
            [
                ...$request->rules(),
                $this->storeModelColumn => 'required',
            ],
        );

        $validated['user_id'] = Auth::id();
        $validated['related_entity_type'] = $this->storeRelatedEntityType;

        $id = $validated[$this->storeModelColumn];

        if (!$this->storeModel::find($id)) {
            throw new NotFoundHttpException(
                sprintf(
                    '%s with id \'%s\' couldn\'t be found',
                    $this->storeModel,
                    $id
                )
            );
        }

        $diaryEntry = DiaryEntry::create($validated);
        DB::table($this->storeTable)->insert([
            'diary_entry_id' => $diaryEntry->id,
            $this->storeModelColumn => $id
        ]);

        return $diaryEntry;
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $diaryEntry = $request->get('diary_entry');

        return DiaryEntry::with([
            'diaryEntryIssue.issue:issuecode,title',
            'diaryEntryStoryVersion:diary_entry_id,story_version_code',
            'diaryEntryStoryVersion.storyVersion:storyversioncode,storycode',
            'diaryEntryStoryVersion.storyVersion.story:storycode,title',
//            'review' // todo add review
        ])
            ->get()
            ->find($diaryEntry->id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DiaryEntryRequest $request)
    {
        $diaryEntry = $request->get('diary_entry');
        $diaryEntry->update($request->input());

        return response('', 204);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $diaryEntry = $request->get('diary_entry');
        $diaryEntry->delete();

        return response('', 204);
    }
}
