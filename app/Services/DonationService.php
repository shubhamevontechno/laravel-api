<?php
namespace App\Services;
use App\Models\Donation;

class DonationService{
    public function processForm(array $formData){
        $donation = new Donation;
        $donation->amount = $formData['amount'];
        $donation->donation_date = $formData['donation_date'];
        $donation->payment_mode = $formData['payment_mode'];
        $donation->first_form_id = 1;
        $donation->category_name = $formData['category_name'];
        $donation->save();
        return true;
    }
}
?>
