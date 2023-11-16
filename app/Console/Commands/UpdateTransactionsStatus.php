<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaction;

class UpdateTransactionsStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update-transactions-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update transactions status';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $transactions = Transaction::where('status','outstanding')->get();
        foreach ($transactions as $key => $transaction) {
            $transaction->updateStatus();
        }
    }
}
