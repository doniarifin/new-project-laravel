@extends('layouts.admin')

@section('header', 'Transaction')

@section('css')
{{-- datatables --}}
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

@section('content')

@can('index transaction') 
{{-- atau @role('petugas') // @endrole --}}
<div id="controller">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <a href="{{ url('transactions/create') }}" class="btn btn-sm btn-primary pull-right">Create New Transaction</a>
                </div>
                <div class="col-md-3">
                    <select class="form-control" name="status">
                        <option value="">Status</option>
                        <option value="N">Masih dipinjam</option>
                        <option value="1">Sudah dikembalikan</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-control" name="date_start">
                        <option value="">Tanggal pinjam</option>
                        @foreach ($transactions as $transaction)
                        <option value="{{ $transaction->date_start }}">{{ new_formatDate($transaction->date_start) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
                    <!-- /.card-header -->
        <div class="card-body">
            <div class="row">
                <div class="col-md-12" style="overflow-x:auto;">
                    <table id="datatable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Name</th>
                                <th>Long Borrowed</th>
                                <th>Total Book</th>
                                <th>Total Price</th>
                                <th>Status</th>
                                <th class='text-center'>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endcan
 
@endsection

@section('js')
<!-- DataTables  & Plugins -->
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('assets/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<script type="text/javascript">
    var actionUrl = '{{ url('transactions') }}';
    var apiUrl = '{{ url('api/transactions') }}'
    var columns = [
        {data: 'date_start', class: 'text-center', orderable: true},
        {data: 'date_end', class: 'text-center', orderable: true},
        {data: 'name', class: 'text-center', orderable: true},
        {data: 'long_day', class: 'text-center', orderable: true},
        {data: 'total_book', class: 'text-center', orderable: true},
        {data: 'total_price', class: 'text-center', orderable: true},
        {data: 'status', class: 'text-center', orderable: true},
        {render: function (index, row, data, meta) {
            return `
                <a href="{{ url('transactions/'.'${data.id}'.'/edit') }}" type="button" class="btn btn-warning btn-sm">
                    Edit
                </a>
                <a href="{{ url('transactions/'.'${data.id}') }}" type="button" class="btn btn-primary btn-sm">
                    Detail
                </a>
                <a class="btn btn-danger btn-sm" onclick="controller.deleteData(event, ${data.id})">
                    Delete 
                </a>` ;
        }, orderable: false, width: '200px', class: 'text-center'},
    ];
    var controller = new Vue({
    el: '#controller',
    data: {
        datas: [],
        data: {},
        actionUrl,
        apiUrl,
        editStatus: false,
    },
    mounted: function () {
        this.datatable();
    },
    methods: {
        datatable() {
            const _this = this;
            _this.table = $('#datatable').DataTable({
                ajax: {
                    url: _this.apiUrl,
                    type: 'GET',
                },
                columns: columns,
            }).on('xhr', function () {
                _this.datas = _this.table.ajax.json().data;
            });
        },
        deleteData(event, id) {
            if (confirm("Are you sure?")) {
                $(event.target).parents('tr').remove();
                axios.post(this.actionUrl + '/' + id, { _method: 'DELETE' }).then(response => {
                    alert('Data has been removed!');
                });
            }
        },
      }
    });

    $('select[name=status]').on('change', function(){
        status = $('select[name=status]').val();

        if (status == "" ) {
            controller.table.ajax.url(apiUrl).load();
        } else {
            controller.table.ajax.url(apiUrl+'?status='+status).load();
        }
    });
        $('select[name=date_start]').on('change', function(){
        date_start = $('select[name=date_start]').val();

        if (date_start == "" ) {
            controller.table.ajax.url(apiUrl).load();
        } else {
            controller.table.ajax.url(apiUrl+'?date_start='+date_start).load();
        }
    });
</script>

@endsection