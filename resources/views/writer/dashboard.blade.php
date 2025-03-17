@extends('layouts.dashboard')

@section('styles')
    <style>
        /* Styling untuk membuat layout lebih konsisten */
        .card {
            height: 100%;
            transition: transform 0.2s, box-shadow 0.2s;
            margin-bottom: 1.5rem;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 1.5rem;
        }

        .stats-card {
            border-radius: 0.5rem;
            overflow: hidden;
        }

        .activity-item {
            padding: 0.75rem 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        /* Memperbaiki alignment */
        .card-title {
            margin-bottom: 1rem;
        }

        /* Perbaikan responsif */
        @media (max-width: 768px) {
            .stats-row .col-md-6 {
                margin-bottom: 1rem;
            }

            .welcome-card .col-sm-7,
            .welcome-card .col-sm-5 {
                text-align: center !important;
            }

            .welcome-card img {
                margin: 0 auto;
                display: block;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Welcome Card Row -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card welcome-card">
                    <div class="d-flex align-items-center row">
                        <div class="col-sm-7 col-12">
                            <div class="card-body">
                                <h5 class="card-title text-primary">Congratulations {{ $user->name }}! 🎉</h5>
                                <p class="mb-4">
                                    You have created <span class="fw-bold">{{ $totalArticles }}</span> articles.
                                    Check your dashboard for detailed statistics.
                                </p>
                                <a href="{{ route('articles.create') }}" class="btn btn-sm btn-primary">Create New
                                    Article</a>
                            </div>
                        </div>
                        <div class="col-sm-5 col-12 text-center">
                            <div class="card-body pb-0 px-0 px-md-4">
                                <img src="{{ asset('assets/img/illustrations/man-with-laptop-light.png') }}" height="140"
                                    alt="Writer Dashboard" data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                    data-app-light-img="illustrations/man-with-laptop-light.png" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards Row -->
        <div class="row stats-row mb-4">
            <div class="col-xl-3 col-md-6 col-sm-6 col-12">
                <div class="card stats-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="avatar flex-shrink-0">
                                <span class="avatar-initial rounded bg-label-primary">
                                    <i class="bx bx-check-circle"></i>
                                </span>
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="{{ route('articles.index') }}">View All</a>
                                </div>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Approved Articles</span>
                        <h3 class="card-title mb-2">{{ $approvedArticles }}</h3>
                        <small class="text-success fw-semibold">
                            <i class="bx bx-up-arrow-alt"></i>
                            {{ $approvedArticles > 0 && $totalArticles > 0 ? number_format(($approvedArticles / $totalArticles) * 100, 2) : 0 }}%
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 col-sm-6 col-12">
                <div class="card stats-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="avatar flex-shrink-0">
                                <span class="avatar-initial rounded bg-label-info">
                                    <i class="bx bx-show"></i>
                                </span>
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="javascript:void(0);">Details</a>
                                </div>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Total Views</span>
                        <h3 class="card-title mb-2">{{ number_format($totalViews) }}</h3>
                        <small class="text-info fw-semibold">
                            <i class="bx bx-line-chart"></i>
                            {{ $totalArticles > 0 ? number_format($totalViews / $totalArticles, 1) : 0 }} per article
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 col-sm-6 col-12">
                <div class="card stats-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="avatar flex-shrink-0">
                                <span class="avatar-initial rounded bg-label-success">
                                    <i class="bx bx-heart"></i>
                                </span>
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="javascript:void(0);">Details</a>
                                </div>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Total Likes</span>
                        <h3 class="card-title mb-2">{{ number_format($totalLikes) }}</h3>
                        <small class="text-success fw-semibold">
                            <i class="bx bx-up-arrow-alt"></i>
                            {{ $totalArticles > 0 ? number_format($totalLikes / $totalArticles, 1) : 0 }} per article
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 col-sm-6 col-12">
                <div class="card stats-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="avatar flex-shrink-0">
                                <span class="avatar-initial rounded bg-label-warning">
                                    <i class="bx bx-dollar"></i>
                                </span>
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="javascript:void(0);">Earnings Details</a>
                                </div>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Total Earnings</span>
                        <h3 class="card-title mb-2">Rp {{ number_format($totalEarnings) }}</h3>
                        <small class="text-warning fw-semibold">
                            <i class="bx bx-wallet"></i>
                            Rp {{ $approvedArticles > 0 ? number_format($totalEarnings / $approvedArticles) : 0 }} per
                            article
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row mb-4">
            <!-- Article Performance Chart -->
            <div class="col-xl-8 col-lg-7 col-md-12 mb-4">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0">Article Performance</h5>
                        <div class="d-flex align-items-center">
                            <div class="chart-legend d-flex me-3">
                                <div class="d-flex align-items-center me-2">
                                    <span class="bullet bullet-primary me-1"
                                        style="width:8px; height:8px; border-radius:50%; display:inline-block; background-color:#696cff;"></span>
                                    <small>Articles</small>
                                </div>
                                <div class="d-flex align-items-center me-2">
                                    <span class="bullet bullet-info me-1"
                                        style="width:8px; height:8px; border-radius:50%; display:inline-block; background-color:#03c3ec;"></span>
                                    <small>Views</small>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="bullet bullet-success me-1"
                                        style="width:8px; height:8px; border-radius:50%; display:inline-block; background-color:#71dd37;"></span>
                                    <small>Likes</small>
                                </div>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button"
                                    id="performanceDropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    {{ date('Y') }}
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="performanceDropdown">
                                    <a class="dropdown-item" href="javascript:void(0);">{{ date('Y') - 1 }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pb-3">
                        <div id="articlePerformanceChart" style="min-height: 350px;"></div>
                    </div>
                </div>
            </div>

            <!-- Content Status Chart -->
            <div class="col-xl-4 col-lg-5 col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0">Content Status</h5>
                        <span class="badge bg-label-primary rounded-pill">{{ date('Y') }}</span>
                    </div>
                    <div class="card-body d-flex flex-column align-items-center justify-content-center">
                        <div id="contentStatusChart" style="min-height: 220px; width: 100%;"></div>
                        <div class="text-center mt-3">
                            <h5 class="mb-0">{{ $approvedArticles }}/{{ $totalArticles }}</h5>
                            <span class="text-muted">Approved Articles</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Category and Activities Row -->
        <div class="row">
            <!-- Kategori Artikel -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0">Article Categories</h5>
                        <div class="dropdown">
                            <button class="btn p-0" type="button" id="categoryMenu" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="categoryMenu">
                                <a class="dropdown-item" href="{{ route('articles.index') }}">View All</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="d-flex justify-content-between align-items-center py-3 border-bottom">
                            <h2 class="mb-0">{{ $totalArticles }}</h2>
                            <span class="text-muted">Total Articles</span>
                        </div>

                        <ul class="p-0 m-0 mt-3">
                            @forelse($articlesByCategory as $category)
                                <li class="d-flex align-items-center mb-2 py-1">
                                    <div class="avatar flex-shrink-0 me-2" style="width:32px;height:32px;">
                                        <span class="avatar-initial rounded bg-label-primary" style="font-size:0.85rem;">
                                            <i class="bx bx-book-content"></i>
                                        </span>
                                    </div>
                                    <div class="d-flex w-100 align-items-center justify-content-between">
                                        <div>
                                            <span class="d-block">{{ $category->name }}</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="me-2 text-muted small">{{ $category->total }} articles</span>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="bx bx-category mb-2 d-block" style="font-size: 1.5rem;"></i>
                                        <p class="mb-0">No categories used in your articles yet</p>
                                    </div>
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Recent Activities -->
            <div class="col-lg-4 col-md-12 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0">Recent Activities</h5>
                        <button class="btn btn-sm btn-outline-primary">View All</button>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @forelse($recentActivities as $activity)
                                <li class="list-group-item px-4">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-shrink-0 me-3">
                                            @if ($activity->img)
                                                <img src="{{ asset('storage/images/articles/' . $activity->img) }}"
                                                    class="rounded" width="40" alt="Article Image">
                                            @else
                                                <div class="avatar avatar-sm">
                                                    <span
                                                        class="avatar-initial rounded bg-label-{{ $activity->action == 'create' ? 'success' : ($activity->action == 'edit' ? 'warning' : 'danger') }}">
                                                        <i
                                                            class="bx bx-{{ $activity->action == 'create' ? 'plus' : ($activity->action == 'edit' ? 'edit' : 'trash') }}"></i>
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="w-100">
                                            <div class="d-flex justify-content-between mb-1">
                                                <span
                                                    class="badge bg-label-{{ $activity->action == 'create' ? 'success' : ($activity->action == 'edit' ? 'warning' : 'danger') }}">{{ ucfirst($activity->action) }}</span>
                                                <small
                                                    class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                                            </div>
                                            <p class="mb-0 text-wrap">{!! $activity->details !!}</p>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li class="list-group-item text-center py-5">
                                    <div class="text-muted">
                                        <i class="bx bx-info-circle mb-2 d-block" style="font-size: 2rem;"></i>
                                        <p class="mb-0">No recent activities found</p>
                                    </div>
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Engagement Metrics -->
            <div class="col-lg-5 col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <ul class="nav nav-tabs card-header-tabs nav-fill mb-0">
                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab"
                                    data-bs-target="#engagement-tab">Engagement</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab"
                                    data-bs-target="#earnings-tab">Earnings</button>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="engagement-tab">
                                <div class="d-flex align-items-center mb-3 mt-2">
                                    <div class="avatar-sm flex-shrink-0 me-3">
                                        <span class="avatar-initial rounded bg-label-info">
                                            <i class="bx bx-pulse"></i>
                                        </span>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Total Engagement</h6>
                                        <span
                                            class="text-muted">{{ number_format($totalViews + $totalLikes + $totalShares) }}
                                            interactions</span>
                                    </div>
                                </div>

                                <div class="row g-3 mt-2">
                                    <div class="col-4 text-center">
                                        <div class="card shadow-none bg-light mb-0">
                                            <div class="card-body py-3">
                                                <h3 class="mb-1">{{ number_format($totalViews) }}</h3>
                                                <p class="mb-0 text-muted">Views</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4 text-center">
                                        <div class="card shadow-none bg-light mb-0">
                                            <div class="card-body py-3">
                                                <h3 class="mb-1">{{ number_format($totalLikes) }}</h3>
                                                <p class="mb-0 text-muted">Likes</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4 text-center">
                                        <div class="card shadow-none bg-light mb-0">
                                            <div class="card-body py-3">
                                                <h3 class="mb-1">{{ number_format($totalShares) }}</h3>
                                                <p class="mb-0 text-muted">Shares</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="engagement-metrics mt-4">
                                    <h6 class="mb-3">Engagement Breakdown</h6>
                                    <div class="progress-wrapper mb-3">
                                        <div class="d-flex justify-content-between mb-1">
                                            <span>Views</span>
                                            <span>{{ number_format(($totalViews / ($totalViews + $totalLikes + $totalShares)) * 100, 1) }}%</span>
                                        </div>
                                        <div class="progress" style="height: 6px;">
                                            <div class="progress-bar bg-info" role="progressbar"
                                                style="width: {{ ($totalViews / ($totalViews + $totalLikes + $totalShares)) * 100 }}%"
                                                aria-valuenow="{{ ($totalViews / ($totalViews + $totalLikes + $totalShares)) * 100 }}"
                                                aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <div class="progress-wrapper mb-3">
                                        <div class="d-flex justify-content-between mb-1">
                                            <span>Likes</span>
                                            <span>{{ number_format(($totalLikes / ($totalViews + $totalLikes + $totalShares)) * 100, 1) }}%</span>
                                        </div>
                                        <div class="progress" style="height: 6px;">
                                            <div class="progress-bar bg-primary" role="progressbar"
                                                style="width: {{ ($totalLikes / ($totalViews + $totalLikes + $totalShares)) * 100 }}%"
                                                aria-valuenow="{{ ($totalLikes / ($totalViews + $totalLikes + $totalShares)) * 100 }}"
                                                aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <div class="progress-wrapper">
                                        <div class="d-flex justify-content-between mb-1">
                                            <span>Shares</span>
                                            <span>{{ number_format(($totalShares / ($totalViews + $totalLikes + $totalShares)) * 100, 1) }}%</span>
                                        </div>
                                        <div class="progress" style="height: 6px;">
                                            <div class="progress-bar bg-success" role="progressbar"
                                                style="width: {{ ($totalShares / ($totalViews + $totalLikes + $totalShares)) * 100 }}%"
                                                aria-valuenow="{{ ($totalShares / ($totalViews + $totalLikes + $totalShares)) * 100 }}"
                                                aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="earnings-tab">
                                <!-- Isi konten Earnings tab -->
                                <div class="d-flex align-items-center mb-3">
                                    <div class="avatar-sm flex-shrink-0 me-3">
                                        <span class="avatar-initial rounded bg-label-success">
                                            <i class="bx bx-money"></i>
                                        </span>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Total Earnings</h6>
                                        <span class="text-muted">Rp {{ number_format($totalEarnings) }}</span>
                                    </div>
                                </div>

                                <div class="earnings-breakdown mt-3">
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Source</th>
                                                    <th>Rate</th>
                                                    <th>Count</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Views</td>
                                                    <td>Rp 15</td>
                                                    <td>{{ number_format($totalViews) }}</td>
                                                    <td>Rp {{ number_format($totalViews * 15) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Likes</td>
                                                    <td>Rp 150</td>
                                                    <td>{{ number_format($totalLikes) }}</td>
                                                    <td>Rp {{ number_format($totalLikes * 150) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Shares</td>
                                                    <td>Rp 550</td>
                                                    <td>{{ number_format($totalShares) }}</td>
                                                    <td>Rp {{ number_format($totalShares * 550) }}</td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr class="table-active">
                                                    <th colspan="3">Total Earnings</th>
                                                    <th>Rp {{ number_format($totalEarnings) }}</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Gunakan fungsi responsive untuk chart
            function createResponsiveChart(options) {
                const defaultOptions = {
                    chart: {
                        toolbar: {
                            show: false
                        },
                        zoom: {
                            enabled: false
                        },
                        animations: {
                            enabled: true
                        },
                        fontFamily: 'Public Sans, sans-serif',
                    },
                    grid: {
                        borderColor: '#f1f1f1',
                        strokeDashArray: 4,
                        padding: {
                            left: 0,
                            right: 0
                        }
                    },
                    tooltip: {
                        theme: 'light'
                    }
                };

                return new ApexCharts(
                    document.querySelector(options.element),
                    Object.assign({}, defaultOptions, options.config)
                );
            }

            // Article Performance Chart
            if (document.querySelector('#articlePerformanceChart')) {
                createResponsiveChart({
                    element: '#articlePerformanceChart',
                    config: {
                        series: [{
                            name: 'Articles',
                            type: 'column',
                            data: @json($articleCounts)
                        }, {
                            name: 'Views',
                            type: 'line',
                            data: @json($viewCounts)
                        }, {
                            name: 'Likes',
                            type: 'line',
                            data: @json($likeCounts)
                        }],
                        chart: {
                            type: 'line',
                            height: 350,
                            stacked: false,
                            toolbar: {
                                show: false
                            }
                        },
                        colors: ['#696cff', '#03c3ec', '#71dd37'],
                        stroke: {
                            width: [0, 3, 3],
                            curve: 'smooth'
                        },
                        plotOptions: {
                            bar: {
                                columnWidth: '50%',
                                borderRadius: 5
                            }
                        },
                        fill: {
                            opacity: [1, 0.3, 0.3]
                        },
                        markers: {
                            size: 4,
                            hover: {
                                size: 6
                            }
                        },
                        xaxis: {
                            categories: @json($months),
                            labels: {
                                style: {
                                    fontSize: '12px',
                                    fontFamily: 'Public Sans, sans-serif'
                                }
                            },
                            axisBorder: {
                                show: false
                            },
                            axisTicks: {
                                show: false
                            }
                        },
                        yaxis: {
                            labels: {
                                style: {
                                    fontSize: '12px',
                                    fontFamily: 'Public Sans, sans-serif'
                                },
                                formatter: function(val) {
                                    return val.toFixed(0);
                                }
                            }
                        },
                        grid: {
                            borderColor: '#f1f1f1',
                            padding: {
                                top: 0,
                                right: 20,
                                bottom: 0,
                                left: 20
                            }
                        },
                        legend: {
                            show: false // Legenda sudah dibuat secara manual di header
                        },
                        tooltip: {
                            shared: true,
                            intersect: false,
                            y: {
                                formatter: function(y) {
                                    if (typeof y !== "undefined") {
                                        return y.toFixed(0);
                                    }
                                    return y;
                                }
                            }
                        },
                        responsive: [{
                            breakpoint: 600,
                            options: {
                                yaxis: {
                                    show: false
                                },
                                grid: {
                                    padding: {
                                        left: 10,
                                        right: 10
                                    }
                                }
                            }
                        }]
                    }
                }).render();
            }

            // Content Status Chart
            if (document.querySelector('#contentStatusChart')) {
                createResponsiveChart({
                    element: '#contentStatusChart',
                    config: {
                        series: [{{ $approvedArticles }}, {{ $pendingArticles }},
                            {{ $rejectedArticles }}
                        ],
                        chart: {
                            height: 240,
                            type: 'donut',
                        },
                        labels: ['Approved', 'Pending', 'Rejected'],
                        colors: ['#71dd37', '#ffab00', '#ff3e1d'],
                        stroke: {
                            width: 2
                        },
                        dataLabels: {
                            enabled: false
                        },
                        plotOptions: {
                            pie: {
                                donut: {
                                    size: '75%',
                                    labels: {
                                        show: true,
                                        total: {
                                            show: true,
                                            label: 'Approval',
                                            formatter: function(w) {
                                                return '{{ $approvedArticles > 0 && $totalArticles > 0 ? number_format(($approvedArticles / $totalArticles) * 100, 0) : 0 }}%';
                                            }
                                        }
                                    }
                                }
                            }
                        },
                        legend: {
                            show: false
                        },
                        responsive: [{
                            breakpoint: 480,
                            options: {
                                chart: {
                                    height: 200
                                }
                            }
                        }]
                    }
                }).render();
            }

            // Category Donut Chart
            if (document.querySelector('#categoryDonutChart')) {
                createResponsiveChart({
                    element: '#categoryDonutChart',
                    config: {
                        series: @json($categoryData),
                        chart: {
                            type: 'donut',
                            height: 150,
                            width: '100%'
                        },
                        labels: @json($categoryLabels),
                        colors: ['#696cff', '#03c3ec', '#71dd37', '#ffab00', '#ff3e1d'],
                        stroke: {
                            width: 2
                        },
                        dataLabels: {
                            enabled: false
                        },
                        plotOptions: {
                            pie: {
                                donut: {
                                    size: '75%'
                                }
                            }
                        },
                        legend: {
                            show: false
                        },
                        responsive: [{
                            breakpoint: 480,
                            options: {
                                chart: {
                                    height: 120
                                }
                            }
                        }]
                    }
                }).render();
            }

            // Engagement Chart
            if (document.querySelector('#engagementChart')) {
                createResponsiveChart({
                    element: '#engagementChart',
                    config: {
                        series: [{
                            name: 'Views',
                            data: @json($viewCounts)
                        }],
                        chart: {
                            height: 200,
                            type: 'area',
                            sparkline: {
                                enabled: true
                            }
                        },
                        colors: ['#03c3ec'],
                        fill: {
                            type: 'gradient',
                            gradient: {
                                shade: 'light',
                                type: 'vertical',
                                shadeIntensity: 0.5,
                                opacityFrom: 0.8,
                                opacityTo: 0.2,
                            }
                        },
                        stroke: {
                            curve: 'smooth',
                            width: 2
                        },
                        xaxis: {
                            categories: @json($months),
                            labels: {
                                show: false
                            }
                        },
                        yaxis: {
                            labels: {
                                show: false
                            }
                        }
                    }
                }).render();
            }
        });
    </script>
@endsection
