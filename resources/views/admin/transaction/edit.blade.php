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
          <h3 class="card-title">Edit Transaction</h3>
        </div>
        
        {{-- menampilkan error validasi --}}
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        
        <form action="{{ url('transactions/'.$transaction->id) }}" method="post">
          @csrf
          {{ method_field('PUT') }}

            <div class="card-body">
                <div class="form-group">
                <label>Member Name</label>
                    <select name="member_id" class="form-control">
                        @foreach($members as $member)
                        <option @if($transaction->member_id == $member->id) selected='selected' @endif value="{{ $member->id }}">{{ $member->name }}</option>
                        @endforeach
                    </select>
                <label>Start Date</label>
                    <input type="date" name="date_start" class="form-control" required="" value="{{ $transaction->date_start }}">
                <label>End Date</label>
                    <input type="date" name="date_end" class="form-control" required="" value="{{ $transaction->date_end }}">
                <label>Book</label>
                    <select multiple="multiple" name="book_id[]" class="select2" style="width: 100%">
                        @foreach ($transactionDetails as $i => $td)
                            @foreach($books as $book)
                                <option {{$td->book_id == $book->id ? 'selected' : ''}} value="{{ $book->id }}">{{ $book->title }}</option>
                            @endforeach    
                        @endforeach
                    </select>
                <br>
                <div>
                    <label for="status">Status :</label>
                </div>
                <div class="form-check form-check-inline">
                    <label for="status">
                        <div class="form-control border-0">
                            <input type="radio" name="status" value="0" id="radio_1" {{$transaction->status == 0 ? 'checked' : ''}}>
                            <label for="radio_1"> Masih dipinjam </label>
                        </div>
                        <div class="form-control border-0">
                            <input type="radio" name="status" value="1" id="radio_2" {{$transaction->status == 1 ? 'checked' : ''}}>
                            <label for="radio_2"> Sudah dikembalikan </label>
                        </div>
                    </label>
                </div>
            </div>

            <div class="card-footer">
                  <button id="submit-data" disabled="" type="submit" class="btn btn-primary">Save</button>
                  <a href="{{ url('transactions') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js')}}"></script>
<script src="{{ asset('assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js')}}"></script>
<script type="text/javascript">
    $(function () {
        $('.select2').select2()
    });

    // disable save button jika tidak ada perubahaan

    $('form')
		.each(function(){
			$(this).data('serialized', $(this).serialize())
		})
        .on('change input', function(){
            $(this)				
                .find('input:submit, button:submit')
                    .attr('disabled', $(this).serialize() == $(this).data('serialized'))
            ;
         })
		.find('input:submit, button:submit')
			.attr('disabled', true)
	;

</script>

@endsection