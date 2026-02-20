<?php

namespace App\Http\Livewire\KnowledgePanel;

use App\Models\Activity;
use App\Models\Resource;
use App\Models\ResourceCategory;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class KnowledgePanelCategory extends Component
{
    use AuthorizesRequests;
    
    // public $resourceCategory;
    public $searchString = '';
    public $postingUsers;
    public $catID;
    public $newTopic;
    public $showCreateTopicModal = false;
    public $filters = [
        'users' => [],
        'date-created' => '',
        'date-updated' => '',
    ];

    protected $rules = [
        'newTopic.title' => 'required',
        'newTopic.content' => 'required',
    ];

    public function mount($id)
    {
        $this->catID = $id;

        $this->postingUsers = 
            User::query()
                ->with('resources')
                ->withCount('resources')
                ->orderBy('resources_count', 'desc')
                ->limit(5)
                ->get();

        $this->newTopic = Resource::make();
    }

    public function render()
    {
        return view('livewire.knowledge-panel.knowledge-panel-category')
            ->layoutData([
                'backText' => 'all Categories'
            ]);
    }

    public function clearFilters()
    {
        $this->filters['users'] = [];
        $this->filters['date-created'] = '';
        $this->filters['date-updated'] = '';

        $this->emit('clear_flatpickr');
        $this->emit('clearSelect2');
    }

    public function getResourceCategoryProperty()
    {
        return ResourceCategory::query()
            ->where('id', $this->catID)
            ->with([
                'resources.user',
                'resources.comments',
                'resources' => function($query) {
                    $query
                        ->when($this->searchString, function($q) {
                            $q->where('resources.title', 'like', '%' . $this->searchString . '%');
                        })
                        ->when($this->filters['users'], function($query) {
                            $query->whereIn('user_id', $this->filters['users']);
                        })
                        ->when($this->filters['date-created'], function($query) {
                            $range = explode(' to ', $this->filters['date-created']);
                            if (count($range) === 1) {
                                $query->whereDate('created_at', $range[0]);    
                            } else {
                                $query
                                    ->whereDate('created_at', '>=', $range[0])
                                    ->whereDate('created_at', '<=', $range[1]);
                            }
                        })
                        ->when($this->filters['date-updated'], function($query) {
                            $range = explode(' to ', $this->filters['date-updated']);
                            if (count($range) === 1) {
                                $query->whereDate('updated_at', $range[0]);    
                            } else {
                                $query
                                    ->whereDate('updated_at', '>=', $range[0])
                                    ->whereDate('updated_at', '<=', $range[1]);
                            }
                        })
                        ->orderByDesc('resources.created_at');
                }
            ])
            ->first();
    }

    protected function generateInitials($name)
    {
        $words = explode(" ", $name);
        $initials = null;
        foreach ($words as $w) {
            $initials .= $w[0];
        }
        return $initials;
    }

    // public function newActivity($title, $body, $type)
    // {
    //     $activity = Activity::make();

    //     $activity->user_id = Auth::id();
    //     $activity->title = ' ' . $title;
    //     $activity->body = $body;
    //     $activity->activity_type = $type;
    //     $activity->path = 'Audits / ' . $this->audit->client->name . ' / ' . $this->audit->created_at->format('Y-m-d');
    //     $this->audit->activities()->save($activity);
    // }

    public function createTopic()
    {
        $this->authorize('create knowledge-panel');
        $this->validate();

        $this->newTopic->resource_category_id = $this->catID;
        $this->newTopic->user_id = Auth::id();
        $this->newTopic->save();

        $this->newTopic = Resource::make();
        $this->showCreateTopicModal = false;

        $this->dispatchBrowserEvent('notify-success', ['message' => 'Topic created successfully']);
    }
}
