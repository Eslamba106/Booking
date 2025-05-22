@extends('layouts.dashboard')
@section('title')
<?php $lang = Session::get('locale'); ?>

    {{ __('roles.customer_management') }}
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">{{ __('roles.customer_management') }}</h4>
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

                    {{-- فورم البحث --}}
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <form method="get" action="{{ route('admin.customer') }}">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control"
                                           placeholder="Search"
                                           value="{{ request('search') }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="la la-search"></i> Search
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- أدوات التحكم الجماعي --}}
                    <form method="get" action="{{ route('admin.customer') }}">
                        <div class="row align-items-center">
                            @can('change_customers_status')
                                <div class="col-md-3 mb-2">
                                    <select name="status" class="form-control">
                                        <option value="">{{ __('dashboard.set_status') }}</option>
                                        <option value="1">{{ __('dashboard.active') }}</option>
                                        <option value="2">{{ __('dashboard.disactive') }}</option>
                                    </select>
                                </div>
                            @endcan

                            <div class="col-md-9 d-flex justify-content-end flex-wrap">
                                <button type="submit" name="bulk_action_btn" value="update_status"
                                        class="btn btn-primary mr-2 mb-2">
                                    <i class="la la-refresh"></i> {{ __('dashboard.update') }}
                                </button>

                                @can('delete_customer')
                                    <button type="submit" name="bulk_action_btn" value="delete"
                                            class="btn btn-danger delete_confirm mr-2 mb-2">
                                        <i class="la la-trash"></i> {{ __('dashboard.delete') }}
                                    </button>
                                @endcan

                                @can('create_customer')
                                    <a href="{{ route('admin.customer.create') }}"
                                       class="btn btn-secondary mb-2">
                                        <i class="la la-plus"></i> {{ __('dashboard.create') }}
                                    </a>
                                @endcan
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th><input class="bulk_check_all" type="checkbox" /></th>
                            <th class="text-center" scope="col">{{ __('roles.name') }}</th>
                            <th class="text-center" scope="col">{{ __('roles.email') }}</th>
                            <th class="text-center" scope="col">@lang('login.phone')</th>
                            <th class="text-center" scope="col">@lang('general.nationality')</th>
                            <th class="text-center" scope="col">@lang('roles.status')</th>
                            <th class="text-center" scope="col">{{ __('roles.Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($customers as $customer)
                            <tr>
                                <th scope="row">
                                    <label>
                                        <input class="check_bulk_item" name="bulk_ids[]" type="checkbox"
                                            value="{{ $customer->id }}" />
                                        <span class="text-muted">#{{ $customer->id }}</span>
                                    </label>
                                </th>
                                <td class="text-center">{{ $customer->name }}</td>
                                <td class="text-center">{{ $customer->email   }}</td>
                                <td class="text-center">{{ $customer->phone }} </td>
                                <td class="text-center">{{ $customer->country->nationality }} </td>

                                <td class="text-center"> <span
                                        class="badge badge-pill {{ $customer->status == 'active' ? 'badge-success' : 'badge-danger' }}">{{ $customer->status }}</span>
                                </td>

                                <td class="text-center">
                                    @can('delete_customer')
                                        <a href="{{ route('admin.customer.delete', $customer->id) }}"
                                            class="btn btn-danger btn-sm" title="@lang('dashboard.delete')"><i
                                                class="fa fa-trash"></i></a>
                                    @endcan
                                    @can('edit_customer')
                                        <a href="{{ route('admin.customer.edit', $customer->id) }}"
                                            class="btn btn-outline-info btn-sm" title="@lang('dashboard.edit')"><i
                                                class="mdi mdi-pencil"></i> </a>
                                    @endcan
                                    <a href="{{ route('admin.customer.show', $customer->id) }}"
                                        class="btn btn-outline-info btn-sm" title="@lang('dashboard.show')"><i
                                     class="mdi mdi-eye"></i> </a>

                                    <a href="{{ route('admin.show.file',$customer->id) }}"
                                        class="btn btn-outline-info btn-sm" title="@lang('dashboard.file')"><i
                                     class="mdi mdi-file"></i> </a>
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
