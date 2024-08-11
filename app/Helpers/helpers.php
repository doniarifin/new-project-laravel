<?php

use App\Models\Transaction;
use Illuminate\Support\Carbon;


function convert_date($value)
{
    return date('H:i:s - d M Y', strtotime($value));
}

function new_formatDate($value)
{
    return date('d M Y', strtotime($value));
}

function formatRP($angka)
{
    $hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');
    return $hasil_rupiah;
}

function dateExpired()
{

    $current_day = Carbon::now();

    $transactions = Transaction::select('transactions.id as tr_id', 'date_end', 'name')
        ->join('members', 'members.id', '=', 'member_id')
        ->where('date_end', '<=', $current_day)
        ->where('status', '=', 0)->get();

    foreach ($transactions as $transaction) {
        $now = Carbon::now(); // atau new DateTime();
        $endDate = new Carbon($transaction->date_end); // atau new DateTime($transaction->date_end);

        $transaction->long_day = ($now->diff($endDate)->days);

        if ($transaction->long_day == 0) {
            $transaction->long_day = "hari terakhir";
        } else {
            $transaction->long_day = "telat $transaction->long_day hari";
        }
    }

    return $transactions;
}

function jumlahDateExpired()
{
    return count(dateExpired());
}
