<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\PaymentRequest;
use App\Services\PaymentService;
use App\Helpers\ApiResponse;

class PaymentController extends Controller
{
    public function create(PaymentRequest $request)
    {
        $inputs = $request->input();
        $payment = PaymentService::create($inputs['transaction_id'],$inputs['amount'],$inputs['paid_on'],isset($inputs['details'])?$inputs['details']:null);
        if ($payment) {
            $data['payment_amount'] = $payment->amount;
            $data['details'] = $payment->details;
            $data['transaction_total_amount'] = $payment->transaction->total_amount;
            $data['transaction_status'] = $payment->transaction->status;
           
           return ApiResponse::sendResponse(201,'Payment Created Successfully',$data);
        }

        return ApiResponse::sendResponse(400,'Kindly confirm the transaction id',null);
        

    }
}
