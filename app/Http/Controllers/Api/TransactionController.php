<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\TransactionRequest;
use App\Services\TransactionService;
use Auth;
use App\Helpers\ApiResponse;
use App\Http\Resources\TransactionResource;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = TransactionService::AllTransactions(Auth::user());
        return TransactionResource::collection($transactions);

    }

    public function create(TransactionRequest $request)
    {

        $inputs = $request->input();
        $transaction = TransactionService::create($inputs['payer'],$inputs['amount'],$inputs['due_on'],$inputs['vat'],$inputs['is_vat_inclusive']);

        if (!$transaction) {
            return ApiResponse::sendResponse(400,'Please register the payer email to complete',null);
        }

        $data['id'] = $transaction->id;
        $data['payer_email'] = $transaction->user->email;
        $data['amount'] = $transaction->amount;
        $data['total_amount'] = $transaction->total_amount;
        $data['due_on'] = $transaction->due_on;
        $data['status'] = $transaction->status;

         return ApiResponse::sendResponse(201,'Transaction Created Successfully',$data);

    }
}
