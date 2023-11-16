<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function updateStatus()
    {
        $total_paid = $this->payments()->sum('amount');
        if ($total_paid == $this->total_amount) {
            $this->status = 'paid';
            $this->save();
        }
        if ($total_paid < $this->total_amount && strtotime($this->due_on) < strtotime(date('y-m-d'))) {
            $this->status = 'overdue';
            $this->save();
        }
    }
}