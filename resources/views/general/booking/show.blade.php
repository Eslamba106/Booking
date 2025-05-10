@extends('layouts.dashboard')
@section('title')
<?php $lang = Session::get('locale'); ?>
    {{ __('roles.booking_management') }}
@endsection

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h4>{{ __('booking.booking_details') }}</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Customer Name -->
                <div class="col-md-6 col-lg-4 col-xl-4">
                    <div class="form-group">
                        <label>{{ __('booking.customer_name') }}</label>
                        <input type="text" value="{{ $booking->customer->name }}" class="form-control" readonly>
                    </div>
                </div>

                <!-- Arrival Date -->
                <div class="col-md-6 col-lg-4 col-xl-4">
                    <div class="form-group">
                        <label>{{ __('booking.check_in_date') }}</label>
                        <input type="text" value="{{ $booking->arrival_date }}" class="form-control" readonly>
                    </div>
                </div>

                <!-- Check-Out Date -->
                <div class="col-md-6 col-lg-4 col-xl-4">
                    <div class="form-group">
                        <label>{{ __('booking.check_out_date') }}</label>
                        <input type="text" value="{{ $booking->check_out_date }}" class="form-control" readonly>
                    </div>
                </div>

                <!-- Days Count -->
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="form-group">
                        <label>{{ __('booking.days_count') }}</label>
                        <input type="text" value="{{ $booking->days_count }}" class="form-control" readonly>
                    </div>
                </div>

                <!-- Cancellation Period -->
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="form-group">
                        <label>{{ __('booking.cancellation_period') }}</label>
                        <input type="text" value="{{ $booking->canceled_period }}" class="form-control" readonly>
                    </div>
                </div>
            </div>

            <hr>

            <h4>{{ __('booking.guest_details') }}</h4>
            <div class="row">
                <!-- Number of Adults -->
                <div class="col-md-6 col-lg-4 col-xl-6">
                    <div class="form-group">
                        <label>{{ __('booking.number_of_adults') }}</label>
                        <input type="text" value="{{ $booking->booking_details->adults_count }}" class="form-control" readonly>
                    </div>
                </div>

                <!-- Number of Children -->
                <div class="col-md-6 col-lg-4 col-xl-6">
                    <div class="form-group">
                        <label>{{ __('booking.number_of_children') }}</label>
                        <input type="text" value="{{ $booking->booking_details->childerns_count }}" class="form-control" readonly>
                    </div>
                </div>

                <!-- Number of Infants -->
                <div class="col-md-6 col-lg-4 col-xl-6">
                    <div class="form-group">
                        <label>{{ __('booking.number_of_infants') }}</label>
                        <input type="text" value="{{ $booking->booking_details->babes_count }}" class="form-control" readonly>
                    </div>
                </div>

                <!-- Total Person Count -->
                <div class="col-md-6 col-lg-4 col-xl-6">
                    <div class="form-group">
                        <label>{{ __('booking.total_person_count') }}</label>
                        <input type="text" value="{{ $booking->booking_details->total_person_count }}" class="form-control" readonly>
                    </div>
                </div>
            </div>

            <hr>

            <h4>{{ __('booking.hotel_details') }}</h4>
            <div class="row">
                <!-- Hotel -->
                <div class="col-md-6 col-lg-4 col-xl-4">
                    <div class="form-group">
                        <label>{{ __('general.hotel') }}</label>
                        <input type="text" value="{{ $booking->hotel->name }}" class="form-control" readonly>
                    </div>
                </div>

                <!-- Country -->
                <div class="col-md-6 col-lg-4 col-xl-4">
                    <div class="form-group">
                        <label>{{ __('general.country') }}</label>
                        <input type="text" value="{{ $booking->hotel->country->name }}" class="form-control" readonly>
                    </div>
                </div>

                <!-- City -->
                <div class="col-md-6 col-lg-4 col-xl-4">
                    <div class="form-group">
                        <label>{{ __('general.city') }}</label>
                        <input type="text" value="{{ $booking->hotel->city }}" class="form-control" readonly>
                    </div>
                </div>
            </div>

            <hr>

            <h4>{{ __('booking.finance_details') }}</h4>
            <div class="row">
                <!-- Buy Price -->
                <div class="col-md-6 col-lg-4 col-xl-6">
                    <div class="form-group">
                        <label>{{ __('booking.buy_price') }}</label>
                        <input type="text" value="{{ $booking->buy_price }}" class="form-control" readonly>
                    </div>
                </div>

                <!-- Sale Price -->
                <div class="col-md-6 col-lg-4 col-xl-6">
                    <div class="form-group">
                        <label>{{ __('booking.sale_price') }}</label>
                        <input type="text" value="{{ $booking->price }}" class="form-control" readonly>
                    </div>
                </div>

                <!-- Currency -->
                <div class="col-md-6 col-lg-4 col-xl-6">
                    <div class="form-group">
                        <label>{{ __('booking.currency') }}</label>
                        <input type="text" value="{{ $booking->currency }}" class="form-control" readonly>
                    </div>
                </div>

                <!-- Commission -->
                <div class="col-md-6 col-lg-4 col-xl-6">
                    <div class="form-group">
                        <label>{{ __('booking.commission') }}</label>
                        <input type="text" value="{{ $booking->commission == 'yes' ? __('booking.yes') : __('booking.no') }}" class="form-control" readonly>
                    </div>
                </div>

                <!-- Commission Percentage -->
                <div class="col-md-6 col-lg-4 col-xl-6 commission_html percentage_html">
                    <div class="form-group">
                        <label>{{ __('booking.commission_percentage') }}</label>
                        <input type="text" value="{{ $booking->commission_percentage }}" class="form-control" readonly>
                    </div>
                </div>

                <!-- Commission Night -->
                <div class="col-md-6 col-lg-4 col-xl-6 commission_html night_html">
                    <div class="form-group">
                        <label>{{ __('booking.days_count') }}</label>
                        <input type="text" value="{{ $booking->commission_night }}" class="form-control" readonly>
                    </div>
                </div>


            <!-- Broker -->
            <div class="col-md-6 col-lg-4 col-xl-6 broker_html">
                <div class="form-group">
                    <label>{{ __('booking.broker') }}</label>
                    <input type="text" value="{{ $booking->broker_id ? 'yes' : 'no' }}" class="form-control" readonly>
                </div>
            </div>

            <!-- Broker Name -->
            <div class="col-md-6 col-lg-4 col-xl-6 broker_html">
                <div class="form-group">
                    <label>{{ __('booking.broker_name') }} <span class="text-danger">*</span></label>


                            <input type="text" value="{{  $brokers ? $brokers->name : ''}}" class="form-control" readonly>




                </div>
            </div>

            <!-- Broker Amount -->
            <div class="col-md-6 col-lg-4 col-xl-6 broker_html">
                <div class="form-group">
                    <label>{{ __('booking.broker_amount') }}</label>
                    <input type="number" name="broker_amount" value="{{ $booking->broker_amount }}" class="form-control" readonly>
                </div>
            </div>

            <hr>

            <!-- Total -->

                <div class="col-md-6 col-lg-4 col-xl-6">
                    <div class="form-group">
                        <label>{{ __('booking.total') }}</label>
                        <input type="number" value="{{ $booking->total }}" class="form-control" readonly>
                    </div>
                </div>


            <div class="col-md-6 col-lg-4 col-xl-6">
                <div class="form-group">
                    <label for="">{{ __('booking.earn') }} </label>
                    <input type="number" name="earn" class="form-control"  value="{{ $booking->earned }}"  readonly>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
