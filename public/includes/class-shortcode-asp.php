<?php

class AcceptSimplifyPaymentShortcode {

    var $AcceptSimplifyPayment = null;

    /**
     * Instance of this class.
     *
     * @since    1.0.0
     *
     * @var      object
     */
    protected static $instance = null;
    protected static $payment_buttons = array();

    function __construct() {
        $this->AcceptSimplifyPayment = AcceptSimplifyPayment::get_instance();

        add_shortcode('accept_simplify_payment', array(&$this, 'shortcode_accept_simplify_payment'));
        add_shortcode('accept_simplify_payment_checkout', array(&$this, 'shortcode_accept_simplify_payment_checkout'));
        if (!is_admin()) {
            add_filter('widget_text', 'do_shortcode');
        }

    }

    public function interfer_for_redirect() {
        global $post;
        if (!is_admin()) {
            if (has_shortcode($post->post_content, 'accept_simplify_payment_checkout')) {
                $this->shortcode_accept_simplify_payment_checkout();
                exit;
            }
        }
    }

    /**
     * Return an instance of this class.
     *
     * @since     1.0.0
     *
     * @return    object    A single instance of this class.
     */
    public static function get_instance() {

        // If the single instance hasn't been set, set it now.
        if (null == self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    function shortcode_accept_simplify_payment($atts, $content = "") {

        extract(shortcode_atts(array(
            'name' => 'Item Name',
            'price' => '0',
            'quantity' => '1',
            'url' => '',
            'currency' => $this->AcceptSimplifyPayment->get_setting('currency_code'),
            'button_text' => $this->AcceptSimplifyPayment->get_setting('button_text'),
                        ), $atts));

        if (!empty($url)) {
            $url = base64_encode($url);
        }
        else
            $url = '';

        $button_id = 'simplify_button_' . count(self::$payment_buttons);
        self::$payment_buttons[] = $button_id;
        $priceInCents = $price * 100;
        $paymentAmount = $price*$quantity;

        //$output = "<form action='" . $this->AcceptSimplifyPayment->get_setting('checkout_url') . "' METHOD='POST'> ";

        $output = "<script src='https://www.simplify.com/commerce/simplify.pay.js'></script><button class='simplify-button'
          data-sc-key='".$this->AcceptSimplifyPayment->get_setting('api_public_key')."'
          data-amount='{$priceInCents}' 
          data-name='{$name}'
          data-description='{$quantity} piece for {$paymentAmount} {$currency}'
          data-currency='{$currency}'
          data-redirect-url='" . $this->AcceptSimplifyPayment->get_setting('checkout_url') . "'
          data-reference='".base64_encode($name.'~'.$price.'~'.$quantity.'~'.$url)."'
          >{$button_text}</button>";
      /*
        $output .= "<input type='hidden' value='{$name}' name='item_name' />";
        $output .= "<input type='hidden' value='{$price}' name='item_price' />";
        $output .= "<input type='hidden' value='{$quantity}' name='item_quantity' />";
        $output .= "<input type='hidden' value='{$currency}' name='currency_code' />";
        $output .= "<input type='hidden' value='{$url}' name='item_url' />";
        $output .= "</form>";
        */
        return $output;
    }


    public function shortcode_accept_simplify_payment_checkout($atts = array(), $content) {


        //http://wpdevtest.local/acceptsimplifypayment-checkout/?
        //amount=67&
        //paymentId=ood8ax48&
        //paymentDate=1426501195731&
        //paymentStatus=APPROVED&
        //authCode=aOQHSo&
        //currency=USD&
        //signature=5B7D3E2D7AEE5059F3CBD5E541B97F1E

        if (empty($_GET['paymentId'])) {
            echo ('Invalid Payment ID');
            return;
        }
        if (empty($_GET['signature'])) {
            echo ('Invalid Simplify Signature');
            return;
        }
        if (empty($_GET['authCode'])) {
            echo ('Invalid Simplify Authentication Code');
            return;
        }
        if (empty($_GET['reference'])) {
            echo ('Invalid Refernce ID');
            return;
        }

        $paymentAmount = $_POST['item_price'] * $_POST['item_quantity'];

        $currencyCodeType = strtolower($_POST['currency_code']);

        Simplify::$publicKey = $this->AcceptSimplifyPayment->get_setting('api_public_key');
        Simplify::$privateKey = $this->AcceptSimplifyPayment->get_setting('api_private_key');

        $product = base64_decode($_REQUEST['reference']);



        $amount = $_REQUEST['amount']; // The amount you supplied for this payment
        $reference = $_REQUEST['reference']; // The reference you supplied for this payment
        $paymentId = $_REQUEST['paymentId']; // The simplify payment id
        $paymentDate = $_REQUEST['paymentDate']; // The simplify payment date
        $paymentStatus = $_REQUEST['paymentStatus']; // The simplify payment status
        $privateKey = $this->AcceptSimplifyPayment->get_setting('api_private_key'); // Your hosted payments enabled private API key
        // echo $privateKey.'======================================';
        // $signature = $_REQUEST['signature'];
        // $recreatedSignature = strtoupper(md5($amount . $reference . $paymentId . $paymentDate . $paymentStatus . $privateKey));
        // echo $recreatedSignature.'----------------------------'.$signature;
        // if ($recreatedSignature != $signature) {
        if(empty($paymentId) || empty($paymentDate) || empty($paymentStatus) || empty($privateKey) || $product === false ) {
            $GLOBALS['PaymentSuccessfull'] = false;
            $GLOBALS['asp_error'] = 'Signature do not match.'.$recreatedSignature;

        }
        else {

            // echo $product;
            $product = explode('~', $product);
            // print_r($product);
            $product['name'] = $product[0];
            $product['price'] = $product[1];
            $product['quantity'] = $product[2];
            $product['url'] = $product[3];

            // $ASPOrder = ASPOrder::get_instance();
            // $ASPOrder->insert();
            $GLOBALS['PaymentSuccessfull'] = true;

            $order = ASPOrder::get_instance();
            print_r($payment);
            $order->insert($product, $_REQUEST);
            $GLOBALS['item_url'] = $product['url'];
            do_action('AcceptSimplifyPayment_payment_completed',  $payment);

        }



        // echo plugins_url($this->AcceptSimplifyPayment->get_plugin_slug()).'/includes/cacert.pem';
        // ini_set('curl.cainfo', plugins_url($this->AcceptSimplifyPayment->get_plugin_slug()).'/includes/cacert.pem' );

        ob_start();
        // try {                
        //     print_r($_GET);
        //     $payment = Simplify_Payment::findPayment('B5ArRqd4');

        //     print_r($payment);
            // exit;

            // $order = ASPOrder::get_instance();
            // print_r($payment);
            // $order->insert($product, $_REQUEST);

            // do_action('AcceptSimplifyPayment_payment_completed',  $payment);

            // $GLOBALS['PaymentSuccessfull'] = true;
            // $item_url = base64_decode($_POST['item_url']);



        // }
        // catch (Simplify_ApiException $e) {
        //     print "Reference:   " . $e->getReference() . "\n";
        //     print "Message:     " . $e->getMessage() . "\n";
        //     print "Error code:  " . $e->getErrorCode() . "\n";
        //     if ($e instanceof Simplify_BadRequestException && $e->hasFieldErrors()) {
        //         foreach ($e->getFieldErrors() as $fieldError) {
        //             print $fieldError->getFieldName()
        //                 . ": '" . $fieldError->getMessage()
        //                 . "' (" . $fieldError->getErrorCode()
        //                 . ")\n";
        //         }
        //     }
        // }
        // catch (Exception $e) {

        //     if(!empty($charge->failure_code))
        //         $GLOBALS['asp_error'] = $charge->failure_code.": ".$charge->failure_message;
        //     else {
        //         $GLOBALS['asp_error'] =  $e->getMessage();
        //     }
        // }

        // ini_set('curl.cainfo', $existing_cainfo );

        include dirname(dirname(__FILE__)) . '/views/checkout.php';

        return ob_get_clean();

    }

}
