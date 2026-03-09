<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Zonal;
use App\Models\Category;


class IncidentDashboard extends Component
{
    public string $currentStatusBtn = 'open';

    public $filterImportance = '';
    public $filterCategory = '';
    public $filterZone = '';

    public bool $showEditModal = false;
    public ?int $editId = null;
    public string $editStatus = '';
    public string $editEtr = '';
    public string $editNotes = '';
    public string $editRt = '';
    public bool $showAddModal=false;
  

    public $incidents = [];
protected $listeners = ['incident-added' => 'handleIncidentAdded'];



    public function mount()
    {
        // Dummy Data
        $this->incidents = [
            ['id' => 1001809, 'zone' => 'Dhaka North', 'category' => 'Logical', 'importance' => 'High', 'status' => 'Open', 'started' => '03/26/2026, 09:12 AM', 'etr' => '2026-03-26T13:45', 'rt' => null, 'reporter' => 'Rakib'],
            ['id' => 1001810, 'zone' => 'Chittagong', 'category' => 'Physical', 'importance' => 'High', 'status' => 'Resolved', 'started' => '03/25/2026, 06:55 PM', 'etr' => '2026-03-26T10:22', 'rt' => '03/26/2026, 08:03 AM', 'reporter' => 'Javed'],
            ['id' => 1001811, 'zone' => 'Sylhet', 'category' => 'Logical', 'importance' => 'Mid', 'status' => 'InProgress', 'started' => '03/26/2026, 11:03 AM', 'etr' => '2026-03-26T15:30', 'rt' => null, 'reporter' => 'Amina'],
            ['id' => 1001814, 'zone' => 'Dhaka South', 'category' => 'NTTN', 'importance' => 'Mid', 'status' => 'Paused', 'started' => '03/26/2026, 07:48 AM', 'etr' => '2026-03-26T14:17', 'rt' => null, 'reporter' => 'Rita'],
            ['id' => 1001813, 'zone' => 'Khulna', 'category' => 'IIG', 'importance' => 'Low', 'status' => 'Open', 'started' => '03/26/2026, 10:21 AM', 'etr' => '2026-03-26T17:02', 'rt' => null, 'reporter' => 'Kamal'],
            ['id' => 1001812, 'zone' => 'Rajshahi', 'category' => 'NTTN', 'importance' => 'High', 'status' => 'InProgress', 'started' => '03/26/2026, 11:27 AM', 'etr' => '2026-03-26T16:54', 'rt' => null, 'reporter' => 'Sagor'],
        ];
    }

    public function setStatus($status)
    {
        $this->currentStatusBtn = $status;
    }

    public function edit($id)
    {
        $incident = collect($this->incidents)->firstWhere('id', $id);

        if ($incident) {
            $this->editId = $id;
            $this->editStatus = $incident['status'];
            $this->editEtr = $incident['etr'];
            $this->editNotes = $incident['notes'] ?? '';
            
            if (!empty($incident['rt'])) {
                try {
                    $this->editRt = \Carbon\Carbon::parse($incident['rt'])->format('Y-m-d\TH:i');
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
        $key = collect($this->incidents)->search(fn($item) => $item['id'] === $this->editId);

        if ($key !== false) {
            $this->incidents[$key]['status'] = $this->editStatus;
            $this->incidents[$key]['etr'] = $this->editEtr;
            $this->incidents[$key]['notes'] = $this->editNotes;

            if ($this->editStatus === 'Resolved') {
                if ($this->editRt) {
                    $this->incidents[$key]['rt'] = \Carbon\Carbon::parse($this->editRt)->format('m/d/Y, h:i A');
                } else {
                    $this->incidents[$key]['rt'] = now()->format('m/d/Y, h:i A');
                }
            } else {
                $this->incidents[$key]['rt'] = null;
            }

            session()->flash('status', 'Incident Response updated successfully.');
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
        return collect($this->incidents)->filter(function ($incident) {
            $statusMatch = false;
            
            if ($this->currentStatusBtn === 'open') {
                $statusMatch = in_array($incident['status'], ['Open', 'InProgress']);
            } 
            elseif ($this->currentStatusBtn === 'Resolved') {
                $statusMatch = $incident['status'] === 'Resolved';
            } 
            elseif ($this->currentStatusBtn === 'Paused') {
                $statusMatch = $incident['status'] === 'Paused';
            }

            $importanceMatch = !$this->filterImportance || $incident['importance'] === $this->filterImportance;
            $categoryMatch = !$this->filterCategory || $incident['category'] === $this->filterCategory;
            $zoneMatch = !$this->filterZone || $incident['zone'] === $this->filterZone;

            return $statusMatch && $importanceMatch && $categoryMatch && $zoneMatch;
        });
    }


public function handleIncidentAdded()
{
    $this->showAddModal = false;
    session()->flash('status', 'New incident added successfully!');
    
}

    

    public function render()
    {
          $zonals = Zonal::all();
        $categories = Category::all();
        return view('livewire.incident-dashboard',compact('zonals','categories'));
        
    }
}