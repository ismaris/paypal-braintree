<?php
// Store to session
session_start();
$site='https://paypal.scott-mann.net/paypal-braintree/';
if(empty($_SESSION['loggedIn'])) {
      header('Location: '.$site.'_functions/login.php');
  }
require('_include/header.html');

require_once '/home/ismaris/paypal-braintree/vendor/braintree/braintree_php/lib/Braintree.php';

$gateway = new Braintree_Gateway(array(
    'accessToken' => '#PUT SANDBOX ACCESS TOKEN IN HERE (See https://developer.paypal.com/docs/accept-payments/express-checkout/ec-vzero/get-started/)',
));
?>
<script src="https://js.braintreegateway.com/v2/braintree.js"></script>
    <div class="container">
        <div class="row">
        <div class="pre_2 col_8">
            <form id="form" class="form" target="_top" method="post" enctype="https://www.paypal.com/cgi-bin/webscr" accept-charset="UTF-8">
				<h1 id="mainTitle">PayPal Express Checkout Demo (Braintree)</h1>
				<div class="content">
					<div id="section0" >
						<div class="field" id="usernameField"><label for="CC">Username:</label><input type="text" id="CC" name="CC" disabled="disabled" size="15" value="<? echo $_SESSION['user'];?>"</input></div>
						<div class="field"><label for="CC">Email:</label><input type="text" id="CC" name="CC" size="15" placeholder="johndoe@indiana.edu"></div>
						<div class="col_3">
							<div id="paypal-container"></div>
						</div>
					</div>
				</div>	
            </form>
            </div>	
        </div>
     </div> 
    <script type="text/javascript">
        var token = "<?php echo($clientToken = $gateway->clientToken()->generate());?>";
        braintree.setup(token, "custom", {
          paypal: {
            container: "paypal-container",
            singleUse: true, // Required
            amount: 1.00, // Required
            currency: 'USD', // Required
            locale: 'en_us',
            enableShippingAddress: 'true',
            shippingAddressOverride: {
              recipientName: 'Scruff McGruff',
              streetAddress: '1234 Main St.',
              extendedAddress: 'Unit 1',
              locality: 'Chicago',
              countryCodeAlpha2: 'US',
              postalCode: '60652',
              region: 'IL',
              phone: '123.456.7890',
              editable: false
            }
          },
            onPaymentMethodReceived: function (obj) {
              var paypal_obj = JSON.stringify(obj);
              var url = "confirmation.php?details=" + paypal_obj;
             location.href = url;
           }
        });
    </script>
<?php 
include('./_include/footer.html'); ?>
