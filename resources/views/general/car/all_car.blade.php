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
            font-size: 1rem;
            /* الحجم المناسب */
            padding: 8px 16px;
            /* زيادة مساحة الأزرار */
        }

        /* تخصيص السهم */
        .pagination .page-item:first-child a,
        .pagination .page-item:last-child a {
            font-size: 1.2rem;
            /* زيادة حجم الأسهم */
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
                    <h3 class="page-title">Car Bookings Management</h3>
                    <a href="{{ route('car.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus mr-2"></i> New Booking
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">All Bookings</h4>
                    </div>

                    <div class="card-body">
                        <!-- Filter Section -->
                        <div class="filter-section mb-4">
                            <form id="filterForm" method="GET" action="{{ route('car.index') }}">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="filter_status">Status</label>
                                            <select name="status" id="filter_status" class="form-control">
                                                <option value="">All Statuses</option>
                                                <option value="pending"
                                                    {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="approved"
                                                    {{ request('status') == 'approved' ? 'selected' : '' }}>Approved
                                                </option>
                                                <option value="rejected"
                                                    {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected
                                                </option>
                                                {{-- <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option> --}}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="filter_date_from">{{ __('From Date') }}</label>
                                            <input type="date" name="date_from" id="filter_date_from"
                                                class="form-control" value="{{ request('date_from') }}">
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
                                            <label for="filter_customer">Customer</label>
                                            <input type="text" name="customer" id="filter_customer" class="form-control"
                                                placeholder="Search customer..." value="{{ request('customer') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-3 d-flex align-items-end">
                                        <button type="submit" id="applyFilter" class="btn btn-primary mr-2">
                                            <i class="fas fa-filter mr-1"></i> Filter
                                        </button>
                                        <a href="{{ route('car.index') }}" id="resetFilter"
                                            class="btn btn-outline-secondary mr-2">
                                            <i class="fas fa-redo mr-1"></i> Reset
                                        </a>
                                        <button type="button" onclick="exportToExcel()"
                                            class="btn btn-success float-right justify-end">
                                            <i class="fas fa-file-excel mr-1"></i> Export
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- Bookings Table -->
                        <div class="table-responsive">
                            <table id="bookingsTable" class="table table-bordered table-hover" style="width:100%">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Booking ID</th>
                                        <th>Customer</th>
                                        <th>Car</th>
                                        <th>Pickup Date</th>
                                        <th>Return Date</th>
                                        <th>Total </th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cars as $booking)
                                        <tr>
                                            <td>#{{ $booking->id }}</td>
                                            <td>{{ $booking->customer->name }}</td>
                                            <td>{{ $booking->category->category }} ({{ $booking->category->model }})</td>
                                            <td>{{ \Carbon\Carbon::parse($booking->arrival_date)->format('d M Y') }} at
                                                {{ $booking->arrival_time }}</td>
                                            <td>{{ \Carbon\Carbon::parse($booking->leave_date)->format('d M Y') }} at
                                                {{ $booking->leave_time }}</td>
                                            <td>{{ number_format($booking->total, 2) }} $</td>
                                            <td>
                                                <span
                                                    class="badge badge-pill
                                                @if ($booking->status == 'pending') badge-warning
                                                @elseif($booking->status == 'approved') badge-success
                                                @elseif($booking->status == 'rejected') badge-danger
                                                @else badge-info @endif">
                                                    {{ ucfirst($booking->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="{{ route('car.show', $booking->id) }}"
                                                        class="btn btn-sm btn-info action-btn" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('car.edit', $booking->id) }}"
                                                        class="btn btn-sm btn-primary action-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('car.updateStatus', $booking->id) }}"
                                                        method="POST" class="form-inline d-inline-block">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="form-group">
                                                            <select name="status" class="form-control form-control-sm"
                                                                onchange="this.form.submit()">
                                                                <option value="pending"
                                                                    {{ $booking->status == 'pending' ? 'selected' : '' }}>
                                                                    Pending</option>
                                                                <option value="approved"
                                                                    {{ $booking->status == 'approved' ? 'selected' : '' }}>
                                                                    Approved</option>
                                                                <option value="rejected"
                                                                    {{ $booking->status == 'rejected' ? 'selected' : '' }}>
                                                                    Rejected</option>
                                                                {{-- <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Completed</option> --}}
                                                            </select>
                                                        </div>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="pagination">
                            <ul class="pagination">
                                <li class="page-item">
                                    <a class="page-link" href="{{ $cars->previousPageUrl() }}">
                                        <i class="fas fa-arrow-left"></i> Previous
                                    </a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="{{ $cars->nextPageUrl() }}">
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
            $('#filter_status, #filter_date_range, #filter_date_from, #filter_date_to, #filter_customer').change(
                function() {
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
                $('#bookingsTable tbody').html(
                    '<tr><td colspan="8" class="text-center"><i class="fas fa-spinner fa-spin"></i> Loading...</td></tr>'
                );

                $.ajax({
                    url: '{{ route('admin.booking') }}',
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
                        $('#bookingsTable tbody').html(
                            '<tr><td colspan="8" class="text-center text-danger">Error loading data</td></tr>'
                        );
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

    <script>
        function exportToExcel() {

            const form = document.getElementById('filterForm');
            const exportForm = document.createElement('form');
            exportForm.method = 'GET';
            exportForm.action = "{{ route('car.export') }}";


            const inputs = form.querySelectorAll('input, select');
            inputs.forEach(input => {
                const clone = input.cloneNode(true);
                exportForm.appendChild(clone);
            });

            document.body.appendChild(exportForm);
            exportForm.submit();
            document.body.removeChild(exportForm);
        }
    </script>
@endsection
