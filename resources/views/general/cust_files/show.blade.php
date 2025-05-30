@extends('layouts.dashboard')
@section('title')
    {{ __('Customer Files') }}
@endsection

@section('css')
    <style>
        .file-card {
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            border: 1px solid #e0e0e0;
        }

        .file-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #eee;
            padding: 15px 20px;
            border-radius: 10px 10px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .file-body {
            padding: 20px;
        }

        .detail-label {
            font-weight: 600;
            color: #495057;
        }

        .detail-value {
            color: #212529;
        }

        .payment-summary {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            height: 100%;
        }

        .badge-status {
            font-size: 0.85rem;
            padding: 5px 10px;
        }

        .item-card {
            border-left: 3px solid #3f80ea;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }

        .item-card:hover {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .item-details {
            padding-left: 15px;
        }

        .no-files {
            text-align: center;
            padding: 40px;
        }

        .back-btn {
            margin-top: 20px;
        }

        .customer-info {
            margin-bottom: 30px;
            padding: 15px;
            background-color: #f5f5f5;
            border-radius: 8px;
        }
    </style>
@endsection

@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">{{ __('Customer Files') }}</h4>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex no-block justify-content-end align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">{{ __('dashboard.home') }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Customer Files') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @if ($file->isNotEmpty())
                            <div class="customer-info">
                                <h4>{{ __('Customer Information') }}</h4>
                                <p><strong>{{ __('Name') }}:</strong> {{ $file->first()->customer->name ?? 'N/A' }}</p>
                                <p><strong>{{ __('Email') }}:</strong> {{ $file->first()->customer->email ?? 'N/A' }}</p>
                                <p><strong>{{ __('Phone') }}:</strong> {{ $file->first()->customer->phone ?? 'N/A' }}
                                </p>
                            </div>
                        @endif

                        <h4 class="card-title">{{ __('Customer Files') }}</h4>

                        @forelse($file as $custFile)
                            <div class="card file-card">
                                <div class="file-header">
                                    <h5 class="mb-0"> #{{ $custFile->name }}</h5>
                                    <span
                                        class="badge badge-status
                                @if ($custFile->remain == 0) badge-success
                                @elseif($custFile->paid > 0) badge-warning
                                @else badge-danger @endif">
                                        @if ($custFile->remain == 0)
                                            {{ __('Fully Paid') }}
                                        @elseif($custFile->paid > 0)
                                            {{ __('Partially Paid') }}
                                        @else
                                            {{ __('Not Paid') }}
                                        @endif
                                    </span>
                                </div>

                                <div class="file-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6>{{ __('Items') }}</h6>
                                            @foreach ($custFile->cust_file_items as $item)
                                                <div class="card item-card mb-3">
                                                    <div class="card-body">
                                                        @if ($item->related_type === 'App\\Models\\Booking')
                                                            @php $booking = $item->related @endphp
                                                            <div class="mb-2">
                                                                <strong>Booking:</strong> #{{ $booking->id ?? 'N/A' }}
                                                                <div class="item-details">
                                                                    <small class="text-muted">
                                                                        {{ __('Total') }}:
                                                                        ${{ number_format($booking->total ?? 0, 2) }}<br>
                                                                        {{ __('Check In') }}:
                                                                        {{ $booking->arrival_date ?? 'N/A' }}<br>
                                                                        {{ __('Check Out') }}:
                                                                        {{ $booking->check_out_date ?? 'N/A' }}
                                                                    </small>
                                                                </div>
                                                            </div>
                                                        @elseif($item->related_type === 'App\\Models\\Car')
                                                            @php $car = $item->related @endphp
                                                            <div>
                                                                <strong>{{ __('Car') }}:</strong>
                                                                #{{ $car->id ?? 'N/A' }}
                                                                <div class="item-details">
                                                                    <small class="text-muted">
                                                                        {{ __('Model') }}:
                                                                        {{ $car->category->category ?? 'N/A' }}<br>
                                                                        {{ __('Price') }}:
                                                                        ${{ number_format($car->total ?? 0, 2) }}
                                                                    </small>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>


                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="no-files">
                                <i class="mdi mdi-file-document-outline" style="font-size: 48px; color: #ccc;"></i>
                                <h4>{{ __('No files found for this customer') }}</h4>
                                <p>{{ __('This customer currently has no files associated with their account.') }}</p>
                            </div>
                        @endforelse

                        <div class="back-btn">
                            <a href="{{ route('admin.booking') }}" class="btn btn-secondary">
                                <i class="mdi mdi-arrow-left"></i> {{ __('Back to Bookings') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
