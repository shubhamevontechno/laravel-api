<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FirstForm;

class RegistrationProcess extends Model
{
    use HasFactory;
    protected $fillable = ['first_form_id','step_number','completed'];

    public function firstForm()
    {
        return $this->belongsTo(FirstForm::class);
    }
}
