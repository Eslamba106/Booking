
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->



                    <div class="card-header">
                        <h4 class="mb-0">{{ __('booking.booking_details') }}</h4>
                    </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-lg-4 col-xl-6">
                                    <div class="form-group">
                                        <label for="">{{ __('booking.customer_name') }} <button type="button"
                                                data-target="#add_tenant" data-add_tenant="" data-toggle="modal"
                                                class="btn btn--primary btn-sm">
                                                <i class="fa fa-plus-square"></i>
                                            </button> <span class="text-danger">*</span> </label>
                                        <select name="customer_id" class="form-control js-select2-custom ">
                                            @foreach ($customers as $customers_item)
                                                <option value="{{ $customers_item->id }}">{{ $customers_item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('customer_id')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xl-3">
                                    <input type="hidden" name="user_id" value="{{auth()->id()}}">
                                    <div class="form-group">
                                        <label for="">{{ __('booking.check_in_date') }} <span
                                                class="text-danger">*</span></label>
                                                <input type="date" id="arrival_date" name="arrival_date"
                                                onchange="calculate_earn(); validateDate()" class="form-control"
                                                min="{{ \Carbon\Carbon::today()->toDateString() }}"required>
                                            <span id="arrivalDateError" style="color:red; display:none;">Invalid date</span>


                                        @error('arrival_date')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xl-3">

                                    <div class="form-group">
                                        <label for="">{{ __('booking.check_out_date') }} <span
                                                class="text-danger">*</span></label>
                                                <input type="date" id="check_out_date" name="check_out_date"
                                                onchange="calculate_earn(); validateDate()" class="form-control"
                                                min="{{ \Carbon\Carbon::tomorrow()->toDateString() }}" required>
                                            <span id="checkoutDateError" style="color:red; display:none;">Invalid date</span>
                                        @error('check_out_date')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>




                                <div class="col-12">
                                    <div class="form-group d-flex flex-wrap gap-4 justify-content-between align-items-end">

                                        <!-- Adults -->
                                        <div class="d-flex flex-column">
                                            <label class="mb-1" for="days_count">{{ __('booking.days_count') }}</label>
                                            <div class="">
                                                <input type="number" name="days_count" id="days_count" readonly class="form-control text-center" style="width:120px">
                                            </div>
                                            @error('days_count')
                                                <span class="error text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="d-flex flex-column">
                                            <label class="mb-1" for="canceled_period">{{ __('booking.cancellation_period') }} <span class="text-danger">*</span></label>
                                            <div class="">
                                                <select  name="canceled_period" class="form-control js-select2-custom " required>
                                                    <option value="">{{ __('general.select') }}</option>
                                                    @foreach ($cancels as $cancel)
                                                        <option value="{{ $cancel->period }}">{{ $cancel->period }}</option>
                                                    @endforeach
                                                </select>
                                                 @error('canceled_period')
                                                <span class="error text-danger">{{ $message }}</span>
                                            @enderror
                                            </div>


                                        </div>

                                        <div class="d-flex flex-column">
                                            <label class="mb-1">{{ __('booking.number_of_adults') }} <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <button type="button" class="btn btn-outline-third" onclick="decrease('adults_count')">-</button>
                                                <input type="number" id="adults_count" name="adults_count" class="form-control text-center"
                                                    value="1" min="1" required style="max-width: 80px;">
                                                <button type="button" class="btn btn-outline-third" onclick="increase('adults_count')">+</button>
                                            </div>
                                            @error('adults_count')
                                                <span class="error text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <!-- Children -->
                                        <div class="d-flex flex-column">
                                            <label class="mb-1">{{ __('booking.number_of_children') }} <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <button type="button" class="btn btn-outline-third" onclick="decrease('childerns_count')">-</button>
                                                <input type="number" id="childerns_count" name="childerns_count" class="form-control text-center"
                                                    value="0" min="0" style="max-width: 80px;">
                                                <button type="button" class="btn btn-outline-third" onclick="increase('childerns_count')">+</button>
                                            </div>
                                            @error('childerns_count')
                                                <span class="error text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <!-- Infants -->
                                        <div class="d-flex flex-column">
                                            <label class="mb-1">{{ __('booking.number_of_infants') }} <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <button type="button" class="btn btn-outline-third" onclick="decrease('babes_count')">-</button>
                                                <input type="number" id="babes_count" name="babes_count" class="form-control text-center"
                                                    value="0" min="0" style="max-width: 80px;">
                                                <button type="button" class="btn btn-outline-third" onclick="increase('babes_count')">+</button>
                                            </div>
                                            @error('babes_count')
                                                <span class="error text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <!-- Total Persons -->
                                        <div class="d-flex flex-column">
                                            <label class="mb-1">{{ __('booking.total_person_count') }} <span class="text-danger">*</span></label>
                                            <input type="number" readonly id="total_person_count" name="total_person_count"
                                                class="form-control text-center" style="max-width: 120px;">
                                            @error('total_person_count')
                                                <span class="error text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                    </div>
                                </div>
                                  </div>
                        </div>
                    </div>
