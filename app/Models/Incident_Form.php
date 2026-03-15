<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Incident_Form extends Model
{
    protected $table = 'incident_forms';

    protected $fillable = [
        'user_id',
        'reporter_name', 
        'zonal_id', 
        'category_id',   
        'importance',
        'description',
        'start_time',
        'first_report_time',
        'initial_etr',
        'resulation_time',
        'status',        
         'updated_by',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'initial_etr' => 'datetime',
        'first_report_time'=>'datetime',
    ];

    public function user() { return $this->belongsTo(User::class); }
    public function zonal() { return $this->belongsTo(Zonal::class); }
    public function category() { return $this->belongsTo(Category::class); }

     public function updater() 
    { 
        return $this->belongsTo(User::class, 'updated_by'); 
    }
}