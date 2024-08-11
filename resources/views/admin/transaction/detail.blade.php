@extends('layouts.admin')

@section('header', 'Transaction')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css?v=3.2.0')}}">
@endsection

@section('content')
<div class="row">
    <!-- left column -->
    <div class="col-md-6">
      <!-- general form elements -->
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Detail Peminjaman</h3>
        </div>
        
        <form>
            <div class="card-body">
                <div class="form-group">
                <label>Nama Anggota</label>
                    <div class="col-md-6">
                        <div class="form-control border-0">
                            <span>{{($transaction->member->name)}}</span>
                        </div>
                    </div>
                    <br>
                <label>Tanggal Peminjaman</label>
                    <div class="col-md-4">
                        <div class="form-control">
                            <span>{{ new_FormatDate($transaction->date_start) }}</span>
                        </div>
                    </div>
                <label>sampai</label>
                    <div class="col-md-4">
                        <div class="form-control">
                            <span>{{ new_FormatDate($transaction->date_end) }}</span>
                        </div>
                    </div>
                <br>
                <label>Book title</label>
                <div class="form-group">
                    <div>
                        @foreach($transactionDetails as $key => $value)
                            <ul>
                                <li>{{ ($value->book->title) }}</li>
                            </ul>
                        @endforeach
                    </div>
                </div>
                <br>
                <label for="status">Status</label>
                <div class="form-control border-0">
                        <div class="col-md-6">
                            @if ($transaction->status === 0)
                            <span style="font-weight: bold">Masih dipinjam</span>
                            @else
                            <span style="font-weight: bold">Sudah dikembalikan</span>
                            @endif
                        </div>
                 </div>
                </div>
            </div>

            <div class="card-footer">
                <a href="{{ url('transactions') }}" class="btn btn-secondary">All Transactions</a>
            </div>
        </form>
        </div>
    </div>
</div>
@endsection

@section('js')

@endsection