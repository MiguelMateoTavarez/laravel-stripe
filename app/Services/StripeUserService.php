<?php

namespace App\Services;

use App\Models\User;
use Laravel\Cashier\Cashier;
use Stripe\Customer;
use Stripe\Stripe;

class StripeUserService
{

    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function createUserInStripe($request)
    {
        if (!$this->userExists($request)) {
            $user = User::create($request->all());
            return $user->createAsStripeCustomer();
        }

        return 'Customer already exists';
    }

    public function updateUserInStripe($request, $user)
    {
        $updatedUser = $user->updateStripeCustomer($request->all());
        $user->update($request->all());

        return $updatedUser;
    }

    private function userExists($request)
    {
        $verifyingCustomer = $this->findUserByEmail($request->email);

        return $verifyingCustomer->count() > 0 ? true : false;
    }

    public function findUserByEmail($email)
    {
        return Customer::all([
            'email' => $email,
            'limit' => 1,
        ]);
    }
}