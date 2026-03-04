<?php

namespace App\Livewire;

use App\Models\Incident_Form;
use App\Models\Zonal;
use App\Models\Category;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class IncidentForm extends Component
{
    public $reporter_name = '';
    public $zonal = '';        
    public $category = '';     
    public $importance = 'High';
    public $description = '';
    public $start_time;
    public $initial_etr;

    protected $rules = [
        'zonal' => 'required',
        'category' => 'required',
        'importance' => 'required',
        'description' => 'required|min:5',
        'start_time' => 'required',
        'initial_etr' => 'required',
    ];

    public function submit()
    {
        $this->validate();

        $zonalModel = Zonal::where('name', $this->zonal)->first();
        $categoryModel = Category::where('name', $this->category)->first();

        if (!$zonalModel || !$categoryModel) {
            session()->flash('error', 'Invalid Zonal or Category selected.');
            return;
        }

        Incident_Form::create([
            'user_id'       => Auth::id(),
            'reporter_name' => Auth::check() ? Auth::user()->name : $this->reporter_name,
            'zonal_id'      => $zonalModel->id,      
            'category_id'   => $categoryModel->id,   
            'importance'    => $this->importance,
            'description'   => $this->description,
            'start_time'    => $this->start_time,
            'initial_etr'   => $this->initial_etr,
            'status'        => 'Open',
        ]);

        session()->flash('message', 'Incident successfully logged.');
        
        $this->reset(['reporter_name', 'zonal', 'category', 'description', 'start_time', 'initial_etr']);
        $this->importance = 'High';
    }

    public function render()
    {
        $zonals = Zonal::all();
        $categories = Category::all();

        return view('livewire.incident-form', compact('zonals', 'categories'));
    }
}