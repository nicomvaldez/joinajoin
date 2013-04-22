<?php
class PagseguroTransactionLog extends AppModel
{
    var $name = 'PagseguroTransactionLog';
    //$validate set in __construct for multi-language support
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    var $belongsTo = array(
        'PropertyUser' => array(
            'className' => 'PropertyUser',
            'foreignKey' => 'property_user_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
        'Property' => array(
            'className' => 'Property',
            'foreignKey' => 'property_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
        'PaymentGateway' => array(
            'className' => 'PaymentGateway',
            'foreignKey' => 'payment_gateway_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        )
    );
    function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
    }
	function logPagSeguroTransactions($transaction_data)
	{
		$data['PagseguroTransactionLog']['serialized_post_array'] = base64_encode(serialize($transaction_data));
		$data['PagseguroTransactionLog']['amount'] = $transaction_data['amount_needed'];
		$data['PagseguroTransactionLog']['currency'] = $transaction_data['currency_code'];
		$data['PagseguroTransactionLog']['quantity'] = !empty($transaction_data['quantity']) ? $transaction_data['quantity'] : 1;
		$data['PagseguroTransactionLog']['payment_gateway_id'] = $transaction_data['payment_gateway_id'];
		$data['PagseguroTransactionLog']['buyer_email'] = !empty($transaction_data['buyer_email']) ? $transaction_data['buyer_email'] : '';
		$data['PagseguroTransactionLog']['transaction_id'] = !empty($transaction_data['transaction_id']) ? $transaction_data['transaction_id'] : '';
		// @todo "IP table logic"
		$data['PagseguroTransactionLog']['ip'] = $transaction_data['ip'];
		$data['PagseguroTransactionLog']['message'] = !empty($transaction_data['message']) ? $transaction_data['message'] : '';
		$data['PagseguroTransactionLog']['transaction_fee'] = !empty($transaction_data['transaction_fee']) ? $transaction_data['transaction_fee'] : '';
		$data['PagseguroTransactionLog']['company_address_id'] = !empty($transaction_data['company_address_id']) ? $transaction_data['company_address_id'] : 0;
		$data['PagseguroTransactionLog']['payment_method'] = $transaction_data['payment_method'];
        $this->set($data);
		$this->create();
		$this->save($data);
		return $this->getLastInsertId();
	}
}
?>