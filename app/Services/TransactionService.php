<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\User;

class TransactionService{

	public static function create($customer_email,$amount,$due_on,$vat,$is_vat_inclusive)
	{
		$customer = User::where('email',$customer_email)->first();
		if (!$customer) {
			return null;
		}
		if (!$is_vat_inclusive) {
			
			$total_amount = $amount + ($amount * $vat / 100);
		}
		else
		{
			$total_amount = $amount;
		}

		$transaction = new Transaction;
		$transaction->user_id = $customer->id;
		$transaction->amount = $amount;
		$transaction->total_amount = $total_amount;
		$transaction->due_on = date('Y-m-d', strtotime($due_on));
		$transaction->vat = $vat;
		$transaction->is_vat_inclusive = $is_vat_inclusive;
		$transaction->save();

		$transaction->updateStatus();

		return $transaction;
	}

	public static function AllTransactions($user)
	{
		if ($user->role == 'Admin') {
			
			return Transaction::get();
		}

		else if($user->role == 'Customer')
		{
			return Transaction::where('user_id',$user->id)->get();
		}


	}
}
?>