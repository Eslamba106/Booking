@extends('layouts.dashboard')
@section('title', __('Booking Details'))

@section('css')
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    <style>
        .select2-container {
            width: 100% !important;
        }

        .customer-details-box {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 5px;
            background: #f9f9f9;
        }
    </style>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">{{ __('Booking Details') }}</h4>
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th><input class="bulk_check_all" type="checkbox" /></th>
                        <th class="text-center" scope="col">{{ __('roles.name') }}</th>
                        <th class="text-center" scope="col">{{ __('roles.name') }}</th>
                        <th class="text-center" scope="col">{{ __('roles.email') }}</th>
                        <th class="text-center" scope="col">@lang('login.phone')</th>
                        <th class="text-center" scope="col">@lang('general.nationality')</th>

                        <th class="text-center" scope="col">{{ __('roles.Actions') }}</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse ($files as $file)
                        <tr>
                            <th scope="row">
                                <label>
                                    <input class="check_bulk_item" name="bulk_ids[]" type="checkbox"
                                        value="{{ $file->id }}" />
                                    <span class="text-muted">#{{ $file->id }}</span>
                                </label>
                            </th>
                            <td class="text-center">{{ $file->name }}</td>
                            <td class="text-center">{{ $file->customer->name }}</td>
                            <td class="text-center">{{ $file->customer->email }}</td>
                            <td class="text-center">{{ $file->customer->phone }} </td>
                            <td class="text-center">{{ $file->customer->country->name }} </td>

                            < <td class="text-center">

                                <a href="" class="btn btn-danger btn-sm" title="@lang('dashboard.delete')"><i
                                        class="fa fa-trash"></i>delete</a>
                                <a href="{{ route('add.items.file', $file->id) }}" class="btn btn-info btn-sm"
                                    title="@lang('dashboard.show')"><i class="fa fa-eye"></i>show</a>


                                <a href="" class="btn btn-outline-info btn-sm" title="@lang('dashboard.edit')"><i
                                        class="mdi mdi-pencil"></i>edit </a>

                                </td>
                        </tr>
                    @empty
                    @endforelse


                </tbody>
            </table>
        </div>
    </div>
@endsection
