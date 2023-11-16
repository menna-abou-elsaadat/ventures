<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Transaction;

class PaymentService{

	public static function create($transaction_id,$amount,$paid_on,$details=null)
	{
		$transaction = Transaction::find($transaction_id);
		if ($transaction) {
			$payment  = new Payment();
			$payment->transaction_id = $transaction_id;
			$payment->amount = $amount;
			$payment->paid_on = date('Y-m-d',strtotime($paid_on));
			$payment->details = $details;
			$payment->save();

			$payment->transaction->updateStatus();
			return $payment;
		}

		return null;

		
	}
}
?>