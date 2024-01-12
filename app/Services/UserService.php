<?php
namespace App\Services;
use App\Models\User;

class UserService
{
    public function registerUser($data)
    {
        $existingUser = User::where('email', $data['email'])->first();

        if ($existingUser) {
              throw new \Exception('Email already exists.');
          }

        return User::create($data);
    }
}
?>
