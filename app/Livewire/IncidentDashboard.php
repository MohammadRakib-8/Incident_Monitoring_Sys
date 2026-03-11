<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Zonal;
use App\Models\Category;
use Livewire\Attributes\On;
use App\Models\Incident_Form;

class IncidentDashboard extends Component
{
    public string $currentStatusBtn = 'open';

    public $filterImportance = '';
    public $filterCategory = '';
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

    public function mount(){
        $this->currentStatusBtn = request('status', 'open');
        $this->filterImportance = request('importance', '');
        $this->filterCategory = request('category', '');
        $this->filterZone = request('zone', '');
    }

    protected $messages = [
        'editNotes.required_if' => 'Resolution notes are required when status is Resolved.',
        'editRt.required_if' => 'Resolution Time is required when status is Resolved.',
    ];

    public function setStatus($status)
    {
        $this->currentStatusBtn = $status;
        return redirect()->route('incidentdashboard', ['status' => $status]);
    }

    
    #[On('echo:incidents,.incident-created')] 
    public function handleBroadcastIncidentAdded($event)
    {
        // dd('Pusher Event Received Successfully!', $event); 
        session()->flash('status', 'New incident received via Pusher!');
        
      
        $this->refreshKey++;
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

            session()->flash('status', 'Incident Response updated successfully.');
            
            $this->refreshKey++;
        }

        $this->closeModal();
    }

    public function closeModal()
    {
        $this->showEditModal = false;
        $this->reset(['editId', 'editStatus', 'editEtr', 'editRt', 'editNotes']);
    }

    public function getFilteredIncidentsProperty()
    {
        $query = Incident_Form::query();

        if ($this->currentStatusBtn === 'open') {
            $query->whereIn('status', ['Open', 'InProgress']);
        } elseif ($this->currentStatusBtn === 'Resolved') {
            $query->where('status', 'Resolved');
        } elseif ($this->currentStatusBtn === 'Paused') {
            $query->where('status', 'Paused');
        }

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

        return $query->with(['zonal', 'category'])->latest()->get();
    }
    
    public function handleIncidentAdded()
    {
        $this->showAddModal = false;
        session()->flash('status', 'New incident added successfully!');
        
        $this->refreshKey++;
    }

    public function render()
    {
        $zonals = Zonal::all();
        $categories = Category::all();
        return view('livewire.incident-dashboard', compact('zonals', 'categories'));
    }
}