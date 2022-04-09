@extends('layouts.admin')

@section('header', 'Catalog')

@section('content')
<div class="row">
    <!-- left column -->
    <div class="col-md-6">
      <!-- general form elements -->
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Create New Catalog</h3>
        </div>
        
        {{-- menampilkan error validasi --}}
        @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ url('catalogs') }}" method="post">
          @csrf
            <div class="card-body">
                <div class="form-group">
                  <label>Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter name" required="">
                </div>
            </div>

            <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>

@endsection