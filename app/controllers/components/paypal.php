<?php
class PaypalComponent extends Component
{
    public $components = array(
        'RequestHandler'
    );
    //Fixed settings
    private $postback_url = array(
        'testmode' => 'https://www.sandbox.paypal.com/cgi-bin/webscr',
        'livemode' => 'https://www.paypal.com/cgi-bin/webscr'
    );
    private $masspay_url = array(
        'testmode' => 'https://api-3t.sandbox.paypal.com/nvp',
        'livemode' => 'https://api-3t.paypal.com/nvp'
    );
    private $paypal_post_vars_in_str = '';
    private $errno;
    private $paypal_response = '';
    public $paypal_post_arr = array();
    //Overridable settings
    public $payee_account = '';
    public $paypal_receiver_emails = '';
    public $is_test_mode = 0;
    public $amount_for_item;
    public $paypal_transaction_model = 'PaypalTransactionLog';
    function initialize(&$controller, $settings = array()) 
    {
        $this->_set($settings);
    }
    function startup(&$controller) 
    {
    }
    public function process() 
    {
        $this->errno = 0; //initialize to no error
        $this->errno|= (strcmp($this->postResponse2PayPal() , 'VERIFIED') == 0) ? 0 : (1<<0);
        $this->errno|= (strcmp($this->paypal_post_arr['payment_status'], 'Completed') == 0) ? 0 : (1<<1);
        $this->errno|= (!$this->_isTransactionProcessed()) ? 0 : (1<<2);
        $this->errno|= ($this->_isValidReceiverEmail()) ? 0 : (1<<3);
        if (!(strcmp($this->paypal_post_arr['payment_status'], 'Refunded') == 0)) {
            //$this->errno|= (($this->amount_for_item != 0) and ($this->paypal_post_arr['mc_gross'] >= $this->amount_for_item)) ? 0 : (1 << 4);
            
        }
        //$this->errno|= ($this->paypal_post_arr['test_ipn'] != '1') ? 0 : (1<<5);
        return (!$this->errno);
    }
    private function _isValidReceiverEmail() 
    {
        $receiver_emails[] = $this->payee_account;
        $tmp_receiver_emails = explode(',', $this->paypal_receiver_emails);
        if (is_array($tmp_receiver_emails)) {
            foreach($tmp_receiver_emails as $receiver_email) {
                $receiver_emails[] = trim($receiver_email);
            }
        }
        return (in_array($this->paypal_post_arr['receiver_email'], $receiver_emails));
    }
    public function postResponse2PayPal() 
    {
        // post back to PayPal system to validate
        $this->paypal_post_vars_in_str = 'cmd=_notify-validate' . $this->paypal_post_vars_in_str;
        $url = parse_url((($this->is_test_mode) ? $this->postback_url['testmode'] : $this->postback_url['livemode']));
        $header = 'POST ' . $url['path'] . ' HTTP/1.0' . "\r\n";
        $header.= 'Content-Type: application/x-www-form-urlencoded' . "\r\n";
        $header.= 'Content-Length: ' . strlen($this->paypal_post_vars_in_str) . "\r\n\r\n";
        $fp = @fsockopen('ssl://'.$url['host'], '443', $errno, $errstr, 30);
        // suppress socket connection error by '@'...
        if (!$fp) // ERROR
        $this->paypal_response = $errstr . '(' . $errno . ')';
        else {
            // just post it...
            fputs($fp, $header . $this->paypal_post_vars_in_str);
            while (!feof($fp)) {
                $resp = fgets($fp, 1024);
                if (strcmp($resp, 'VERIFIED') == 0) {
                    $this->paypal_response = 'VERIFIED';
                } else if (strcmp($resp, 'INVALID') == 0) {
                    $this->paypal_response = 'INVALID';
                }
            }
        }
        return $this->paypal_response;
    }
    public function sanitizeServerVars($_POST) 
    {
        $this->paypal_post_arr = (!empty($_POST)) ? $_POST : array();
        foreach($this->paypal_post_arr as $key => $value) {
            $value = urlencode(stripslashes($value));
            $this->paypal_post_vars_in_str.= "&$key=$value";
        }
        $expected_paypal_post_arr = array(
            'txn_id' => '',
            'item_name' => '',
            'payer_email' => '',
            'payment_date' => '',
            'mc_gross' => 0,
            'mc_fee' => 0,
            'mc_currency' => '',
            'payment_status' => '',
            'payment_type' => '',
            'receiver_email' => '',
            'quantity' => 0,
            'payer_status' => '',
            'test_ipn' => '',
            'option_selection1' => '',
            'option_name1' => '',
            'type' => '',
            'memo' => '',
        );
        $tmp_arr = array();
        foreach($expected_paypal_post_arr as $key => $default_value) {
            $tmp_arr[$key] = (isset($this->paypal_post_arr[$key])) ? htmlspecialchars(trim($this->paypal_post_arr[$key])) : $default_value;
        }
        //Processing and fetching the user defiend fields
        if (!empty($this->paypal_post_arr['option_name1']) and $this->paypal_post_arr['option_name1'] == 'Transkey' and !empty($this->paypal_post_arr['option_selection1'])) {
            $transkey_parts = explode('~', $this->paypal_post_arr['option_selection1']);
            if (count($transkey_parts) == 2) {
                if ($transkey_parts[1] == (substr(md5(Configure::read('Security.salt') . $transkey_parts[0]) , 5, 5))) {
                    $user_defined = unserialize(gzinflate(base64_url_decode($transkey_parts[0])));
                    if (is_array($user_defined)) {
                        $tmp_arr = array_merge($tmp_arr, $user_defined);
                    }
                }
            }
        }
        $this->paypal_post_arr = $tmp_arr;
    }
    private function _isTransactionProcessed() 
    {
        $paypalTransactionModel = ClassRegistry::init($this->paypal_transaction_model);
        return ($paypalTransactionModel->find('count', array(
            'conditions' => array(
                $this->paypal_transaction_model . '.txn_id' => $this->paypal_post_arr['txn_id'],
                $this->paypal_transaction_model . '.error_no' => 0
            )
        )));
    }
    public function logPaypalTransactions() 
    {
        //Creating error message string from errorno
        $errorMessaegString = '';
        if ($this->errno) {
            $_errMessages = array(
                1 => 'Problem in VERIFIED status', // 0
                2 => 'Not completed', // 1
                4 => 'Problem in processing transaction', // 2
                8 => 'Invalid receiver email', // 3
                16 => 'Enought amount not received', // 4
                32 => 'Test ipn (sandbox transaction) enabled', // 5
                64 => 'vacant', // 6
                128 => 'vacant', // 7
                256 => 'vacant', // 8
                512 => 'vacant', // 9
                1024 => 'vacant', // 10
                
            );
            $errMessages = array();
            for ($i = 0; $i < count($_errMessages); ++$i) {
                if ($this->errno&(1<<$i)) {
                    $errMessages[] = $_errMessages[(1<<$i) ];
                }
            }
            $errorMessaegString.= implode(',', $errMessages);
        }
        $paypalTransactionModel = ClassRegistry::init($this->paypal_transaction_model);
        $this->request->data['PaypalTransactionLog']['paypal_response'] = $this->paypal_response;
        $this->request->data['PaypalTransactionLog']['error_no'] = $this->errno;
        $this->request->data['PaypalTransactionLog']['error_message'] = $errorMessaegString;
        if (!($this->errno == 0)) {
            $this->request->data['PaypalTransactionLog']['paypal_post_vars'] = $this->paypal_post_vars_in_str;
        }
        $this->request->data['PaypalTransactionLog']['ip'] = $this->RequestHandler->getClientIP();
        foreach($this->paypal_post_arr as $key => $value) {
            $this->request->data['PaypalTransactionLog'][$key] = $value;
        }
        $paypalTransactionModel->save($this->request->data);
        return $paypalTransactionModel->getLastInsertId();
    }
    // PayPal Mass pay Implementation
    // It will accept Sneders Login credentials as well and the Recieves details and Amoount
    // It returns the Output
    // Input Params
    // $sender_info=array(
    //			['API_UserName']
    //			['API_Password']
    //			['API_Signature']
    // or other currency ('GBP', 'EUR', 'JPY', 'CAD', 'AUD')
    function massPay($sender_info, $reciever_info, $notify_url = '', $email_subject = '', $test_mode = false, $currency = 'USD') 
    {
        // Set request-specific fields.
        $receiver_type = urlencode('EmailAddress');
        $API_Endpoint = ($test_mode) ? $this->masspay_url['testmode'] : $this->masspay_url['livemode'];
        $nvpStr = '';
        // Set up your API credentials, PayPal end point, and API version.
        $API_UserName = urlencode(trim($sender_info['API_UserName']));
        $API_Password = urlencode(trim($sender_info['API_Password']));
        $API_Signature = urlencode(trim($sender_info['API_Signature']));
        // Add request-specific fields to the request string.
        $nvpStr = "&EMAILSUBJECT=$email_subject&RECEIVERTYPE=$receiver_type&CURRENCYCODE=$currency";
        foreach($reciever_info as $i => $receiverData) {
            $receiverEmail = urlencode(trim($receiverData['receiverEmail']));
            $amount = urlencode($receiverData['amount']);
            $uniqueID = urlencode($receiverData['uniqueID']);
            $note = urlencode($receiverData['note']);
            $notify = ($notify_url != '') ? ('notify_url=' . $notify_url) : '';
            $nvpStr.= "&L_EMAIL$i=$receiverEmail&L_Amt$i=$amount&L_UNIQUEID$i=$uniqueID&L_NOTE$i=$note&$notify";
        }
        $version = urlencode('51.0');
        // Set the curl parameters.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        // Turn off the server and peer verification (TrustManager Concept).
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        // Set the API operation, version, and API signature in the request.
        $nvpreq = "METHOD=MassPay&VERSION=$version&PWD=$API_Password&USER=$API_UserName&SIGNATURE=$API_Signature$nvpStr";
        // Set the request as a POST FIELD for curl.
        curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);
        // Get response from the server.
        $httpResponse = curl_exec($ch);
        if (!$httpResponse) {
            exit("Mass Pay  failed: " . curl_error($ch) . '(' . curl_errno($ch) . ')');
        }
        // Extract the response details.
        $httpResponseAr = explode("&", $httpResponse);
        $httpParsedResponseAr = array();
        foreach($httpResponseAr as $i => $value) {
            $tmpAr = explode("=", $value);
            if (sizeof($tmpAr) > 1) {
                $httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
            }
        }
        if ((0 == sizeof($httpParsedResponseAr)) || !array_key_exists('ACK', $httpParsedResponseAr)) {
            exit("Invalid HTTP Response for POST request($nvpreq) to $API_Endpoint.");
        }
        $httpParsedResponseAr['TIMESTAMP'] = urldecode($httpParsedResponseAr['TIMESTAMP']);
        return $httpParsedResponseAr;
    }
}
?>
