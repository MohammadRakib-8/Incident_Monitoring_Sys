<?php

namespace App\Livewire;

use App\Models\Incident;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class IncidentForm extends Component
{
    public $reporter_name = ''; 
    public $zonal_name = '';
    public $category = '';
    public $importance = 'High';
    public $description = '';
    public $start_time; 
    public $initial_etr;

    protected $rules = [
        'reporter_name' => 'required|min:3', 
        'zonal_name' => 'required',
        'category' => 'required',
        'importance' => 'required',
        'description' => 'required|min:5',
        'start_time' => 'required|date', 
        'initial_etr' => 'required|date',
    ];

    public function submit()
    {
        $this->validate();

        Incident::create([
            'user_id' => Auth::id(), 
            'reporter_name' => Auth::check() ? Auth::user()->name : $this->reporter_name,
            'zonal_name' => $this->zonal_name,
            'category' => $this->category,
            'importance' => $this->importance,
            'description' => $this->description,
            'start_time' => $this->start_time, 
            'initial_etr' => $this->initial_etr,
            'status' => 'Open',
        ]);

        session()->flash('message', 'Incident successfully logged.');
        
        
        $this->reset(['reporter_name', 'zonal_name', 'category', 'description', 'start_time', 'initial_etr']);
        $this->importance = 'High';
    }

    public function render()
    {
        return view('livewire.incident-form');
    }
}