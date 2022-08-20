<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'mobile' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
        ],
        [
            'first_name.required'=>'برجاء إدخال الاسم الأول',
            'last_name.required'=>'برجاء إدخال الاسم الأخير',
            'mobile.required'=>'برجاء إدخال رقم التليفون',
            'email.required'=>'برجاء إدخال البريد الاليكتروني',
            'password.required'=>'برجاء إدخال كلمة المرور',
            'email.unique'=>'البريد الاليكتروني مسجل من قبل',
            'mobile.unique'=>'رقم التليفون مسجل من قبل',
        ]
        
        )->validate();

        return User::create([
            'name' => $input['first_name'].' '.$input['last_name'],
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            'mobile' => $input['mobile'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
