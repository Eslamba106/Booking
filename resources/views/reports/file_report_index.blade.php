@extends('layouts.dashboard')
@section('title', __('File Report'))

@section('css')
    <style>
        .filter-card {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .report-summary {
            background: #fff;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
        }
    </style>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">{{ __('File Report') }}</h4>
        </div>

        <div class="card-body">
            <!-- Filters -->
            <div class="filter-card">
                <form method="GET" action="{{ route('reports.files') }}" id="reportForm">
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
                                <label>{{ __('Status') }}</label>
                                <select name="status" class="form-control">
                                    <option value="">{{ __('All Status') }}</option>
                                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>{{ __('Paid') }}</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search"></i> {{ __('Generate Report') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Report Content -->
            <div id="reportContent">
                @if(request()->has('date_from') || request()->has('date_to') || request()->has('currency') || request()->has('status'))
                    @include('reports.file_report')
                @else
                    <div class="text-center">
                        <h5 class="text-muted">{{ __('Select filters above to generate a report') }}</h5>
                    </div>
                @endif
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
                    $('#reportForm').submit();
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
