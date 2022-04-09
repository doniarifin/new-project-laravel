@extends('layouts.admin')

@section('header', 'Home')

@section('content')

<div class="row">
    <div class="col-lg-3 col-6">
    
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $totalBook }}</h3>
                    <p>Total Book</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
                <a href="{{ url('books') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
    
    <div class="small-box bg-success">
        <div class="inner">
            <h3>{{ $totalAuthor }}</sup></h3>
                <p>Total Author</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
                <a href="{{ url('authors') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
    
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $publisherData }}</h3>
                <p>Publishers Data</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ url('publishers') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $transactionData }}</h3>
                <p>Transactions Data</p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
                <a href="{{ url('transactions') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title">Publishers Chart</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                </div>
            <div class="card-body">
                <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6">
    <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">Transactions Chart</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                </div>
            </div>
            <div class="card-body">
                <div class="chart">
                    <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/plugins/chart.js/Chart.min.js') }}"></script>

<script type="text/javascript">
    $(function () {
        
    var label_donut = '{!! json_encode($label_donut) !!}';
    var data_donut = '{!! json_encode($data_donut) !!}';
    var data_bar = '{!! json_encode($data_bar) !!}';

    //- DONUT CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var donutChartCanvas = $('#donutChart').get(0).getContext('2d');
    var donutData = {
      labels: JSON.parse(label_donut),
      datasets: [
        {
          data: JSON.parse(data_donut),
          backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de', '#56f0ef', '#FF69B4', '#FF00FF', '#7FFF00', '#FF8C00', '#f39j82'],
        }
      ]
    };

    var donutOptions = {
      maintainAspectRatio : false,
      responsive : true,
    }
     //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(donutChartCanvas, {
      type: 'doughnut',
      data: donutData,
      options: donutOptions
    });
    // Get context with jQuery - using jQuery's .get() method.

    var areaChartData = {
      labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
      datasets: JSON.parse(data_bar)
    };
     //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChart').get(0).getContext('2d')
    var barChartData = $.extend(true, {}, areaChartData)
    // var temp0 = areaChartData.datasets[0]
    // var temp1 = areaChartData.datasets[1]
    // barChartData.datasets[0] = temp1
    // barChartData.datasets[1] = temp0

    var barChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false
    };

    new Chart(barChartCanvas, {
      type: 'bar',
      data: barChartData,
      options: barChartOptions
    })
})

</script>
