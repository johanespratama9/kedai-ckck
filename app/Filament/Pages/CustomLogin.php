<?php
namespace App\Filament\Pages;

use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Filament\Pages\Auth\Login;
use Illuminate\Validation\ValidationException;

class CustomLogin extends Login
{
    public function authenticate(): ?LoginResponse
    {
        try {
            return parent::authenticate();
        } catch (ValidationException $exception) {
            // Get form credentials
            $credentials = [
                'email'    => $this->form->getState()['email'],
                'password' => $this->form->getState()['password'],
            ];

            // Find user by email
            $user = \App\Models\User::where('email', $credentials['email'])->first();

            // Check if user exists and password is incorrect
            if ($user && ! password_verify($credentials['password'], $user->password)) {
                throw ValidationException::withMessages([
                    'data.password' => 'Password salah. Silakan coba lagi.',
                ]);
            }

            // Re-throw the original exception if it's not a password error
            throw $exception;
        }
    }
}

