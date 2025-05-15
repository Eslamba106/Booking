@extends('layouts.dashboard')
@section('title')
<?php $lang = Session::get('locale'); ?>

    {{ __('roles.hotel_management') }}
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">{{ __(' Meals management') }}</h4>

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



        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="input-group mb-3 d-flex justify-content-end">






                        <a href="{{ route('category.create') }}" class="btn btn-secondary mt-3 mr-2">
                            <i class="la la-refresh"></i> {{ __('dashboard.create') }}
                        </a>

                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th><input class="bulk_check_all" type="checkbox" /></th>
                            <th class="text-center" scope="col">{{ __('Category') }}</th>
                            <th class="text-center" scope="col">{{ __('Lisance number') }}</th>
                            <th class="text-center" scope="col">{{ __('Model') }}</th>
                            <th class="text-center" scope="col">{{ __('price per day') }}</th>

                            <th class="text-center" scope="col">{{ __('roles.Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($car_category as $category)
                            <tr>
                                <th scope="row">
                                    <label>
                                        <input class="check_bulk_item" name="bulk_ids[]" type="checkbox"
                                            value="{{ $category->id }}" />
                                        <span class="text-muted">#{{ $category->id }}</span>
                                    </label>
                                </th>
                                <td class="text-center">{{ $category->category }}</td>
                                <td class="text-center">{{ $category->car_number }}</td>
                                <td class="text-center">{{ $category->model }}</td>
                                <td class="text-center">{{ $category->price_per_day }}</td>


                                <td class="text-center">

                                    <a href="{{ route('category.edit', $category->id) }}"
                                       class="btn btn-outline-info btn-sm" title="@lang('Edit')">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>
                                    <form action="{{ route('category.destroy', $category->id) }}"
                                          method="POST"
                                          style="display:inline-block;"
                                          onsubmit="return confirm('{{ __('Are you sure?') }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" title="@lang('Delete')">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                        @endforelse


                    </tbody>
                </table>
            </div>
        </div>
        </div>




@endsection
