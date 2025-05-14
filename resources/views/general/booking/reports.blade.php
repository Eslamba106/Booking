@extends('layouts.dashboard')

@section('title')
    {{ __('roles.booking_management') }}
@endsection

@section('css')
<!-- Font Awesome -->

<!-- DataTables -->

<style>
    /* تحسين مظهر حقول التاريخ */
.form-control[type="date"] {
    padding: 0.375rem 0.75rem;
    line-height: 1.5;
}

/* جعل الفلتر متجاوبًا */
@media (max-width: 768px) {
    .filter-section .col-md-3 {
        margin-bottom: 15px;
    }
}
    .status-badge {
        font-size: 0.8rem;
        padding: 5px 10px;
        border-radius: 20px;
        font-weight: 600;
    }

    .status-pending {
        background-color: #fff3cd;
        color: #856404;
    }

    .status-confirmed {
        background-color: #d4edda;
        color: #155724;
    }

    .status-cancelled {
        background-color: #f8d7da;
        color: #721c24;
    }

    .status-completed {
        background-color: #d1ecf1;
        color: #0c5460;
    }

    .action-btn {
        padding: 5px 10px;
        font-size: 0.85rem;
        margin-right: 5px;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .card {
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    .filter-section {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .dropdown-menu {
        min-width: 100px;
    }

    .dropdown-item {
        padding: 5px 15px;
    }

    .badge-pill {
        font-size: 0.85rem;
        padding: 5px 10px;
    }
    /* تغيير حجم الأيقونات */
.pagination .page-item a {
    font-size: 1rem; /* الحجم المناسب */
    padding: 8px 16px; /* زيادة مساحة الأزرار */
}

/* تخصيص السهم */
.pagination .page-item:first-child a,
.pagination .page-item:last-child a {
    font-size: 1.2rem; /* زيادة حجم الأسهم */
}

/* تغيير الشكل العام للـ pagination */
.pagination {
    display: flex;
    justify-content: center;
    align-items: center;
}

/* تحسين الألوان والحدود */
.pagination .page-item.active a {
    background-color: #007bff;
    border-color: #007bff;
    color: #fff;
}

.pagination .page-item:hover a {
    background-color: #0056b3;
    border-color: #0056b3;
}

/* تغيير شكل الأسهم */
.pagination .page-item .page-link {
    color: #007bff;
    font-size: 16px;
    font-weight: bold;
}

/* تعديل شكل الأزرار عند التمرير فوقها */
.pagination .page-item:hover .page-link {
    background-color: #007bff;
    color: white;
    border-color: #007bff;
}

</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="page-title">{{ __('roles.booking_management') }}</h3>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">{{ __('all_bookings') }}</h4>
                </div>

                <div class="card-body">
                    <!-- Filter Section -->
                    <div class="filter-section mb-4">
                        <form id="filterForm" method="GET" action="{{ route('admin.booking.reports') }}">
                            <div class="row">
                               <!-- في قسم الفلترة -->
                                 <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="filter_status">{{ __('roles.status') }}</label>
                                        <select name="status" id="filter_status" class="form-control">
                                            <option value="">{{ __('all_statuses') }}</option>
                                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>{{ __('pending') }}</option>
                                            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>{{ __('confirmed') }}</option>
                                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>{{ __('cancelled') }}</option>
                                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>{{ __('completed') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="filter_date_from">{{ __('From Date') }}</label>
                                        <input type="date" name="date_from" id="filter_date_from" class="form-control"
                                            value="{{ request('date_from') }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="filter_date_to">{{ __('To Date') }}</label>
                                        <input type="date" name="date_to" id="filter_date_to" class="form-control"
                                            value="{{ request('date_to') }}">
                                    </div>
                                </div>
                                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="filter_customer">{{ __('booking.customer_name') }}</label>
                                        <input type="text" name="customer" id="filter_customer" class="form-control"
                                               placeholder="{{ __('search_customer') }}" value="{{ request('customer') }}">
                                    </div>
                                </div>
                                <div class="col-md-3 d-flex align-items-end">
                                    <button type="submit" id="applyFilter" class="btn btn-primary mr-2">
                                        <i class="fas fa-filter mr-1"></i> {{ __('filter') }}
                                    </button>
                                    <a href="{{ route('admin.booking') }}" id="resetFilter" class="btn btn-outline-secondary">
                                        <i class="fas fa-redo mr-1"></i> {{ __('reset') }}
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Bulk Actions -->

                        <!-- Bookings Table -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" style="width:100%">
                                <thead class="thead-light">
                                    <tr>
                                        <th width="50"><input type="checkbox" id="selectAll"></th>
                                        <th>{{ __('booking_id') }}</th>
                                        <th>{{ __('booking.customer_name') }}</th>

                                        <th>{{ __('pickup_date') }}</th>
                                        <th>{{ __('return_date') }}</th>
                                        <th>{{ __('Status') }}</th>

                                        <th>{{ __('roles.Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bookings as $booking)
                                    <tr>
                                        <td><input type="checkbox" name="bulk_ids[]" value="{{ $booking->id }}"></td>
                                        <td>#{{ $booking->id }}</td>
                                        <td>{{ $booking->customer->name }}</td>

                                        <td>{{ \Carbon\Carbon::parse($booking->arrival_date)->format('d M Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($booking->leave_date)->format('d M Y') }}</td>

                                        <td>
                                            <span class="badge badge-pill
                                                @if($booking->status == 'pending') badge-warning
                                                @elseif($booking->status == 'confirmed') badge-success
                                                @elseif($booking->status == 'cancelled') badge-danger
                                                @else badge-info @endif">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                @can('edit_booking')
                                                <a href="{{ route('admin.booking.show', $booking->id) }}" class="btn btn-sm btn-info action-btn" title="{{ __('view') }}">
                                                    <i class="fas fa-eye"></i>
                                                </a>

                                                @endcan

                                                {{-- @can('delete_booking')
                                                <form action="{{ route('admin.booking.delete', $booking->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger action-btn delete-confirm" title="{{ __('delete') }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                                @endcan --}}

                                                @can('edit_booking')
                                                <a href="{{ route('booking.voucher.pdf', $booking->id) }}" class="btn btn-sm btn-secondary action-btn" title="{{ __('PDF') }}">
                                                    <i class="fas fa-file-pdf"></i>
                                                </a>
                                                @endcan

                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </form>

                    <!-- Pagination -->
                   <div class="pagination">
    <ul class="pagination">
        <li class="page-item">
            <a class="page-link" href="{{ $bookings->previousPageUrl() }}">
                <i class="fas fa-arrow-left"></i> Pervious</a>
        </li>
        <li class="page-item">
            <a class="page-link" href="{{ $bookings->nextPageUrl() }}">
                <i class="fas fa-arrow-right"></i> Next
            </a>
        </li>
    </ul>
</div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<!-- DataTables -->

<!-- SweetAlert2 for confirm dialogs -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
$(document).ready(function() {
    // تطبيق الفلاتر عند تغيير أي من الحقول
    $('#filter_status, #filter_date_range, #filter_date_from, #filter_date_to, #filter_customer').change(function() {
        applyFilters();
    });

    // دالة لتطبيق الفلاتر
    function applyFilters() {
        const status = $('#filter_status').val();
        const dateRange = $('#filter_date_range').val();
        const dateFrom = $('#filter_date_from').val();
        const dateTo = $('#filter_date_to').val();
        const customer = $('#filter_customer').val();

        // عرض مؤشر التحميل
        $('#bookingsTable tbody').html('<tr><td colspan="8" class="text-center"><i class="fas fa-spinner fa-spin"></i> Loading...</td></tr>');

        $.ajax({
            url: '{{ route("admin.booking") }}',
            type: 'GET',
            data: {
                status: status,
                date_range: dateRange,
                date_from: dateFrom,
                date_to: dateTo,
                customer: customer
            },
            success: function(response) {
                $('#bookingsTable tbody').html($(response).find('#bookingsTable tbody').html());
                $('.pagination').html($(response).find('.pagination').html());

                // تحديث URL بدون إعادة تحميل الصفحة
                const newUrl = updateUrlParameters({
                    status: status,
                    date_range: dateRange,
                    date_from: dateFrom,
                    date_to: dateTo,
                    customer: customer
                });
                history.pushState(null, '', newUrl);
            },
            error: function(xhr) {
                $('#bookingsTable tbody').html('<tr><td colspan="8" class="text-center text-danger">Error loading data</td></tr>');
            }
        });
    }

    // دالة لتحديث معلمات URL
    function updateUrlParameters(params) {
        const url = new URL(window.location.href);
        url.search = '';

        for (const key in params) {
            if (params[key]) {
                url.searchParams.set(key, params[key]);
            }
        }

        return url.toString();
    }
});
</script>
@endsection
