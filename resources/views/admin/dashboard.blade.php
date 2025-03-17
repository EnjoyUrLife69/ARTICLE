@extends('layouts.dashboard')

@section('styles')
    <style>
        /* Modern Card Styling */
        .stats-card {
            transition: all 0.3s ease;
            border-radius: 0.75rem;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
            height: 100%;
            overflow: hidden;
            border: none;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }

        /* Avatar and Icons */
        .avatar-wrapper {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            margin-right: 1rem;
        }

        .avatar-sm {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            overflow: hidden;
        }

        /* Text Utilities */
        .text-truncate-container {
            max-width: 180px;
        }

        .text-truncate-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Activity & List Items */
        .activity-feed {
            max-height: 500px;
            overflow-y: auto;
        }

        .activity-item {
            padding: 1rem;
            transition: background-color 0.2s ease;
            border-left: 3px solid transparent;
        }

        .activity-item:hover {
            background-color: rgba(0, 0, 0, 0.02);
            border-left-color: var(--bs-primary);
        }

        /* Status Badges */
        .status-badge {
            padding: 0.35rem 0.65rem;
            border-radius: 50rem;
            font-weight: 500;
            font-size: 0.75rem;
        }

        /* Custom Progress Bars */
        .slim-progress {
            height: 5px;
            border-radius: 5px;
            overflow: hidden;
        }

        /* Responsive Adjustments */
        @media (max-width: 992px) {
            .responsive-card-deck .card {
                margin-bottom: 1.5rem;
            }
        }

        /* Table Enhancements */
        .modern-table th {
            font-weight: 600;
            color: var(--bs-gray-700);
            border-top: none;
        }

        .modern-table td {
            vertical-align: middle;
            padding: 0.75rem 1rem;
        }

        .modern-table tr {
            transition: background-color 0.15s ease;
        }

        .modern-table tr:hover {
            background-color: rgba(0, 0, 0, 0.02);
        }

        /* Chart Container */
        .chart-container {
            min-height: 400px;
            position: relative;
        }
    </style>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Welcome Card with Shadow -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card stats-card">
                    <div class="d-flex align-items-center row g-0">
                        <div class="col-lg-7 col-md-7 col-sm-12">
                            <div class="card-body p-4">
                                <h4 class="card-title text-primary mb-3"><b>Admin Dashboard</b></h4>
                                <p class="mb-4">
                                    Selamat datang di panel admin. Anda memiliki
                                    <span class="fw-bold text-primary">{{ $pendingArticles }}</span>
                                    artikel yang menunggu persetujuan.
                                </p>
                                <a href="{{ route('request') }}" class="btn btn-primary rounded-pill px-4">
                                    <i class="bx bx-check-square me-1"></i> Review Articles
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-12 d-none d-md-block">
                            <div class="p-3 text-center">
                                <img src="{{ asset('assets/img/illustrations/girl-doing-yoga-light.png') }}" height="140"
                                    alt="Writer Dashboard" data-app-dark-img="illustrations/girl-doing-yoga-light.png"
                                    data-app-light-img="illustrations/girl-doing-yoga-light.png" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards with Consistent Layout -->
        <div class="row mb-4 g-3">
            <!-- Articles Stats -->
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="card stats-card h-100">
                    <div class="card-body p-4">
                        <!-- Header section with icon and dropdown -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="avatar-wrapper bg-label-primary bg-opacity-15 p-2 rounded">
                                <i class="bx bx-book fs-4 text-primary"></i>
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('articles.index') }}">View All</a>
                                </div>
                            </div>
                        </div>

                        <h4 class="card-title mb-1">{{ number_format($totalArticles) }}</h4>
                        <p class="text-muted mb-0">Total Articles</p><br>

                        <!-- Status badges organized in a neat row -->
                        <div class="d-flex justify-content-between mb-3">
                            <span
                                class="badge bg-label-success w-100 text-center p-2">{{ number_format($approvedArticles) }}</span>
                            <span
                                class="badge bg-label-warning w-100 text-center p-2">{{ number_format($pendingArticles) }}</span>
                            <span
                                class="badge bg-label-danger w-100 text-center p-2">{{ number_format($rejectedArticles) }}</span>
                        </div>

                        <!-- Status labels below the badges, neatly spaced -->
                        <div class="d-flex justify-content-between text-small">
                            <span>Approved</span>
                            <span>Pending</span>
                            <span>Rejected</span>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Writers Stats -->
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="card stats-card h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between mb-3">
                            <div class="avatar-wrapper bg-label-info bg-opacity-15">
                                <i class="bx bx-user fs-4 text-info"></i>
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#">View All Users</a>
                                </div>
                            </div>
                        </div>
                        <h4 class="card-title mb-1">{{ number_format($totalUsers) }}</h4>
                        <p class="text-muted mb-4">Total Writers</p>
                        <span class="fw-medium">{{ number_format($activeUsers) }} actively writing</span>
                        <div class="progress slim-progress mt-2 mb-1">
                            <div class="progress-bar bg-info"
                                style="width: {{ ($activeUsers / max($totalUsers, 1)) * 100 }}%"></div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted small">0</span>
                            <span class="text-muted small">{{ number_format($totalUsers) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Categories Stats -->
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="card stats-card h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between mb-3">
                            <div class="avatar-wrapper bg-label-success bg-opacity-15">
                                <i class="bx bx-category fs-4 text-success"></i>
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#">View Categories</a>
                                </div>
                            </div>
                        </div>
                        <h4 class="card-title mb-1">{{ number_format($totalCategories) }}</h4>
                        <p class="text-muted mb-4">Categories</p>
                        <p class="mb-1">Top category: <span
                                class="fw-medium">{{ $categoryStats->first() ? $categoryStats->first()->name : 'None' }}</span>
                        </p>
                        <div class="progress slim-progress mt-2">
                            <div class="progress-bar bg-success" style="width: 100%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Views Stats -->
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="card stats-card h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between mb-3">
                            <div class="avatar-wrapper bg-label-warning bg-opacity-15">
                                <i class="bx bx-line-chart fs-4 text-warning"></i>
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#">View Analytics</a>
                                </div>
                            </div>
                        </div>
                        <h4 class="card-title mb-1">{{ number_format($totalViews) }}</h4>
                        <p class="text-muted mb-4">Total Views</p>
                        <div class="d-flex justify-content-between">
                            <div>
                                <span class="d-block fw-medium">{{ number_format($totalLikes) }}</span>
                                <small class="text-muted">Likes</small>
                            </div>
                            <div class="text-end">
                                <span class="d-block fw-medium">{{ number_format($totalShares) }}</span>
                                <small class="text-muted">Shares</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart and Pending Reviews -->
        <div class="row mb-4 g-3">
            <!-- Performance Chart -->
            <div class="col-xl-8 col-lg-7">
                <div class="card stats-card h-100">
                    <div class="card-header bg-transparent d-flex align-items-center justify-content-between py-3">
                        <h5 class="card-title m-0">Content Performance</h5>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-primary rounded-pill px-3 dropdown-toggle"
                                type="button" data-bs-toggle="dropdown">
                                {{ date('Y') }}
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="javascript:void(0);">{{ date('Y') - 1 }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="contentPerformanceChart" class="chart-container"></div>
                    </div>
                </div>
            </div>

            <!-- Pending Reviews -->
            <div class="col-xl-4 col-lg-5">
                <div class="card stats-card h-100">
                    <div class="card-header bg-transparent py-3">
                        <h5 class="card-title m-0">Pending Review</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            @forelse($pendingReviewArticles as $article)
                                <div class="list-group-item activity-item border-0">
                                    <div class="d-flex w-100 justify-content-between align-items-center">
                                        <div class="text-truncate-container">
                                            <h6 class="mb-1 text-truncate-2">{{ $article->title }}</h6>
                                            <div class="d-flex align-items-center">
                                                <small class="text-muted">{{ $article->user->name }}</small>
                                                <span class="mx-1 text-muted">•</span>
                                                <small
                                                    class="text-muted">{{ $article->created_at->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                        <a href="{{ route('articles.edit', $article->id) }}"
                                            class="btn btn-sm btn-primary rounded-pill px-3">Review</a>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bx bx-check-circle mb-2 d-block"
                                            style="font-size: 2.5rem; opacity: 0.5;"></i>
                                        <p class="mb-0">No pending articles</p>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                    @if (count($pendingReviewArticles) > 0)
                        <div class="card-footer bg-transparent text-center py-3">
                            <a href="{{ route('request') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                View All Pending
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Writers & Activities -->
        <div class="row g-3">
            <!-- Top Writers -->
            <div class="col-xl-6 col-lg-6">
                <div class="card stats-card h-100">
                    <div class="card-header bg-transparent d-flex align-items-center justify-content-between py-3">
                        <h5 class="card-title m-0">Top Writers</h5>
                        <a href="#" class="btn btn-sm btn-outline-primary rounded-pill px-3">View All</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table modern-table mb-0">
                                <thead>
                                    <tr>
                                        <th class="ps-4">Writer</th>
                                        <th>Articles</th>
                                        <th class="pe-4">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($topWriters as $writer)
                                        <tr>
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center">
                                                    @if ($writer->image)
                                                        <img src="{{ asset('storage/images/users/' . $writer->image) }}"
                                                            class="rounded-circle me-2" width="36" height="36"
                                                            alt="{{ $writer->name }}">
                                                    @else
                                                        <div class="avatar-sm me-2 bg-label-primary text-white">
                                                            <span>{{ substr($writer->name, 0, 1) }}</span>
                                                        </div>
                                                    @endif
                                                    <div class="fw-medium">{{ $writer->name }}</div>
                                                </div>
                                            </td>
                                            <td>{{ $writer->article_count }}</td>
                                            <td class="pe-4">
                                                <span
                                                    class="status-badge bg-label-{{ $writer->article_count > 5 ? 'success' : 'primary' }}">
                                                    {{ $writer->article_count > 5 ? 'Active' : 'Regular' }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activities -->
            <div class="col-xl-6 col-lg-6">
                <div class="card stats-card h-100">
                    <div class="card-header bg-transparent d-flex align-items-center justify-content-between py-3">
                        <h5 class="card-title m-0">Recent Activities</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="activity-feed">
                            @foreach ($recentActivities as $activity)
                                <div class="activity-item">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-shrink-0 me-3">
                                            @if ($activity->img)
                                                <img src="{{ asset('storage/images/articles/' . $activity->img) }}"
                                                    class="rounded" width="44" alt="Article Image">
                                            @else
                                                <div
                                                    class="avatar-sm bg-label-{{ $activity->action == 'create' ? 'success' : ($activity->action == 'edit' ? 'warning' : 'danger') }}">
                                                    <i
                                                        class="bx bx-{{ $activity->action == 'create' ? 'plus' : ($activity->action == 'edit' ? 'edit' : 'trash') }}"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="w-100">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <span class="fw-medium">{{ $activity->user->name }}</span>
                                                <small
                                                    class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                                            </div>
                                            <p class="mb-0 text-muted">{!! $activity->details !!}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
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
            // Content Performance Chart
            if (document.querySelector('#contentPerformanceChart')) {
                const contentPerformanceChart = new ApexCharts(document.querySelector('#contentPerformanceChart'), {
                    series: [{
                        name: 'Articles',
                        type: 'column',
                        data: @json($articleCounts)
                    }, {
                        name: 'Views',
                        type: 'line',
                        data: @json($viewCounts)
                    }],
                    chart: {
                        height: 380,
                        type: 'line',
                        stacked: false,
                        toolbar: {
                            show: false
                        },
                        fontFamily: 'inherit',
                        zoom: {
                            enabled: false
                        }
                    },
                    colors: ['#696cff', '#03c3ec'],
                    stroke: {
                        width: [0, 3],
                        curve: 'smooth'
                    },
                    grid: {
                        borderColor: '#e0e0e0',
                        strokeDashArray: 5,
                        xaxis: {
                            lines: {
                                show: true
                            }
                        },
                        yaxis: {
                            lines: {
                                show: true
                            }
                        },
                        padding: {
                            top: 0,
                            right: 0,
                            bottom: 0,
                            left: 10
                        }
                    },
                    plotOptions: {
                        bar: {
                            columnWidth: '50%',
                            borderRadius: 5,
                            dataLabels: {
                                position: 'top'
                            }
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    fill: {
                        opacity: [0.85, 0.25],
                        gradient: {
                            inverseColors: false,
                            shade: 'light',
                            type: "vertical",
                            opacityFrom: 0.85,
                            opacityTo: 0.55
                        }
                    },
                    markers: {
                        size: 5,
                        strokeWidth: 0,
                        hover: {
                            size: 7
                        }
                    },
                    xaxis: {
                        categories: @json($months),
                        labels: {
                            style: {
                                fontSize: '12px',
                                fontWeight: 400
                            }
                        },
                        axisBorder: {
                            show: false
                        }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                fontSize: '12px',
                                fontWeight: 400
                            }
                        }
                    },
                    legend: {
                        show: true,
                        position: 'top',
                        horizontalAlign: 'right',
                        markers: {
                            width: 10,
                            height: 10,
                            radius: 50
                        },
                        itemMargin: {
                            horizontal: 15,
                            vertical: 0
                        }
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
                    }
                });
                contentPerformanceChart.render();
            }
        });
    </script>
@endsection
