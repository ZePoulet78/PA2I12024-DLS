<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function createDonation(Request $request)
    {
        $donation = Donation::create([
            'amount' => $request->input('amount'),
        ]);

        $donation->createAsStripeCustomer();

        $checkout_session = $donation->checkout([
            'success_url' => route('donations.success', [], true),
            'cancel_url' => route('donations.cancel', [], true),
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => [
                            'name' => 'Don',
                        ],
                        'unit_amount' => $request->input('amount') * 100, // Montant en centimes
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
        ]);

        return response()->json(['sessionId' => $checkout_session->id]);
    }

    public function handleSuccessfulDonation(Request $request)
{
    $payload = $request->getContent();
    $sig_header = $request->server('HTTP_STRIPE_SIGNATURE');
    $event = null;

    try {
        $event = \Stripe\Webhook::constructEvent(
            $payload, $sig_header, env('STRIPE_WEBHOOK_SECRET')
        );
    } catch (\UnexpectedValueException $e) {
        return response()->json(['error' => $e->getMessage()], 400);
    } catch (SignatureVerificationException $e) {
        return response()->json(['error' => $e->getMessage()], 400);
    }

    switch ($event->type) {
        case 'checkout.session.completed':
            $session = $event->data->object;
            $donationId = $session->metadata->donation_id;
            $donation = Donation::find($donationId);

            if ($donation) {
                $donation->status = 'paid';
                $donation->save();

                return response()->json(['message' => 'Don effectué avec succès'], 200);
            }
            break;
        default:
            return response()->json(['message' => 'Événement Stripe non géré'], 400);
    }
}

    public function handleCancelledDonation(Request $request)
    {
        $payload = $request->getContent();
        $sig_header = $request->server('HTTP_STRIPE_SIGNATURE');
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, env('STRIPE_WEBHOOK_SECRET')
            );
        } catch (\UnexpectedValueException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        } catch (SignatureVerificationException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;
                $donationId = $session->metadata->donation_id;
                $donation = Donation::find($donationId);

                if ($donation) {

                    $donation->status = 'cancelled';
                    $donation->save();

                    return response()->json(['message' => 'Don annulé'], 200);
                }
                break;
            default:
                return response()->json(['message' => 'Événement Stripe non géré'], 400);
        }
    }
}