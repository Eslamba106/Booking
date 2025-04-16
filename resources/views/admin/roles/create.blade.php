@extends('layouts.dashboard')

@section('title')
    {{ __('roles.roles') }}
@endsection

@section('content')

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">{{ __('roles.all_roles') }}</h4>
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
                            <li class="breadcrumb-item active" aria-current="page">{{ __('dashboard.all_roles') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-5"></div>
    <section class="section" >

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="section-body">

            {{-- <div class="row"> --}}
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.roles.store') }}"
                            method="Post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="row">
                                <div class="col-12 col-md-6 col-lg-6">

                                    @if (empty($role))
                                        <div class="form-group @error('name') is-invalid @enderror">
                                            <label>{{ trans('roles.name') }}</label>
                                            <input type="text" name="name" class="form-control"
                                                value="{{ !empty($role) ? $role->name : old('name') }}" placeholder="" />

                                            {{-- <p class="mt-1 text-muted">{{ trans('update.role_name_hint') }}</p> --}}
                                        </div>

                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $error }}
                                            </div>
                                        @enderror
                                    @endif

                                    <div class="form-group @error('caption') is-invalid @enderror">
                                        <label>{{ trans('roles.Caption') }}</label>
                                        <input type="text" name="caption" class="form-control"
                                            value="{{ !empty($role) ? $role->caption : old('caption') }}" placeholder="" />

                                        @error('caption')
                                            <div class="invalid-feedback">
                                                {{ $error }}
                                            </div>
                                        @enderror
                                    </div>



                                </div>
                            </div>


                            <div class="form-group" id="sections">
                                {{-- <input class="bulk_check_all" type="checkbox" value="Select All" /> --}}
                                {{-- <h2 class="section-title">{{ trans('admin/main.permission') }}</h2>
                                    <p class="section-lead">
                                        {{ trans('admin/main.permission_description') }}
                                    </p> --}}
                                {{-- @can('Create_Admin_Roles') --}}
                                <div class="mt-3"></div>
                                    <div class="row">
                                        @foreach ($sections as $section)
                                            <div
                                                class="section-card is_{{ $section->type }} col-12 col-md-6 col-lg-4 {{ (!empty($role) and $role->is_admin and $section->type == 'panel') ? 'd-none' : '' }} {{ (!empty($role) and !$role->is_admin and $section->type == 'admin') ? 'd-none' : '' }} {{ (empty($role) and $section->type == 'admin') ? 'd-none' : '' }}">
                                                <div class="card card-primary section-box">
                                                    <div class="card-header">
                                                        <input type="checkbox" name="permissions[]"
                                                            id="permissions_{{ $section->id }}" value="{{ $section->id }}"
                                                            {{ isset($permissions[$section->id]) ? 'checked' : '' }}
                                                            class="form-check-input mt-0 section-parent">
                                                        <label class="form-check-label font-16 font-weight-bold cursor-pointer {{ session()->get('locale') == 'en' ? '' : 'mr-4'  }}"
                                                            for="permissions_{{ $section->id }}">
                                                            {{ __('roles.' . $section->caption) }}
                                                        </label>
                                                    </div>

                                                    @if (!empty($section->children))
                                                        <div class="card-body">

                                                            @foreach ($section->children as $key => $child)
                                                                <div class="form-check mt-1">
                                                                    <input type="checkbox" name="permissions[]"
                                                                        id="permissions_{{ $child->id }}"
                                                                        value="{{ $child->id }}"
                                                                        {{ isset($permissions[$child->id]) ? 'checked' : '' }}
                                                                        class="form-check-input section-child">
                                                                    <label class="form-check-label cursor-pointer mt-0 {{ session()->get('locale') == 'en' ? '' : 'mr-4'  }}"
                                                                        for="permissions_{{ $child->id }}">
                                                                        {{ __('roles.' . $child->caption) }}
                                                                    </label>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                {{-- @endcan --}}
                            </div>

                            <div class=" mt-4">
                                <button class="btn btn-primary">{{ trans('Save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- </div> --}}
        </div>
    </section>


    @if (Session::has('success'))
        <script>
            swal("Message", "{{ Session::get('success') }}", 'success', {
                button: true,
                button: "Ok",
                timer: 3000,
            })
        </script>
    @endif
    @if (Session::has('info'))
        <script>
            swal("Message", "{{ Session::get('info') }}", 'info', {
                button: true,
                button: "Ok",
                timer: 3000,
            })
        </script>
    @endif
@endsection
@section('js')
    <script src="{{ asset('js/roles.min.js') }}"></script>
@endsection
