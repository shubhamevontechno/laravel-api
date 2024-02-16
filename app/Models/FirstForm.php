<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RegistrationProgress;

class FirstForm extends Model
{
    use HasFactory;
    protected $fillable = ['name','email'];

    protected static function booted(){
        static::created(function($firstForm){
            $firstForm->createRegistrationProgresses();
        });
    }

    public function registrationProgresses()
    {
        return $this->hasMany(RegistrationProcess::class);
    }

    public function createRegistrationProgresses()
    {
        $memberId = $this->member_id; // Assuming you have a member_id field in your form tables

        // Assuming you have 3 steps for registration
        for ($i = 1; $i <= 3; $i++) {
            $completed = ($i == 1); // Set completed to true for the first step, false for the rest
            $this->registrationProgresses()->create([
                'first_form_id' => $memberId,
                'step_number' => $i,
                'completed' => $completed,
            ]);
        }
    }
}
