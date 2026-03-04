<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use App/Forms/IncidentForm;
// use App/Models/Incident_Form;

class Category extends Model
{
    //
    protected $fillable=['name'];

    public function incidents() {
        return $this->hasMany(Incident_Form::class);
    }
}
