@extends('layouts.dashboard')
@section('title', __('File Report'))

@section('css')
    <style>
        .report-header {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .currency-badge {
            font-size: 0.8em;
            padding: 2px 6px;
        }
        .summary-card {
            border: 1px solid #dee2e6;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .summary-card-header {
            background-color: #f8f9fa;
            padding: 10px 15px;
            border-bottom: 1px solid #dee2e6;
            font-weight: bold;
        }
        .summary-card-body {
            padding: 15px;
        }
        .table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
    </style>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">{{ __('File Report') }}</h4>
            <p class="text-muted mb-0">{{ __('Generated on') }}: {{ now()->format('d M Y H:i:s') }}</p>
        </div>

        <div class="card-body">
            <!-- Report Filters -->
            <div class="report-header">
                <div class="row">
                    <div class="col-md-3">
                        <label><strong>{{ __('Date Range') }}:</strong></label>
                        <p>{{ $dateFrom ?? 'All' }} - {{ $dateTo ?? 'All' }}</p>
                    </div>
                    <div class="col-md-3">
                        <label><strong>{{ __('Status') }}:</strong></label>
                        <p>{{ $status ?? 'All' }}</p>
                    </div>
                    <div class="col-md-3">
                        <label><strong>{{ __('Currency') }}:</strong></label>
                        <p>{{ $currency ?? 'All' }}</p>
                    </div>
                    <div class="col-md-3">
                        <label><strong>{{ __('Total Files') }}:</strong></label>
                        <p>{{ $files->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Summary Statistics -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="summary-card">
                        <div class="summary-card-header">
                            {{ __('Total Revenue') }}
                        </div>
                        <div class="summary-card-body text-center">
                            <h4 class="text-primary">{{ $formatCurrency($totalRevenue) }}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="summary-card">
                        <div class="summary-card-header">
                            {{ __('Total Paid') }}
                        </div>
                        <div class="summary-card-body text-center">
                            <h4 class="text-success">{{ $formatCurrency($totalPaid) }}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="summary-card">
                        <div class="summary-card-header">
                            {{ __('Total Balance') }}
                        </div>
                        <div class="summary-card-body text-center">
                            <h4 class="text-{{ $totalBalance > 0 ? 'danger' : 'success' }}">{{ $formatCurrency($totalBalance) }}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="summary-card">
                        <div class="summary-card-header">
                            {{ __('Average File Value') }}
                        </div>
                        <div class="summary-card-body text-center">
                            <h4 class="text-info">{{ $formatCurrency($averageFileValue) }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Files Table -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>{{ __('File ID') }}</th>
                            <th>{{ __('Customer Name') }}</th>
                            <th>{{ __('File Name') }}</th>
                            <th>{{ __('Created Date') }}</th>
                            <th>{{ __('Total Amount') }}</th>
                            <th>{{ __('Paid Amount') }}</th>
                            <th>{{ __('Balance') }}</th>
                            <th>{{ __('Currency') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($files as $file)
                            @php
                                $balance = $file->total - $file->paid;
                                $status = $balance > 0 ? 'Pending' : 'Paid';
                            @endphp
                            <tr>
                                <td>#{{ $file->id }}</td>
                                <td>{{ $file->customer->name }}</td>
                                <td>{{ $file->name ?? 'N/A' }}</td>
                                <td>{{ $file->created_at->format('d M Y') }}</td>
                                <td>{{ $formatCurrency($file->total, $file->currency) }}</td>
                                <td>{{ $formatCurrency($file->paid, $file->currency) }}</td>
                                <td class="{{ $balance > 0 ? 'text-danger' : 'text-success' }}">
                                    {{ $formatCurrency($balance, $file->currency) }}
                                </td>
                                <td>
                                    <span class="badge badge-secondary currency-badge">
                                        {{ $file->currency }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-{{ $status == 'Paid' ? 'success' : 'warning' }}">
                                        {{ $status }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('add.items.file', $file->id) }}"
                                       class="btn btn-sm btn-info" title="{{ __('View Details') }}">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center">{{ __('No files found') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Currency Breakdown -->
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="summary-card">
                        <div class="summary-card-header">
                            {{ __('Revenue by Currency') }}
                        </div>
                        <div class="summary-card-body">
                            @foreach ($currencyBreakdown as $currency => $amount)
                                <div class="d-flex justify-content-between mb-2">
                                    <span>{{ $currency }}:</span>
                                    <strong>{{ $formatCurrency($amount, $currency) }}</strong>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="summary-card">
                        <div class="summary-card-header">
                            {{ __('Payment Status Summary') }}
                        </div>
                        <div class="summary-card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span>{{ __('Paid Files') }}:</span>
                                <strong class="text-success">{{ $paidFilesCount }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>{{ __('Pending Files') }}:</span>
                                <strong class="text-warning">{{ $pendingFilesCount }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        // Add any JavaScript for report functionality
        $(document).ready(function() {
            // Initialize any report-specific functionality
        });
    </script>
@endsection
