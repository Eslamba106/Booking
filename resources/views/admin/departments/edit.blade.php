@extends('layouts.dashboard')

@section('title')
    {{ __('roles.edit_department') }}
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">{{ __('departments.departments') }}</h4>
                <div class="d-flex align-items-center">

                </div>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex no-block justify-content-end align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#">{{ __('dashboard.home') }} </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('dashboard.dashboard') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-5"></div>
    <div class="col-12">
        <div class="card">
            <form action="{{ route('departments.update' , $department->id) }}" method="post">
                @csrf
                <div class="input-group mb-3">
                    {{-- <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="ti-user"></i></span>
                    </div> --}}
                    <input type="text" name="name" value="{{ $department->name }}" class="form-control form-control-lg" placeholder="{{ __('roles.name') }}" aria-label="Username" aria-describedby="basic-addon1">
                    @error('email') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th><input class="bulk_check_all"  type="checkbox" /></th>
                            <th scope="col">{{ __('roles.name') }}</th>

                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <th scope="row">
                                    <label>
                                        <input class="check_bulk_item" name="users[]" type="checkbox"
                                        value="{{ $user->id }}" {{ $department->users->firstWhere('id', $user->id) ? 'checked' : '' }} />
                                        <span class="text-muted">#{{ $user->id }}</span>
                                    </label>
                                </th>
                                <td>{{ $user->name }}</td>
                               
                            
                            </tr>
                        @empty
                        @endforelse


                    </tbody>
                </table>
            </div>
            <div class="form-group mt-2"  style="text-align: {{ (Session::get('locale') == 'en') ?  "right;margin-right:10px" : "left;margin-left:10px"}}">
                <button type="submit" class="btn btn-primary mt-5">{{ __('dashboard.save') }}</button>
            </div>
        </form>
        </div>
    </div>
@endsection
