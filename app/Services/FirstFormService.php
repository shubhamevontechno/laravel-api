<?php
namespace App\Services;
use App\Models\FirstForm;

class FirstFormService{

    public function processForm(array $formData){
        $firstForm = new FirstForm;
        $firstForm->name = $formData['name'];
        $firstForm->email = $formData['email'];
        $firstForm->save();
        return $firstForm->id;
    }
}

?>
