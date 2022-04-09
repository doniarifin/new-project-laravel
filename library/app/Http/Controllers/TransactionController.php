<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Transaction;
use App\Models\Book;
use App\Models\Member;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


use function GuzzleHttp\Promise\all;

class TransactionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (auth()->user()->can('index transaction')) {
            $transactions = Transaction::all();
            $members = Member::all();
            $transactionDetails = TransactionDetail::all();
            $books = Book::all();

            return view('admin.transaction.index', compact('transactions', 'members', 'transactionDetails', 'books'));
        } else {
            return abort('403');
        }
        // atau if(auth()->user()->role('petugas')) //
    }

    public function api(Request $request)
    {

        if ($request->status) {
            $transactions = Transaction::select('transactions.id', 'date_start', 'date_end', 'name', 'status')
                ->join('members', 'members.id', '=', 'member_id')
                ->where('status', $request->status)->get();
        } else if ($request->date_start) {
            $transactions = Transaction::select('transactions.id', 'date_start', 'date_end', 'name', 'status')
                ->join('members', 'members.id', '=', 'member_id')
                ->where('date_start', $request->date_start)->get();
        } else {
            $transactions = Transaction::select('transactions.id', 'date_start', 'date_end', 'name', 'status')
                ->join('members', 'members.id', '=', 'member_id')
                ->get();
        }
        foreach ($transactions as $transaction) {
            if ($transaction->status == 0) {
                $transaction->status = "Masih dipinjam";
            } else {
                $transaction->status = "Sudah dikembalikan";
            }

            $total_books = TransactionDetail::selectRaw("SUM(qty) as totalBook")
                ->where('transaction_id', $transaction->id)
                ->get();
            foreach ($total_books as $total_book) {
                $transaction->total_book = $total_book->totalBook;
            }
            $total_prices = TransactionDetail::selectRaw("SUM(price * transaction_details.qty) as totalPrice")
                ->join('books', 'books.id', '=', 'book_id')
                ->where('transaction_id', $transaction->id)
                ->get();
            foreach ($total_prices as $total_price) {
                $transaction->total_price = formatRP($total_price->totalPrice);
            }

            $startDate = new DateTime($transaction->date_start); // atau new Carbon($transaction->date_start);
            $endDate   = new DateTime($transaction->date_end); // atau new Carbon($transaction->date_end);

            $transaction->long_day = ($startDate->diff($endDate)->days);

            // cara kedua

            // $fdate = $transaction->date_start;
            // $tdate = $transaction->date_end;
            // $datetime1 = new DateTime($fdate);
            // $datetime2 = new DateTime($tdate);
            // $interval = $datetime1->diff($datetime2);
            // $transaction->long_day = $interval->format('%a');
        }

        $datatables = datatables()->of($transactions)
            ->addColumn('date_start', function ($transaction) {
                return new_formatDate($transaction->date_start);
            })->addColumn('date_end', function ($transaction) {
                return new_formatDate($transaction->date_end);
            })->addIndexColumn();

        return $datatables->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $members = Member::all();
        $books = Book::all()->where('qty', '>', 0);

        return view('admin.transaction.create', compact('members', 'books'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $transaction = $request->validate([
            'member_id' => 'required',
            'date_start' => 'required',
            'date_end' => 'required',
            'book_id' => 'required',
        ]);

        $transaction = new Transaction;

        $transaction->member_id = $request->member_id;
        $transaction->date_start = $request->date_start;
        $transaction->date_end = $request->date_end;
        $transaction->status = 0;

        if ($transaction->save()) {

            foreach ($request->book_id as $book_id) {
                Book::where('id', $book_id)->decrement('qty');

                $transactionDetail = new TransactionDetail;

                $transactionDetail->transaction_id = $transaction->id;
                $transactionDetail->book_id = $book_id;
                $transactionDetail->qty = 1;
                $transactionDetail->save();
            }
        }

        return redirect('transactions');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        $members = Member::all();
        $transactionDetails = TransactionDetail::where('transaction_id', $transaction->id)->get();
        $books = Book::all();

        return view('admin.transaction.detail', compact('transaction', 'transactionDetails', 'members', 'books'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {

        $members = Member::all();
        $transactionDetails = TransactionDetail::all();
        $books = Book::all();

        return view('admin.transaction.edit', compact('transaction', 'transactionDetails', 'members', 'books'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        $transaction->update([
            'member_id' => $request->member_id,
            'date_start' => $request->date_start,
            'date_end' => $request->date_end,
            'status' => $request->status
        ]);

        foreach ($request->book_id as $book_id) {
            $t = TransactionDetail::where('transaction_id', $transaction->id)->update([
                'qty' => 0,
            ]);

            if ($request->status == 1) {
                Book::where('id', $book_id)->increment('qty');
            } else {
                Book::where('id', $book_id)->decrement('qty');
            }
        }

        $s = Transaction::select('book_id', 'transaction_details.qty as t_qty', 'books.id as b_id', 'books.qty as b_qty')->join('transaction_details', 'transactions.id', '=', 'transaction_id')->join('books', 'books.id', '=', 'book_id')->where('transaction_details.qty', 0)->get();


        foreach ($request->book_id as $book_id) {
            Book::where('id', $book_id)->decrement('qty');

            TransactionDetail::insert([
                'transaction_id' => $transaction->id,
                'book_id' => $book_id,
                'qty' => 1
            ]);
        }

        TransactionDetail::where('qty', 0)->delete();

        return redirect('transactions');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        $delete_td = TransactionDetail::where('transaction_id', $transaction->id)->delete();

        if ($delete_td) {
            $transaction->delete();
        } else {
            $transaction->delete();
        }

        return redirect('transactions');
    }
}
