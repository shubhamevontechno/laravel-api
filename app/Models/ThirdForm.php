<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThirdForm extends Model
{
    use HasFactory;

    public function firstForm(){
        return $this->belongsTo(FirstForm::class, 'first_form_id');
    }
}
