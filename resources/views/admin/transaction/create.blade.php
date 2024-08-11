@extends('layouts.admin')


@section('css')
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css?v=3.2.0')}}">
@endsection

@section('header', 'Transaction')

@section('content')
    <div class="row">
        <!-- left column -->
        <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Create New Transaction</h3>
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
              
              <form action="{{ url('transactions') }}" method="post">
                @csrf
                  <div class="card-body">
                      <div class="form-group">
                            <label>Start Date</label>
                                <input type="date" name="date_start" class="form-control" required="">
                            <label>End Date</label>
                                <input type="date" name="date_end" class="form-control" required="">
                            <div class="form-group">
                                <label>Name</label>
                                    <select name="member_id" class="form-control" data-placeholder="Select Member">
                                        @foreach($members as $member)
                                        <option value="{{ $member->id }}">{{ $member->name }}</option>
                                        @endforeach
                                    </select>
                            </div>
                            <div class="form-group">
                                <label>Book Title</label>
                                    <select multiple="multiple" name="book_id[]" class="select2" data-placeholder="Select Book" style="width: 100%">
                                         @foreach($books as $book)
                                        <option value="{{ $book->id }}">{{ $book->title }}</option>
                                         @endforeach
                                    </select>
                            </div>
                      </div>
                  </div>
      
                  <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
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
</script>
@endsection