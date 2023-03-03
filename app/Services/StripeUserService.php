<?php

namespace App\Services;

use App\Models\User;
use Stripe\Customer;
use Stripe\Stripe;

class StripeUserService
{

    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function createUserInStripe($data)
    {
        if(!$this->userExists($data)) {
            $user = User::create($data->all());
            return $user->createAsStripeCustomer();
        }

        return 'Customer already exists';
    }

    public function updateUserInStripe($data, $user)
    {
        if($this->userExists($data)) {
            $user->update($data->all());
            return $user->updateStripeCustomer($data->all());
        }

        return 'Customer already exists';
    }

    private function userExists($data)
    {
        $verifyingCustomer = Customer::all([
            'email' => $data->email,
            'limit' => 1,
        ]);

        return $verifyingCustomer->count() > 0 ? true : false;
    }
}