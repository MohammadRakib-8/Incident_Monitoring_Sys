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

    public bool $showEditModal = false;
    public ?int $editId = null;
    public string $editStatus = '';
    public string $editEtr = '';
    public string $editNotes = '';
    public string $editRt = '';
    public bool $showAddModal = false;
  
    protected $listeners = ['incident-added' => 'handleIncidentAdded'];

    protected $rules = [
        'editStatus' => 'required',
        'editEtr' => 'required|date', 
        'editNotes' => 'required_if:editStatus,Resolved|string', 
        'editRt' => 'required_if:editStatus,Resolved', 
    ];

    public function mount()
    {
    }

    protected $messages = [
        'editNotes.required_if' => 'Resolution notes are required when status is Resolved.',
        'editRt.required_if' => 'Resolution Time is required when status is Resolved.',
    ];


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
        // $this->refreshKey++;
        $this->dispatch('$refresh');
    }

     #[On('echo:incidents,.incident-modified')] 
    public function handleBroadcastIncidentModified($event)
    {
        $this->dispatch('$refresh');
        // $this->refreshKey++;
    }

    public function edit($id)
    {
        $incident = Incident_Form::find($id);

        if ($incident) {
            $this->editId = $id;
            $this->editStatus = $incident->status;
            $this->editEtr = $incident->initial_etr ? \Carbon\Carbon::parse($incident->initial_etr)->format('Y-m-d\TH:i') : '';
            $this->editNotes = $incident->description ?? '';
            
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
            
            if($this->editEtr) {
                $incident->initial_etr = \Carbon\Carbon::parse($this->editEtr);
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
                                // $this->dispatch('incident-modified')->to(IncidentDashboard::class);    

            // $this->refreshKey++;
             $this->dispatch('$refresh');

        }

        $this->closeModal();
    }

    public function closeModal()
    {
        $this->showEditModal = false;
        $this->reset(['editId', 'editStatus', 'editEtr', 'editRt', 'editNotes']);
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
        
        // $this->refreshKey++;
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