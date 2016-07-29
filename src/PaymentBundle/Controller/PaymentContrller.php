<?php

namespace ClickTeck\featuresBundle\Controller;

use ClickTeck\featuresBundle\Entity\Orders;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Payum\Paypal\ExpressCheckout\Nvp\Api;
use Payum\Core\Registry\RegistryInterface;
use Payum\Core\Request\GetHumanStatus;
use Payum\Core\Security\GenericTokenFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;


class PaymentController extends Controller
{
    public function preparePaypalExpressCheckoutPaymentAction(Request $request)
    {
        $paymentName = 'paypal';
        $eBook = array(
            'author' => 'Jules Verne',
            'name' => 'The Mysterious Island',
            'description' => 'The Mysterious Island is a novel by Jules Verne, published in 1874.',
            'price' => 8.64,
            'currency_symbol' => '$',
            'currency' => 'USD',
            'clientId' => '222',
            'clientemail' => 'xyz@abc.com'
        );



        $storage = $this->get('payum')->getStorage('ClickTeck\featuresBundle\Entity\Orders');
        /** @var $paymentDetails Orders */
        $paymentDetails = $storage->create();

        $paymentDetails->setNumber(uniqid());
        $paymentDetails->setCurrencyCode($eBook['currency']);
        $paymentDetails->setTotalAmount($eBook['price']);
        $paymentDetails->setDescription($eBook['description']);
        $paymentDetails->setClientId($eBook['clientId']);
        $paymentDetails->setClientEmail($eBook['clientemail']);


        $paymentDetails['PAYMENTREQUEST_0_CURRENCYCODE'] = $eBook['currency'];
        $paymentDetails['PAYMENTREQUEST_0_AMT'] = $eBook['price'];
        $paymentDetails['NOSHIPPING'] = Api::NOSHIPPING_NOT_DISPLAY_ADDRESS;
        $paymentDetails['REQCONFIRMSHIPPING'] = Api::REQCONFIRMSHIPPING_NOT_REQUIRED;
        $paymentDetails['L_PAYMENTREQUEST_0_ITEMCATEGORY0'] = Api::PAYMENTREQUEST_ITERMCATEGORY_DIGITAL;
        $paymentDetails['L_PAYMENTREQUEST_0_AMT0'] = $eBook['price'];
        $paymentDetails['L_PAYMENTREQUEST_0_NAME0'] = $eBook['author'].'. '.$eBook['name'];
        $paymentDetails['L_PAYMENTREQUEST_0_DESC0'] = $eBook['description'];
        $storage->update($paymentDetails);
        $captureToken = $this->getTokenFactory()->createCaptureToken(
            $paymentName,
            $paymentDetails,
            'payment_done'
        );
        $paymentDetails['INVNUM'] = $paymentDetails->getId();
        $storage->update($paymentDetails);
        return $this->redirect($captureToken->getTargetUrl());


    }

    public function doneAction(Request $request)
    {

        $token = $this->get('payum.security.http_request_verifier')->verify($request);

        $payment = $this->get('payum')->getPayment($token->getPaymentName());

        // you can invalidate the token. The url could not be requested any more.
        // $this->get('payum.security.http_request_verifier')->invalidate($token);

        // Once you have token you can get the model from the storage directly.
        //$identity = $token->getDetails();
        //$order = $payum->getStorage($identity->getClass())->find($identity);

        // or Payum can fetch the model for you while executing a request (Preferred).
        $payment->execute($status = new GetHumanStatus($token));
        $order = $status->getFirstModel();

        // you have order and payment status
        // so you can do whatever you want for example you can just print status and payment details.

        return new JsonResponse(array(
            'status' => $status->getValue(),
            'response' => array(
                'order' => $order->getTotalAmount(),
                'currency_code' => $order->getCurrencyCode(),
                'details' => $order->getDetails(),
            ),
        ));

    }

    /**
     * @return RegistryInterface
     */
    protected function getPayum()
    {
        return $this->get('payum');
    }
    /**
     * @return GenericTokenFactoryInterface
     */
    protected function getTokenFactory()
    {
        return $this->get('payum.security.token_factory');
    }

}