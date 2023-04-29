<?php

namespace App\View\Components;

use App\Models\Diary\DiaryEntry as DiaryEntryModel;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Http;
use Illuminate\View\Component;

class DiaryEntry extends Component
{
    protected string $baseUrl = 'http://localhost:3000';

    protected array $imageEndpoints = [
        's' => '/rpc/get_story_image_urls',
        'i' => '/rpc/get_issue_image_urls'
    ];

    protected string $type;
    protected ?array $imageUrls = null;

    /**
     * Create a new component instance.
     */
    public function __construct(
        protected DiaryEntryModel $diaryEntry
    )
    {
        $this->type = $diaryEntry->related_entity_type;
    }


    public function getImageUrls(): array
    {
        if ($this->imageUrls == null) {

            $body = match ($this->type) {
                'i' => [
                    'issue_code' => $this->diaryEntry['diaryEntryIssue']['issue_code'] . 'a'
                ],
                's' => [
                    'story_code' => $this->diaryEntry['diaryEntryStoryVersion']['storyVersion']['story']['storycode']
                ]
            };

            $response = Http::post(
                $this->baseUrl . $this->imageEndpoints[$this->type],
               $body
            );


            $responseJson = $response->json();

            if (array_is_list($responseJson)) {
                $this->imageUrls = $responseJson;
            } else {
                $this->imageUrls = [];
                echo $response->body();
            }
        }

        return $this->imageUrls;
    }

    public function getTitle(): string
    {
        return match ($this->type) {
            'i' => $this->diaryEntry['diaryEntryIssue']['issue']['title'],
            's' => $this->diaryEntry['diaryEntryStoryVersion']['storyVersion']['story']['title'],
            default => '',
        };
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view(
            'components.diary-entry',
            [
                'diaryEntry' => $this->diaryEntry,
                'title' => $this->getTitle(),
                'imageUrls' => $this->getImageUrls(),
            ]
        );
    }
}
