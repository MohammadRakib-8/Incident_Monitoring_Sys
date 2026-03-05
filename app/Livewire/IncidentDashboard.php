<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Incident;

class IncidentDashboard extends Component
{
    // You can keep the filter state here if you want to filter server-side
    // public $statusFilter = 'all'; 

    public function render()
    {
        $incidents = Incident::select('id', 'zonal_name', 'category_name', 'importance', 'status', 'start_time', 'etr', 'reporter_name')
            ->latest() 
            ->get()
            ->map(function($item) {
                return [
                    'id' => $item->id,
                    'zone' => $item->zonal_name,       
                    'category' => $item->category_name, 
                    'importance' => $item->importance,
                    'status' => $item->status,
                    'status_class' => strtolower(str_replace(' ', '', $item->status)),
                    'started' => $item->start_time?->diffForHumans() ?? 'N/A',
                    'etr' => $item->etr ? $item->etr->format('g:i A') : 'N/A',
                    'reporter' => $item->reporter_name,
                ];
            });

        return view('livewire.incident-dashboard', [
            'incidents' => $incidents
        ]);
    }
}