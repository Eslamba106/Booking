<!-- ============================================================== -->
<!-- Start Page Content -->
<!-- ============================================================== -->



<div class="card-header">
    <h4 class="mb-0">{{ __('booking.booking_details') }}</h4>
</div>

<div class="card-body">
    <div class="row g-2 align-items-end">
        <!-- Customer Name -->
        <div class="col-md-3">
            <div class="form-group">
                <label for="">{{ __('booking.customer_name') }}
                    <button type="button" data-target="#add_tenant" data-add_tenant="" data-toggle="modal"
                        class="btn btn--primary btn-sm">
                        <i class="fa fa-plus-square"></i>
                    </button> <span class="text-danger">*</span>
                </label>
                <select name="customer_id" class="form-control js-select2-custom">
                    @foreach ($customers as $customers_item)
                        <option value="{{ $customers_item->id }}">{{ $customers_item->name }}</option>
                    @endforeach
                </select>
                @error('customer_id')
                    <span class="error text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Check-in Date -->
        <div class="col-md-3">
            <input type="hidden" name="user_id" value="{{ auth()->id() }}">
            <div class="form-group">
                <label>{{ __('booking.check_in_date') }} <span class="text-danger">*</span>
                    <span id="arrivalDateError" style="color:red; display:none;">Invalid date</span>
                </label>
                <input type="date" id="arrival_date" name="arrival_date" onchange="calculate_earn(); validateDate()"
                    class="form-control" min="{{ \Carbon\Carbon::today()->toDateString() }}" required>
                @error('arrival_date')
                    <span class="error text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Check-out Date -->
        <div class="col-md-3">
            <div class="form-group">
                <label>{{ __('booking.check_out_date') }}
                    <span id="checkoutDateError" style="color:red; display:none;" class="text-danger">*Invalid
                        date</span>
                </label>
                <input type="date" id="check_out_date" name="check_out_date"
                    onchange="calculate_earn(); validateDate()" class="form-control"
                    min="{{ \Carbon\Carbon::tomorrow()->toDateString() }}" required>
                @error('check_out_date')
                    <span class="error text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Days Count -->
        <div class="col-md-3">
            <div class="form-group" style=" width: 40%;">
                <label for="days_count">{{ __('booking.days_count') }}</label>
                <input type="number" name="days_count" id="days_count" readonly class="form-control text-center"
                    style="width:100%;">
                @error('days_count')
                    <span class="error text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>




    <br>
    <div class="row g-2 align-items-end">
        <!-- حق الإلغاء -->
        <div class="col-md-2">

            <label>{{ __('Right of Cancellation') }}
                <button type="button" data-target="#add_cancel" data-add_cancel="" data-toggle="modal"
                    class="btn btn--primary btn-sm">
                    <i class="fa fa-plus-square"></i>
                </button>
                <span class="text-danger">*</span>
            </label>
            <select name="canceled_period" class="form-control js-select2-custom" required>
                <option value="">{{ __('general.select') }}</option>
                @foreach ($cancels as $cancel)
                    <option value="{{ $cancel->period }}">{{ $cancel->period }}</option>
                @endforeach
            </select>
            @error('canceled_period')
                <span class="error text-danger">{{ $message }}</span>
            @enderror
        </div>

        <!-- البالغين -->
        <!-- البالغين -->
        <div class="col-md-2" style="max-width: 15%; margin-left: 3%;">
            <label class="form-label">{{ __('booking.number_of_adults') }} <span class="text-danger">*</span></label>
            <div class="input-group input-group-sm">
                <button type="button" class="btn btn-outline-third btn-sm"
                    onclick="decrease('adults_count')">-</button>
                <input type="number" id="adults_count" name="adults_count" class="form-control text-center"
                    value="1" min="1" required>
                <button type="button" class="btn btn-outline-third btn-sm"
                    onclick="increase('adults_count')">+</button>
            </div>
            @error('adults_count')
                <span class="error text-danger">{{ $message }}</span>
            @enderror
        </div>

        <!-- الأطفال -->
        <div class="col-md-2" style="max-width: 15%; margin-left: 3%;">
            <label class="form-label">{{ __('booking.number_of_children') }} <span class="text-danger">*</span></label>
            <div class="input-group input-group-sm">
                <button type="button" class="btn btn-outline-third btn-sm"
                    onclick="decrease('childerns_count')">-</button>
                <input type="number" id="childerns_count" name="childerns_count" class="form-control text-center"
                    value="0" min="0">
                <button type="button" class="btn btn-outline-third btn-sm"
                    onclick="increase('childerns_count')">+</button>
            </div>
            @error('childerns_count')
                <span class="error text-danger">{{ $message }}</span>
            @enderror
        </div>

        <!-- الرضع -->
        <div class="col-md-2" style="max-width: 15%; margin-left: 3%;">
            <label class="form-label">{{ __('booking.number_of_infants') }} <span
                    class="text-danger">*</span></label>
            <div class="input-group input-group-sm">
                <button type="button" class="btn btn-outline-third btn-sm"
                    onclick="decrease('babes_count')">-</button>
                <input type="number" id="babes_count" name="babes_count" class="form-control text-center"
                    value="0" min="0">
                <button type="button" class="btn btn-outline-third btn-sm"
                    onclick="increase('babes_count')">+</button>
            </div>
            @error('babes_count')
                <span class="error text-danger">{{ $message }}</span>
            @enderror
        </div>

        <!-- الإجمالي -->
        <div class="col-md-3" style="max-width: 11%; margin-left: 4%;">
            <label class="form-label">{{ __('booking.total_person_count') }} <span
                    class="text-danger">*</span></label>
            <input type="number" readonly id="total_person_count" name="total_person_count"
                class="form-control text-center">
            @error('total_person_count')
                <span class="error text-danger">{{ $message }}</span>
            @enderror
        </div>


        <!-- عنصر إضافي (اختياري) -->


    </div>
</div>
</div>
