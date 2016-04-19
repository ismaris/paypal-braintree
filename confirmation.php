<?php
require_once '/home/ismaris/paypal-braintree/vendor/braintree/braintree_php/lib/Braintree.php';
$json = json_decode($_GET['details'], true);
$orderid = rand();
$gateway = new Braintree_Gateway(array(
    'accessToken' => 'access_token$sandbox$kqs6v9pqg7gjy3cv$f522b07061f265a9badc48412bf86e9f',
));

$result = $gateway->transaction()->sale([
    "amount" => '20.00',
    "paymentMethodNonce" => $json['nonce'],
    "orderId" => $orderid,
    "descriptor" => [
      "name" => "Sct*"
    ],
    "shipping" => [
      "firstName" => "Jen",
      "lastName" => "Smith",
      "streetAddress" => "1 E 1st St",
      "extendedAddress" => "Suite 403",
      "locality" => "Bartlett",
      "region" => "IL",
      "postalCode" => "60103",
      "countryCodeAlpha2" => "US"
    ],      
    "options" => [
      "paypal" => [
        "customField" => 'blah',
        "description" => 'blah2'
      ],
    ]
]);
if ($result->success) {
  print_r("Success ID: " . $result->transaction->id);
} else {
  print_r("Error Message: " . $result->message);
}

?>