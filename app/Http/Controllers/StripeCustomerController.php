<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\StripeUserService;
use Illuminate\Http\Request;

class StripeCustomerController extends Controller
{
    protected $stripeUserService;

    public function __construct(StripeUserService $stripeUserService)
    {
        $this->stripeUserService = $stripeUserService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(User $user)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $user)
    {
        $response = $this->stripeUserService->createUserInStripe($user);

        return is_string($response)
            ? response()->json(['message' => $response])
            : response()->json($response);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}