<?php
namespace App\Services;
use App\Models\SecondForm;
use App\Models\RegistrationProcess;
use Illuminate\Support\Facades\Validator;

class SecondFormService{

    public function validateFormData(array $formData) {
        return Validator::make($formData, [
            'first_form_id' => 'required|unique:second_forms',
            'dob' => 'required',
            'phone' => 'required',
        ], [
            'first_form_id.unique' => 'Duplicate entry is not allowed for the same user.',
        ])->validate();
    }

    public function processForm(array $formData){
        $second_form = new SecondForm;
        $second_form->first_form_id = $formData['first_form_id'];
        $second_form->dob = $formData['dob'];
        $second_form->phone = $formData['phone'];
        $saved_data = $second_form->save();

        $memberId = $formData['first_form_id'];
        $stepNumber = 2;
        $RegistrationProcess = RegistrationProcess::where('first_form_id', $memberId)
            ->where('step_number', $stepNumber)
            ->first();
        if ($RegistrationProcess) {
            $RegistrationProcess->update(['completed' => true]);
        }
        return $memberId;
    }
}
?>
