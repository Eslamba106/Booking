@extends('layouts.dashboard')
@section('title', __('Client File Report') . ' - ' . $customer->name)

@section('css')
    <style>
        .client-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
        }
        .client-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .filter-card {
            background: #fff;
            border: 1px solid #dee2e6;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .summary-card {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .summary-card-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 15px 20px;
            border-bottom: 1px solid #dee2e6;
            font-weight: bold;
            border-radius: 8px 8px 0 0;
        }
        .summary-card-body {
            padding: 20px;
        }
        .currency-badge {
            font-size: 0.8em;
            padding: 4px 8px;
            border-radius: 12px;
        }
        .payment-history {
            max-height: 400px;
            overflow-y: auto;
        }
        .file-status-paid {
            color: #28a745;
            font-weight: bold;
        }
        .file-status-pending {
            color: #ffc107;
            font-weight: bold;
        }
        .file-status-overdue {
            color: #dc3545;
            font-weight: bold;
        }
    </style>
@endsection

@section('content')
    <div class="card">
        <!-- Client Header -->
        <div class="client-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-2">{{ __('Client File Report') }}</h2>
                    <h4 class="mb-0">{{ $customer->name }}</h4>
                    <p class="mb-0 mt-2">
                        <i class="fas fa-envelope"></i> {{ $customer->email }} |
                        <i class="fas fa-phone"></i> {{ $customer->phone }}
                    </p>
                </div>
                <div class="col-md-4 text-right">
                    <p class="mb-1"><strong>{{ __('Report Generated') }}:</strong></p>
                    <p class="mb-0">{{ now()->format('d M Y H:i:s') }}</p>
                    <a href="{{ route('reports.client.files.export', $customer->id) }}" class="btn btn-success mt-2">
                        <i class="fas fa-file-excel"></i> {{ __('Export as Excel') }}
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <!-- Filters -->
            <div class="filter-card">
                <form method="GET" action="{{ route('reports.client.files', $customer->id) }}" id="clientReportForm">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ __('Date From') }}</label>
                                <input type="date" name="date_from" class="form-control"
                                       value="{{ request('date_from') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ __('Date To') }}</label>
                                <input type="date" name="date_to" class="form-control"
                                       value="{{ request('date_to') }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>{{ __('Currency') }}</label>
                                <select name="currency" class="form-control">
                                    <option value="">{{ __('All Currencies') }}</option>
                                    <option value="USD" {{ request('currency') == 'USD' ? 'selected' : '' }}>USD</option>
                                    <option value="EUR" {{ request('currency') == 'EUR' ? 'selected' : '' }}>EUR</option>
                                    <option value="TRY" {{ request('currency') == 'TRY' ? 'selected' : '' }}>TRY</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <div>
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <i class="fas fa-search"></i> {{ __('Filter') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Summary Statistics -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="summary-card">
                        <div class="summary-card-header text-primary">
                            <i class="fas fa-dollar-sign"></i> {{ __('Total Revenue') }}
                        </div>
                        <div class="summary-card-body text-center">
                            <h3 class="text-primary">{{ $formatCurrency($totalRevenue) }}</h3>
                            <small class="text-muted">{{ $files->count() }} {{ __('files') }}</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="summary-card">
                        <div class="summary-card-header text-success">
                            <i class="fas fa-check-circle"></i> {{ __('Total Paid') }}
                        </div>
                        <div class="summary-card-body text-center">
                            <h3 class="text-success">{{ $formatCurrency($totalPaid) }}</h3>
                            <small class="text-muted">{{ $paidFilesCount }} {{ __('paid files') }}</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="summary-card">
                        <div class="summary-card-header {{ $totalBalance > 0 ? 'text-warning' : 'text-success' }}">
                            <i class="fas fa-balance-scale"></i> {{ __('Balance') }}
                        </div>
                        <div class="summary-card-body text-center">
                            <h3 class="{{ $totalBalance > 0 ? 'text-warning' : 'text-success' }}">
                                {{ $formatCurrency($totalBalance) }}
                            </h3>
                            <small class="text-muted">{{ $pendingFilesCount }} {{ __('pending files') }}</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="summary-card">
                        <div class="summary-card-header text-info">
                            <i class="fas fa-chart-line"></i> {{ __('Average File Value') }}
                        </div>
                        <div class="summary-card-body text-center">
                            <h3 class="text-info">{{ $formatCurrency($averageFileValue) }}</h3>
                            <small class="text-muted">{{ __('per file') }}</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Files Table -->
            <div class="summary-card">
                <div class="summary-card-header">
                    <i class="fas fa-folder"></i> {{ __('Client Files') }} ({{ $files->count() }})
                </div>
                <div class="summary-card-body">

                    {{-- جدول الحجوزات --}}
                    <h5 class="mb-3"><i class="fas fa-hotel"></i> {{ __('Hotel Bookings') }}</h5>
                    <div class="table-responsive mb-5">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>{{ __('ID') }}</th>
                                    <th>{{ __('File Name') }}</th>
                                    <th>Hotel</th>
                                    <th>Check-in</th>
                                    <th>Check-out</th>
                                    <th>Rooms</th>
                                    <th>{{ __('Currency') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($files as $file)
                                    @foreach($file->cust_file_items as $item)
                                        @if($item->related_type == 'App\\Models\\Booking' && $item->related)
                                            <tr>
                                                <td><strong>#{{ $item->related->id }}</strong></td>
                                                <td>{{ $file->name ?? 'N/A' }}</td>
                                                <td>{{ $item->related->hotel->name ?? 'N/A' }}</td>
                                                <td>{{ $item->related->arrival_date }}</td>
                                                <td>{{ $item->related->check_out_date }}</td>
                                                <td>{{ $item->related->booking_details->units_count ?? 0 }}</td>
                                                <td><span class="badge badge-secondary">{{ $file->currency }}</span></td>
                                                <td>
                                                    @if(($file->total - $file->paid) <= 0)
                                                        <span class="badge badge-success">{{ __('Paid') }}</span>
                                                    @else
                                                        <span class="badge badge-warning">{{ __('Pending') }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.booking.show', $item->related->id) }}"
                                                       class="btn btn-sm btn-info" title="{{ __('View Booking') }}">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- جدول السيارات --}}
                    <h5 class="mb-3"><i class="fas fa-car"></i> {{ __('Car Rentals') }}</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>{{ __('ID') }}</th>
                                    <th>{{ __('File Name') }}</th>
                                    <th>Car Type</th>
                                    <th>Pickup</th>
                                    <th>Drop-off</th>
                                    <th>Days</th>
                                    <th>{{ __('Currency') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($files as $file)
                                    @foreach($file->cust_file_items as $item)
                                        @if($item->related_type == 'App\\Models\\Car' && $item->related)
                                            <tr>
                                                <td><strong>#{{ $item->related->id }}</strong></td>
                                                <td>{{ $file->name ?? 'N/A' }}</td>
                                                <td>{{ $item->related->category->category ?? 'N/A' }}</td>
                                                <td>{{ $item->related->arrival_date . ' ' . $item->related->arrival_time }}</td>
                                                <td>{{ $item->related->leave_date . ' ' . $item->related->leave_time }}</td>
                                                <td>{{ $item->related->days_count ?? 0 }}</td>
                                                <td><span class="badge badge-secondary">{{ $file->currency }}</span></td>
                                                <td>
                                                    @if(($file->total - $file->paid) <= 0)
                                                        <span class="badge badge-success">{{ __('Paid') }}</span>
                                                    @else
                                                        <span class="badge badge-warning">{{ __('Pending') }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('car.show', $item->related->id) }}"
                                                       class="btn btn-sm btn-info" title="{{ __('View Car Rental') }}">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($files->count() == 0)
                        <div class="text-center py-4">
                            <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">{{ __('No files found for this client') }}</h5>
                            <p class="text-muted">{{ __('Try adjusting your filters or create a new file for this client.') }}</p>
                        </div>
                    @endif

                </div>
            </div>


            <!-- Additional Information -->
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="summary-card">
                        <div class="summary-card-header">
                            <i class="fas fa-coins"></i> {{ __('Revenue by Currency') }}
                        </div>
                        <div class="summary-card-body">
                            @if($currencyBreakdown->count() > 0)
                                @foreach ($currencyBreakdown as $currency => $amount)
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div>
                                            <span class="badge badge-secondary currency-badge">{{ $currency }}</span>
                                            <span class="ml-2">{{ $currency }} {{ __('Revenue') }}</span>
                                        </div>
                                        <strong>{{ $formatCurrency($amount, $currency) }}</strong>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-muted text-center">{{ __('No currency data available') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="summary-card">
                        <div class="summary-card-header">
                            <i class="fas fa-chart-pie"></i> {{ __('Payment Summary') }}
                        </div>
                        <div class="summary-card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <span>{{ __('Total Files') }}:</span>
                                <strong>{{ $files->count() }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-success">{{ __('Paid Files') }}:</span>
                                <strong class="text-success">{{ $paidFilesCount }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-warning">{{ __('Pending Files') }}:</span>
                                <strong class="text-warning">{{ $pendingFilesCount }}</strong>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <span class="text-info">{{ __('Total Payments Received') }}:</span>
                                <strong class="text-info">{{ $formatCurrency($totalPaymentsReceived) }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="summary-card mt-4">
                <div class="summary-card-header">
                    <i class="fas fa-tools"></i> {{ __('Quick Actions') }}
                </div>
                <div class="summary-card-body text-center">
                    <a href="{{ route('admin.file.create') }}" class="btn btn-primary m-2">
                        <i class="fas fa-plus"></i> {{ __('Create New File') }}
                    </a>
                    <a href="{{ route('admin.customer.show', $customer->id) }}" class="btn btn-info m-2">
                        <i class="fas fa-user"></i> {{ __('View Customer Profile') }}
                    </a>
                    <a href="{{ route('reports.files') }}" class="btn btn-secondary m-2">
                        <i class="fas fa-chart-bar"></i> {{ __('All Files Report') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            // Auto-submit form when filters change
            $('select[name="currency"], select[name="status"]').on('change', function() {
                if ($('input[name="date_from"]').val() || $('input[name="date_to"]').val()) {
                    $('#clientReportForm').submit();
                }
            });

            // Date range validation
            $('input[name="date_from"], input[name="date_to"]').on('change', function() {
                const dateFrom = $('input[name="date_from"]').val();
                const dateTo = $('input[name="date_to"]').val();

                if (dateFrom && dateTo && dateFrom > dateTo) {
                    alert('{{ __("Date From cannot be later than Date To") }}');
                    $(this).val('');
                }
            });
        });
    </script>
@endsection
