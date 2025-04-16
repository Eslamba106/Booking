@extends('layouts.dashboard')

@section('title')
    {{ __('departments.departments') }}
@endsection


@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">    {{ __('departments.departments') }}</h4>
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
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    <!-- basic table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ __('departments.departments') }}</h4>
                    <div class="row m-t-40">
                        <!-- Column -->
                        <div class="col-md-6 col-lg-3 col-xlg-3">
                            <div class="card card-hover">
                                <div class="box bg-primary text-center">
                                    <h1 class="font-light text-white">{{ __('roles.name') }}</h1>
                                    <h6 class="text-white">{{ $department->name }}</h6>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 col-lg-3 col-xlg-3">
                            <div class="card card-hover">
                                <div class="box bg-info text-center">
                                    <h1 class="font-light text-white">{{ $users->count() ?? "0"}}</h1>
                                    <h6 class="text-white">{{ __('roles.User_Count') }}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 col-xlg-3"><a href="{{ route('documents.show_department_documents' ,$department->id ) }}">
                            <div class="card card-hover">
                                <div class="box bg-success text-center">
                                    <h1 class="font-light text-white">{{ $department->documents->count() }}</h1>
                                    <h6 class="text-white">{{ __('documents.files') }}</h6>
                                </div>
                            </div>
                        </a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="zero_config" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>{{ __('roles.name') }}</th>
                        
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    
                                
                                <tr>
                                    <td><span 
                                        {{-- class="label  label-success" --}}
                                        >{{ $user->name }}</span></td>
                              
                                </tr>
                                @empty
                                    
                                @endforelse
                            </tbody>
                              
                        </table>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection