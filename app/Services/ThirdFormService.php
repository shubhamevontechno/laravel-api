<?php
namespace App\Services;
use App\Models\ThirdForm;
use App\Models\RegistrationProcess;
use Illuminate\Support\Facades\Validator;

class ThirdFormService{

    public function validateFormData(array $formData) {
        return Validator::make($formData, [
            'first_form_id' => 'required|unique:third_forms',
            'qualification' => 'required',
            'place' => 'required',
            'image' => 'required',
        ], [
            'first_form_id.unique' => 'Duplicate entry is not allowed for the same user.',
        ])->validate();
    }

    public function processForm(array $formData){
        $third_form = new ThirdForm;
        $third_form->first_form_id = $formData['first_form_id'];
        $third_form->qualification = $formData['qualification'];
        $third_form->place = $formData['place'];
        $third_form->image = $formData['image'];
        $saved_data = $third_form->save();

        $memberId = $formData['first_form_id'];
        $stepNumber = 3;
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
