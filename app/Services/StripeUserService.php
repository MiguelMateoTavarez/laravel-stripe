<?php

namespace App\Services;

use Stripe\Customer;
use Stripe\Stripe;

class StripeUserService
{

    public function __construct()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
    }

    public function createUserInStripe($data)
    {
        if(!$this->userExists($data)) {
            $customer = Customer::create([
                'name' => $data->name,
                'email' => $data->email,
            ]);

            return $customer;
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