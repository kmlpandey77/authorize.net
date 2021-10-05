<?php

require_once './vendor/autoload.php';

require_once './config.php';

use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

$card_number = preg_replace('/\s+/', '', $_POST['card_number']);

$card_exp_month = $_POST['card_exp_month'];
$card_exp_year = $_POST['card_exp_year'];
$card_exp_year_month = $card_exp_year.'-'.$card_exp_month;

$card_cvc = $_POST['card_cvc'];

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$state = $_POST['state'];
$city = $_POST['city'];
$street = $_POST['street'];
$zip_code = $_POST['zip_code'];
$country = $_POST['country'];

$email = $_POST['email'];

// Set the transaction's reference ID
$refID = 'REF'.time();

$price = $_POST['price'];

$merchantAuthentication = new AnetAPI\MerchantAuthenticationType();

$merchantAuthentication->setName(ANETID);
$merchantAuthentication->setTransactionKey(ANETTRANSACTIONKEY);

// Create the payment data for a credit card
$creditCard = new AnetAPI\CreditCardType();
$creditCard->setCardNumber($card_number);
$creditCard->setExpirationDate($card_exp_year_month);
$creditCard->setCardCode($card_cvc);

// Add the payment data to a paymentType object
$paymentOne = new AnetAPI\PaymentType();
$paymentOne->setCreditCard($creditCard);

// Create order information
$order = new AnetAPI\OrderType();
$order->setDescription('Online order');

// Set the customer's identifying information
$customerData = new AnetAPI\CustomerDataType();
$customerData->setType('individual');
$customerData->setEmail($email);

$customerAddress = new AnetAPI\CustomerAddressType();
$customerAddress->setFirstName($first_name);
$customerAddress->setLastName($last_name);
$customerAddress->setState($state);
$customerAddress->setCity($city);
$customerAddress->setAddress($street);
$customerAddress->setZip($zip_code);
$customerAddress->setCountry($country);

$shippingAddress = new AnetAPI\CustomerAddressType();
$shippingAddress->setFirstName($first_name);
$shippingAddress->setLastName($last_name);
$shippingAddress->setState($state);
$shippingAddress->setCity($city);
$shippingAddress->setAddress($street);
$shippingAddress->setZip($zip_code);
$shippingAddress->setCountry($country);

// Create a transaction
$transactionRequestType = new AnetAPI\TransactionRequestType();
$transactionRequestType->setTransactionType('.');
$transactionRequestType->setAmount($price);
$transactionRequestType->setOrder($order);
$transactionRequestType->setPayment($paymentOne);
$transactionRequestType->setCustomer($customerData);
$transactionRequestType->setBillTo($customerAddress);
$transactionRequestType->setShipTo($shippingAddress);

$trans_request = new AnetAPI\CreateTransactionRequest();
$trans_request->setMerchantAuthentication($merchantAuthentication);
$trans_request->setRefId($refID);
$trans_request->setTransactionRequest($transactionRequestType);
$controller = new AnetController\CreateTransactionController($trans_request);

$response = $controller->executeWithApiResponse(constant("\\net\authorize\api\constants\ANetEnvironment::".ANETENVIRONMENT));

if ($response != null) {
    // Check to see if the API request was successfully received and acted upon
    if ($response->getMessages()->getResultCode() == 'Ok') {
        // Since the API request was successful, look for a transaction response
        // and parse it to display the results of authorizing the card
        $tresponse = $response->getTransactionResponse();

        if ($tresponse != null && $tresponse->getMessages() != null) {
            echo ' Successfully created transaction with Transaction ID: '.$tresponse->getTransId()."\n";
            echo ' Transaction Response Code: '.$tresponse->getResponseCode()."\n";
            echo ' Message Code: '.$tresponse->getMessages()[0]->getCode()."\n";
            echo ' Auth Code: '.$tresponse->getAuthCode()."\n";
            echo ' Description: '.$tresponse->getMessages()[0]->getDescription()."\n";
        } else {
            echo "Transaction Failed \n";
            if ($tresponse->getErrors() != null) {
                echo ' Error Code  : '.$tresponse->getErrors()[0]->getErrorCode()."\n";
                echo ' Error Message : '.$tresponse->getErrors()[0]->getErrorText()."\n";
            }
        }
        // Or, print errors if the API request wasn't successful
    } else {
        echo "Transaction Failed \n";
        $tresponse = $response->getTransactionResponse();

        if ($tresponse != null && $tresponse->getErrors() != null) {
            echo ' Error Code  : '.$tresponse->getErrors()[0]->getErrorCode()."\n";
            echo ' Error Message : '.$tresponse->getErrors()[0]->getErrorText()."\n";
        } else {
            echo ' Error Code  : '.$response->getMessages()->getMessage()[0]->getCode()."\n";
            echo ' Error Message : '.$response->getMessages()->getMessage()[0]->getText()."\n";
        }
    }
} else {
    echo  "No response returned \n";
}
