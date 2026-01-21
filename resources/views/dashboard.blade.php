@extends('layouts.admin.app')

@section('title')
لوحة التحكم
@endsection

@section('content')
<div class="app-title">
    <div>
        <h1><i class="fa fa-dashboard"></i> لوحة التحكم</h1>
        <p>الاحصائيات</p>
    </div>
</div>

<div class="row">
    <!-- Statistics Cards -->
    <div class="col-md-6 col-lg-3">
        <div class="widget-small primary coloured-icon">
            <i class="icon fa fa-users fa-3x"></i>
            <div class="info">
                <h4>إجمالي العملاء</h4>
                <p><b>{{ \App\Models\User::where('type', 'client')->count() }}</b></p>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-3">
        <div class="widget-small info coloured-icon">
            <i class="icon fa fa-user-md fa-3x"></i>
            <div class="info">
                <h4>إجمالي الأطباء</h4>
                <p><b>{{ \App\Models\User::where('type', 'doctor')->count() }}</b></p>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-3">
        <div class="widget-small warning coloured-icon">
            <i class="icon fa fa-user-plus fa-3x"></i>
            <div class="info">
                <h4>تسجيلات اليوم</h4>
                <p><b>{{ \App\Models\User::whereIn('type', ['client', 'doctor'])->whereDate('created_at', today())->count() }}</b></p>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-3">
        <div class="widget-small danger coloured-icon">
            <i class="icon fa fa-calendar fa-3x"></i>
            <div class="info">
                <h4>تسجيلات هذا الشهر</h4>
                <p><b>{{ \App\Models\User::whereIn('type', ['client', 'doctor'])->whereMonth('created_at', now()->month)->count() }}</b></p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-title-w-btn">
                <h3 class="title"><i class="fa fa-line-chart"></i> إحصائيات الحسابات الجديده المنضمه</h3>
                <div class="btn-group" role="group">
                    <a href="?period=days" class="btn btn-sm {{ $period == 'days' ? 'btn-primary' : 'btn-secondary' }}">
                        <i class="fa fa-calendar-o"></i> الأيام
                    </a>
                    <a href="?period=months" class="btn btn-sm {{ $period == 'months' ? 'btn-primary' : 'btn-secondary' }}">
                        <i class="fa fa-calendar"></i> الشهور
                    </a>
                    <a href="?period=years" class="btn btn-sm {{ $period == 'years' ? 'btn-primary' : 'btn-secondary' }}">
                        <i class="fa fa-calendar-check-o"></i> السنوات
                    </a>
                </div>
            </div>
            <div class="tile-body">
                <canvas id="userRegistrationChart" style="height: 400px;"></canvas>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    const ctx = document.getElementById('userRegistrationChart').getContext('2d');
    
    const data = {
        labels: @json($stats['labels']),
        datasets: [
            {
                label: 'العملاء',
                data: @json($stats['clients']),
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: 'rgba(54, 162, 235, 1)',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: 'rgba(54, 162, 235, 1)',
                pointRadius: 4,
                pointHoverRadius: 6
            },
            {
                label: 'الأطباء',
                data: @json($stats['doctors']),
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: 'rgba(75, 192, 192, 1)',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: 'rgba(75, 192, 192, 1)',
                pointRadius: 4,
                pointHoverRadius: 6
            }
        ]
    };
    
    const config = {
        type: 'line',
        data: data,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        font: {
                            family: 'Cairo',
                            size: 14
                        },
                        padding: 15,
                        usePointStyle: true
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.8)',
                    padding: 12,
                    titleFont: {
                        family: 'Cairo',
                        size: 14
                    },
                    bodyFont: {
                        family: 'Cairo',
                        size: 13
                    },
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.parsed.y + ' مستخدم';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        font: {
                            family: 'Cairo',
                            size: 12
                        }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    ticks: {
                        font: {
                            family: 'Cairo',
                            size: 12
                        }
                    },
                    grid: {
                        display: false
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    };
    
    new Chart(ctx, config);
});
</script>
@endpush

@endsection