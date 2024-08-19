<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\View\View;
use MyFatoorah\Library\MyFatoorah;
use MyFatoorah\Library\API\Payment\MyFatoorahPayment;
use MyFatoorah\Library\API\Payment\MyFatoorahPaymentEmbedded;
use MyFatoorah\Library\API\Payment\MyFatoorahPaymentStatus;
use Exception;
use App\Traits\mainTrait;
use Illuminate\Support\Facades\Notification;
use App\Notifications\InvoicePaid;
use Illuminate\Support\Facades\Auth;

class MyFatoorahController extends Controller {
use mainTrait;
    /**
     * @var array
     */
    public $mfConfig = [];

//-----------------------------------------------------------------------------------------------------------------------------------------

    /**
     * Initiate MyFatoorah Configuration
     */
    public function __construct() {
        $this->mfConfig = [
            'apiKey'      => 'ER8wBBGUL0tBH7Lc1cXXPWvuG9bHZn7FHYCJQnfRrO3PdS7oLmn01EC6XKbU7cHEmU_dgCRp4xBuW0_jmBleRVkZna2mLdwqzPM1oeOsnIh_cuEfOaF-EqAlaIB7Y-2getXYfWJmSBwhz_96jKnpNG4yXik0lLliGDn4qJbqiDFqr1bdQEyVlsQFotKYr9mPxHQJvj3JRlcTngSQT1ariehHGOfIfK-XiLqxHLUcLYNB1SBQXbSoiVfVCECUZhwlSq8rpLChHw4vXfAjCaOCK_QNGG-HMortDFyvOMSrjZg7PxfP2le8KtG3k-sbUjuKyXGtCRLbAUtWVKl7-OC40IIxyDPildxOnbM13cNczdscp0UfP5BGIapOJ18tv5-BXvfiNzcTaS5sb849HYEHIL8QAofPyM9xVx5jacB6LN58KoHqR5hB7YwbELRBlxbxTbI9XvU5iwwZCslQ9yqVAH2FUpVMpjMb-VzT9UbjXtBbGn4vuLzWBc3_wzbR08vZEDaoMogo_rwW_rADkCW8aCuXC7Fjn4iRs3YY9ptXNt4QQ7xHpfSykbCBCfk1m_I_tPQ6soopCqY_N58xAhNtxN7PsTLRz0-eQwPoHSeUs_aM53RQ6QaaoQ2Nx9eZWZK67Q-iS8_I3UaZludQhNsuaohhiL7bP5g242m_r7XOPnwiz7p3',
            'isTest'      => config('myfatoorah.test_mode'),
            'countryCode' => config('myfatoorah.country_iso'),
        ];
    }

//-----------------------------------------------------------------------------------------------------------------------------------------

    /**
     * Redirect to MyFatoorah Invoice URL
     * Provide the index method with the order id and (payment method id or session id)
     *
     * @return Response
     */
    public function index(Request $request) {
        try {           
           
            //For example: pmid=0 for MyFatoorah invoice or pmid=1 for Knet in test mode
            $paymentId = request('pmid') ?: 0;
            $sessionId = request('sid') ?: null;           
            
            $orderId=$request->id;
                    
            $curlData = $this->getPayLoadData($orderId);

            $mfObj   = new MyFatoorahPayment($this->mfConfig);
            $payment = $mfObj->getInvoiceURL($curlData, $paymentId, $orderId, $sessionId);

            return redirect($payment['invoiceURL']);
        } catch (Exception $ex) {
            $exMessage = __('myfatoorah.' . $ex->getMessage());
            return response()->json(['IsSuccess' => 'false', 'Message' => $exMessage]);
        }
    }

//-----------------------------------------------------------------------------------------------------------------------------------------

    /**
     * Example on how to map order data to MyFatoorah
     * You can get the data using the order object in your system
     * 
     * @param int|string $orderId
     * 
     * @return array
     */
    private function getPayLoadData($orderId = null) {
        $callbackURL = route('myfatoorah.callback');

        //You can get the data using the order object in your system
       // $order = $this->getTestOrderData($orderId);
       $order=Order::findOrFail($orderId);

        return [
            'CustomerName'       => $order->user->name,
            'InvoiceValue'       => $order['total_price'],
            'DisplayCurrencyIso' => 'USD',
            'CustomerEmail'      =>  $order->user->email,
            'CallBackUrl'        => $callbackURL,
            'ErrorUrl'           => $callbackURL,
           // 'MobileCountryCode'  => '+965',
            //'CustomerMobile'     => '12345678',
            'Language'           => 'en',
            'CustomerReference'  => $orderId,
            'SourceInfo'         => 'Laravel ' . app()::VERSION . ' - MyFatoorah Package ' . MYFATOORAH_LARAVEL_PACKAGE_VERSION
        ];
    }

//-----------------------------------------------------------------------------------------------------------------------------------------

    /**
     * Get MyFatoorah Payment Information
     * Provide the callback method with the paymentId
     * 
     * @return Response
     */
    public function callback()
    {
      
            $paymentId = request('paymentId');

            $mfObj = new MyFatoorahPaymentStatus($this->mfConfig);
            $data  = $mfObj->getPaymentStatus($paymentId, 'PaymentId');

            if ($data->InvoiceStatus == 'Paid') {
                $order = Order::findOrFail($data->CustomerReference);

                if ($order) {
                    // Update the order status
                    $order->status = 'paid';
                    $order->save();

                    // Create a new payment record
                 $payment=   Payment::create([
                        'order_id' => $order->id,
                        'invoice_id' => $data->InvoiceId,
                        'InvoiceStatus'=>$data->InvoiceStatus,
                        'payment_reference' => $data->InvoiceReference,
                        'payment_gateway' => $data->InvoiceTransactions[0]->PaymentGateway,
                        'transaction_id' => $data->InvoiceTransactions[0]->TransactionId,
                        'authorization_id' => $data->InvoiceTransactions[0]->AuthorizationId,
                        'transaction_status' => $data->InvoiceTransactions[0]->TransactionStatus,
                        'transaction_value' => $data->InvoiceTransactions[0]->TransationValue,
                        'currency' => $data->InvoiceTransactions[0]->PaidCurrency,                      
                    ]);
                }
                $users =   $this->getAdmin();
                Notification::send($users, new InvoicePaid($order->id, $data->CustomerName));

                $message = 'Payment successfully recorded.';
            } else {
                $message = 'Payment failed: ' . $data->InvoiceError;
            }

            $response = ['IsSuccess' => true, 'Message' => $message, 'Data' => $data];

            $order = Order::findOrFail($order->id);
            return view('orders.invoice', compact('order'));

       

        return response()->json($response);
    }
//-----------------------------------------------------------------------------------------------------------------------------------------

    /**
     * Example on how to Display the enabled gateways at your MyFatoorah account to be displayed on the checkout page
     * Provide the checkout method with the order id to display its total amount and currency
     * 
     * @return View
     */
    public function checkout() {
        try {
            //You can get the data using the order object in your system
            $orderId = request('oid') ?: 147;
            $order   = $this->getTestOrderData($orderId);

            //You can replace this variable with customer Id in your system
            $customerId = request('customerId');

            //You can use the user defined field if you want to save card
            $userDefinedField = config('myfatoorah.save_card') && $customerId ? "CK-$customerId" : '';

            //Get the enabled gateways at your MyFatoorah acount to be displayed on checkout page
            $mfObj          = new MyFatoorahPaymentEmbedded($this->mfConfig);
            $paymentMethods = $mfObj->getCheckoutGateways($order['total'], $order['currency'], config('myfatoorah.register_apple_pay'));

            if (empty($paymentMethods['all'])) {
                throw new Exception('noPaymentGateways');
            }

            //Generate MyFatoorah session for embedded payment
            $mfSession = $mfObj->getEmbeddedSession($userDefinedField);

            //Get Environment url
            $isTest = $this->mfConfig['isTest'];
            $vcCode = $this->mfConfig['countryCode'];

            $countries = MyFatoorah::getMFCountries();
            $jsDomain  = ($isTest) ? $countries[$vcCode]['testPortal'] : $countries[$vcCode]['portal'];

            return view('myfatoorah.checkout', compact('mfSession', 'paymentMethods', 'jsDomain', 'userDefinedField'));
        } catch (Exception $ex) {
            $exMessage = __('myfatoorah.' . $ex->getMessage());
            return view('myfatoorah.error', compact('exMessage'));
        }
    }

//-----------------------------------------------------------------------------------------------------------------------------------------

    /**
     * Example on how the webhook is working when MyFatoorah try to notify your system about any transaction status update
     */
    public function webhook(Request $request) {
        try {
            //Validate webhook_secret_key
            $secretKey = config('myfatoorah.webhook_secret_key');
            if (empty($secretKey)) {
                return response(null, 404);
            }

            //Validate MyFatoorah-Signature
            $mfSignature = $request->header('MyFatoorah-Signature');
            if (empty($mfSignature)) {
                return response(null, 404);
            }

            //Validate input
            $body  = $request->getContent();
            $input = json_decode($body, true);
            if (empty($input['Data']) || empty($input['EventType']) || $input['EventType'] != 1) {
                return response(null, 404);
            }

            //Validate Signature
            if (!MyFatoorah::isSignatureValid($input['Data'], $secretKey, $mfSignature, $input['EventType'])) {
                return response(null, 404);
            }

            //Update Transaction status on your system
            $result = $this->changeTransactionStatus($input['Data']);

            return response()->json($result);
        } catch (Exception $ex) {
            $exMessage = __('myfatoorah.' . $ex->getMessage());
            return response()->json(['IsSuccess' => false, 'Message' => $exMessage]);
        }
    }

//-----------------------------------------------------------------------------------------------------------------------------------------
    private function changeTransactionStatus($inputData) {
        //1. Check if orderId is valid on your system.
        $orderId = $inputData['CustomerReference'];

        //2. Get MyFatoorah invoice id
        $invoiceId = $inputData['InvoiceId'];

        //3. Check order status at MyFatoorah side
        if ($inputData['TransactionStatus'] == 'SUCCESS') {
            $status = 'Paid';
            $error  = '';
        } else {
            $mfObj = new MyFatoorahPaymentStatus($this->mfConfig);
            $data  = $mfObj->getPaymentStatus($invoiceId, 'InvoiceId');

            $status = $data->InvoiceStatus;
            $error  = $data->InvoiceError;
        }

        $message = $this->getTestMessage($status, $error);

        //4. Update order transaction status on your system
        return ['IsSuccess' => true, 'Message' => $message, 'Data' => $inputData];
    }


   

//-----------------------------------------------------------------------------------------------------------------------------------------
    private function getTestMessage($status, $error) {
        if ($status == 'Paid') {
            return 'Invoice is paid.';
        } else if ($status == 'Failed') {
            return 'Invoice is not paid due to ' . $error;
        } else if ($status == 'Expired') {
            return $error;
        }
    }

//-----------------------------------------------------------------------------------------------------------------------------------------
}
