<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook;

class StripeWebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sig_header = $request->server('HTTP_STRIPE_SIGNATURE');
        $event = null;

        try {
            $event = Webhook::constructEvent(
                $payload, $sig_header, env('STRIPE_WEBHOOK_SECRET')
            );
        } catch (\UnexpectedValueException $e) {
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (SignatureVerificationException $e) {
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        switch ($event->type) {
            case 'customer.subscription.created':
                # Handle suscription created event
                break;
            
            case 'customer.subscription.updated':
                # Handle subscription updated event
                break;
        }

        return response()->json(['status' => 'success']);
    }
}
