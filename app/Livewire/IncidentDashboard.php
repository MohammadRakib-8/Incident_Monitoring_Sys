<?php
namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\Attributes\On;
use App\Models\Zonal;
use App\Models\Category;
use App\Models\Incident_Form;
use App\Events\IncidentModified;

class IncidentDashboard extends Component
{
    #[Url(as: 'status')] 
    public string $currentStatusBtn = 'open';

    #[Url]
    public $filterImportance = '';

    #[Url]
    public $filterCategory = '';

    #[Url]
    public $filterZone = '';
    
    public int $refreshKey = 0;

           //Add modal
    public bool $showEditModal = false;
    public ?int $editId = null;
    public string $editStatus = '';
    public string $editEtr = '';
    public string $editNotes = '';
    public string $editRt = '';
    public bool $showAddModal = false;
    public string $editStartTime = '';
    public string $editReportTime = '';
    
    // Edit Form Properties
    public $selectedZonal = '';        
    public $selectedCategory = '';     
    public $importance = 'High';

//view modal
    public $reporter_name = '';
    public bool $showViewModal = false;
    public $viewId = null;
    public $viewStatus = '';
    public $viewZonalName = '';
    public $viewCategoryName = '';
    public $viewImportance = '';
    public $viewStartTime = '';
    public $viewReportTime = '';
    public $viewEtr = '';
    public $viewRt = '';
    public $viewNotes = '';
    public string $editUpdatedByName = '';

    protected $listeners = ['incident-added' => 'handleIncidentAdded',
    'view' => 'view'];

    protected $rules = [
        'selectedZonal' => 'required',
        'selectedCategory' => 'required',
        'importance' => 'required',
        'editStatus' => 'required',
        'editEtr' => 'required|date|after_or_equal:editReportTime', 
        'editNotes' => 'required_if:editStatus,Resolved|string', 
        'editRt' => 'required_if:editStatus,Resolved|after_or_equal:editReportTime', 
        'editStartTime'=>'required|date',
        'editReportTime'=>'required|date|after_or_equal:editStartTime',
    ];

    protected $messages = [
        'editNotes.required_if' => 'Resolution notes are required when status is Resolved.',
        'editRt.required_if' => 'Resolution Time is required when status is Resolved.',
    ];


    public function mount()
    {
        //
    }

    public function setStatus($status)
    {
        $this->currentStatusBtn = $status;
        $this->filterImportance = '';
        $this->filterCategory = '';
        $this->filterZone = '';
    }

    #[On('echo:incidents,.incident-created')] 
    public function handleBroadcastIncidentAdded($event)
    {
        $this->dispatch('$refresh');
    }

     #[On('echo:incidents,.incident-modified')] 
    public function handleBroadcastIncidentModified($event)
    {
        $this->dispatch('$refresh');
    }

   
    public function edit($id)
    {
        $incident = Incident_Form::find($id);

        if ($incident) {
            $this->editId = $id;
            $this->editStatus = $incident->status;
            $this->editEtr = $incident->initial_etr ? \Carbon\Carbon::parse($incident->initial_etr)->format('Y-m-d\TH:i') : '';
            $this->editNotes = $incident->description ?? '';
            $this->editStartTime = $incident->start_time ? \Carbon\Carbon::parse($incident->start_time)->format('Y-m-d\TH:i') : '';
            $this->editReportTime = $incident->first_report_time ? \Carbon\Carbon::parse($incident->first_report_time)->format('Y-m-d\TH:i') : '';
            
            $this->selectedZonal = $incident->zonal_id;
            $this->selectedCategory = $incident->category_id;
            $this->importance = $incident->importance;
            
            if ($incident->updated_by && $incident->updater) {
            $this->editUpdatedByName = $incident->updater->name;
        } elseif ($incident->user) {
            $this->editUpdatedByName = $incident->user->name . ' (Creator)';
        } else {
            $this->editUpdatedByName = 'N/A';
        }

            if (!empty($incident->resulation_time)) {
                try {
                    $this->editRt = \Carbon\Carbon::parse($incident->resulation_time)->format('Y-m-d\TH:i');
                } catch (\Exception $e) {
                    $this->editRt = ''; 
                }
            } else {
                $this->editRt = '';
            }

            $this->showEditModal = true;
        }
    }

    public function update()
    {   
        $this->validate();
        $incident = Incident_Form::find($this->editId);

        if ($incident) {
            $incident->status = $this->editStatus;
            $incident->updated_by=auth()->id();
            
            $incident->zonal_id = $this->selectedZonal;
            $incident->category_id = $this->selectedCategory;
            $incident->importance = $this->importance;
            
            if($this->editEtr) {
                $incident->initial_etr = \Carbon\Carbon::parse($this->editEtr);
            }
            if($this->editStartTime) {
                $incident->start_time = \Carbon\Carbon::parse($this->editStartTime);
            }
            if($this->editReportTime) {
                $incident->first_report_time = \Carbon\Carbon::parse($this->editReportTime);
            }
            
            $incident->description = $this->editNotes;

            if ($this->editStatus === 'Resolved') {
                if ($this->editRt) {
                    $incident->resulation_time = \Carbon\Carbon::parse($this->editRt);
                } else {
                    $incident->resulation_time = now();
                }
            } else {
                $incident->resulation_time = null;
            }

            $incident->save();

            IncidentModified::dispatch($incident);

            session()->flash('status', 'Incident Response updated successfully.');
            $this->dispatch('$refresh');
        }

        $this->closeModal();
    }

    public function closeModal()
    {
        $this->showEditModal = false;
        $this->resetErrorBag();
        $this->reset([
            'editId', 'editStatus', 'editStartTime', 'editReportTime', 
            'editEtr', 'editRt', 'selectedZonal', 'selectedCategory', 
            'importance', 'editNotes'
        ]);
    }

    private function buildBaseQuery()
    {
        $query = Incident_Form::query();

        if (!empty($this->filterImportance)) {
            $query->where('importance', $this->filterImportance);
        }

        if (!empty($this->filterCategory)) {
            $query->whereHas('category', function($q) {
                $q->where('name', $this->filterCategory);
            });
        }

        if (!empty($this->filterZone)) {
            $query->whereHas('zonal', function($q) {
                $q->where('name', $this->filterZone);
            });
        }

        return $query;
    }
    
    public function handleIncidentAdded()
    {
        $this->showAddModal = false;
        session()->flash('status', 'New incident added successfully!');
    }


 public function view($id)
    {
        $incident = Incident_Form::with(['zonal', 'category'])->find($id);

        if ($incident) {
            $this->viewId = $incident->id;
            $this->viewStatus = $incident->status;
            $this->viewZonalName = $incident->zonal->name ?? 'N/A';
            $this->viewCategoryName = $incident->category->name ?? 'N/A';
            $this->viewImportance = $incident->importance;
            $this->viewStartTime = $incident->start_time ? \Carbon\Carbon::parse($incident->start_time)->format('M/d/Y, h:i A') : 'N/A';
            $this->viewReportTime = $incident->first_report_time ? \Carbon\Carbon::parse($incident->first_report_time)->format('M/d/Y, h:i A') : 'N/A';
            $this->viewEtr = $incident->initial_etr ? \Carbon\Carbon::parse($incident->initial_etr)->format('M/d/Y, h:i A') : 'N/A';
            $this->viewRt = $incident->resulation_time ? \Carbon\Carbon::parse($incident->resulation_time)->format('M/d/Y, h:i A') : 'N/A';
            $this->viewNotes = $incident->description ?? 'No notes provided.';
            $this->reporter_name=$incident->reporter_name;
            $this->showViewModal = true;
        }
    }

      public function closeViewModal()
    {
        $this->showViewModal = false;
        $this->reset([
            'viewId', 'viewStatus', 'viewZonalName', 'viewCategoryName', 
            'viewImportance', 'viewStartTime', 'viewReportTime', 'viewEtr', 
            'viewRt', 'viewNotes'
        ]);
    }



    public function render()
    {
        $allIncidents = $this->buildBaseQuery()
            ->with(['zonal', 'category'])
            ->latest()
            ->get();

        $openIncidents = $allIncidents->filter(fn($i) => in_array($i->status, ['Open', 'InProgress']));
        $resolvedIncidents = $allIncidents->filter(fn($i) => $i->status === 'Resolved');
        $pausedIncidents = $allIncidents->filter(fn($i) => $i->status === 'Paused');

        $zonals = Zonal::all();
        $categories = Category::all();

        return view('livewire.incident-dashboard', compact(
            'openIncidents', 'resolvedIncidents', 'pausedIncidents',
            'zonals', 'categories'
        ));
    }
}