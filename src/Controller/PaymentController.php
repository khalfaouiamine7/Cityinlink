<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{
    #[Route('/payment', name: 'stripe_payment')]
    public function stripePayment(Request $request): Response
    { 
        $token = $request->request->get('stripeToken');

        try {
            // Set your secret key
            Stripe::setApiKey('sk_test_51N3mM8EJUeUWMx2GOP7j2EMu84MnMHYBJVQmQAcZKwsVFTB6lij7QcqtyzmUXl4yplDGXwVJZP2U57WDPd7pRg8j004xZENuE0');

            // Create a charge
            $charge = \Stripe\Charge::create([
                'amount' => 655, // Amount in cents
                'currency' => 'usd',
                'description' => 'Ticket purchase',
                'source' => $token,
            ]);

            return $this->redirectToRoute('payment_success');
        } catch (CardException $e) {
            // If there's an error processing the payment, handle it
            $error = $e->getMessage();
            return $this->render('payment/error.html.twig', ['error' => $error]);
        }
    }

    #[Route('/payment_success', name: 'payment_success')]

    public function paymentSuccess(): Response
    {
        return $this->render('payment/success.html.twig');
    }
}
