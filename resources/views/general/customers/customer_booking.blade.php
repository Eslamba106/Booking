@extends('layouts.dashboard')
@section('title')
<?php $lang = Session::get('locale'); ?>

    {{ __('roles.booking_management') }}
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">{{ __('roles.booking_management') }}</h4>
                <div class="d-flex align-items-center">

                </div>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex no-block justify-content-end align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">{{ __('dashboard.home') }} </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('dashboard.dashboard') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    {{-- @if (session()->has('locale'))
    {{ dd(session()->get('locale') ) }}
@endif --}}

    <form action="" method="get">

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="input-group mb-3 d-flex justify-content-end">
                        @can('change_bookings_status')
                            <div class="remv_control mr-2">
                                <select name="status" class="mr-3 mt-3 form-control ">
                                    <option value="">{{ __('dashboard.set_status') }}</option>
                                    <option value="1">{{ __('dashboard.active') }}</option>
                                    <option value="2">{{ __('dashboard.disactive') }}</option>
                                </select>
                            </div>



                        <button type="submit" name="bulk_action_btn" value="update_status"
                            class="btn btn-primary mt-3 mr-2">
                            <i class="la la-refresh"></i> {{ __('dashboard.update') }}
                        </button>
                        @endcan
                        @can('delete_booking')
                        <button type="submit" name="bulk_action_btn" value="delete"
                            class="btn btn-danger delete_confirm mt-3 mr-2"> <i class="la la-trash"></i>
                            {{ __('dashboard.delete') }}</button>
                            @endcan
                        {{-- @can('create_booking') --}}
                        <a href="{{ route('admin.booking.create') }}" class="btn btn-secondary mt-3 mr-2">
                            <i class="la la-refresh"></i> {{ __('dashboard.create') }}
                        </a>
                        {{-- @endcan --}}

                        @if($customerBookings->isNotEmpty())
                            @php
                                $customerId = $customerBookings->first()->customer_id;
                            @endphp
                            <a href="{{ route('reports.client.files', $customerId) }}" class="btn btn-success mt-3 mr-2">
                                <i class="fas fa-chart-line"></i> {{ __('Client File Report') }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th><input class="bulk_check_all" type="checkbox" /></th>
                            <th class="text-center" scope="col">@lang('booking.customer_name')</th>
                            <th class="text-center" scope="col">@lang('booking.hotel_name')</th>
                            <th class="text-center" scope="col">{{ __('roles.name') }}</th>
                            <th class="text-center" scope="col">{{ __('booking.check_in_date') }}</th>
                            <th class="text-center" scope="col">{{ __('booking.check_out_date') }}</th>
                            <th class="text-center" scope="col">@lang('roles.status')</th>
                            <th class="text-center" scope="col">{{ __('roles.Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($customerBookings as $booking)
                            <tr>
                                <th scope="row">
                                    <label>
                                        <input class="check_bulk_item" name="bulk_ids[]" type="checkbox"
                                            value="{{ $booking->id }}" />
                                        <span class="text-muted">#{{ $booking->id }}</span>
                                    </label>
                                </th>
                                <td class="text-center">{{ $booking->customer->name }}</td>
                                <td class="text-center">{{ $booking->hotel->name }} </td>
                                <td class="text-center">{{ $booking->total .' ' . $booking->currency   }}</td>
                                <td class="text-center">{{ $booking->arrival_date  }}</td>
                                <td class="text-center">{{ $booking->check_out_date  }}</td>

                                <td class="text-center"> <span
                                        class="badge badge-pill {{ $booking->status == 'pending' ? 'badge-success' : 'badge-danger' }}">{{ $booking->status }}</span>
                                </td>

                                <td class="text-center">
                                    @can('delete_booking')
                                        <a href="{{ route('admin.booking.delete', $booking->id) }}"
                                            class="btn btn-danger btn-sm" title="@lang('dashboard.delete')"><i
                                                class="fa fa-trash"></i></a>
                                    @endcan
                                    @can('edit_booking')
                                        <a href="{{ route('admin.booking.edit', $booking->id) }}"
                                            class="btn btn-outline-info btn-sm" title="@lang('dashboard.edit')"><i
                                                class="mdi mdi-pencil"></i> </a>
                                    @endcan
                                    @can('edit_booking')
                                        <a href="{{ route('admin.booking.show', $booking->id) }}"
                                            class="btn btn-outline-info btn-sm" title="@lang('dashboard.show')"><i
                                                class="mdi mdi-eye"></i> </a>
                                    @endcan
                                    @can('edit_booking')
                                        <a href="{{ route('admin.booking.cancel', $booking->id) }}"
                                            class="btn btn-outline-info btn-sm" title="@lang('dashboard.edit')">{{ __('dashboard.cancel') }} </a>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                        @endforelse


                    </tbody>
                </table>
            </div>
        </div>
        </div>
    </form>



@endsection
