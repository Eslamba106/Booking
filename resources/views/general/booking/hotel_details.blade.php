<div class="card mt-2">
    <div class="card-header">
        <div class="d-flex gap-2">
            <h4 class="mb-0">{{ __('booking.hotel_details') }}</h4>
        </div>
    </div>
<div class="card-body">
    <!-- First Row -->
    <div class="row g-3 align-items-end">
        <div class="col-md-3">
            <div class="form-group">
                <label>{{ __('general.hotel') }}
                    <button type="button" data-target="#add_hotel" data-add_hotel="" data-toggle="modal" class="btn btn--primary btn-sm">
                        <i class="fa fa-plus-square"></i>
                    </button>
                    <span class="text-danger">*</span>
                </label>
                <select required name="hotel_id" class="form-control js-select2-custom">
                    <option value="">{{ __('general.select') }}</option>
                    @foreach ($hotels as $hotel_item)
                        <option value="{{ $hotel_item->id }}">{{ $hotel_item->name }}</option>
                    @endforeach
                </select>
                @error('hotel_id')
                    <span class="error text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label>{{ __('general.country') }} <span class="text-danger">*</span></label>
                <select name="country" disabled class="form-control js-select2-custom"></select>
                @error('country')
                    <span class="error text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label>{{ __('general.city') }}</label>
                <input type="text" name="city" readonly class="form-control">
                @error('city')
                    <span class="error text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label>{{ __('booking.booking_no') }} <span class="text-danger">*</span></label>
                <input type="text" required name="booking_no" class="form-control">
                @error('booking_no')
                    <span class="error text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>

    <!-- Second Row -->
   <!-- Second Row -->
<div class="row g-3 align-items-end mt-3">
    <div class="col-md-3">
        <div class="form-group">
            <label>{{ __('Room Type / Apartment') }} <span class="text-danger">*</span></label>
            <select name="unit_type_id" required class="form-control js-select2-custom">
                @foreach ($unit_types as $unit_type_item)
                    <option value="{{ $unit_type_item->id }}">{{ $unit_type_item->name }}</option>
                @endforeach
            </select>
            @error('unit_type_id')
                <span class="error text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-md-2">
    <div class="form-group">
        <label>{{ __('Meals') }}
            <button type="button" data-target="#add_meal" data-add_meal="" data-toggle="modal" class="btn btn--primary btn-sm">
                <i class="fa fa-plus-square"></i>
            </button>
            <span class="text-danger">*</span>
        </label>
        <select required name="food_type" class="form-control js-select2-custom">
            <option value="">{{ __('general.select') }}</option>
            @foreach ($meals as $meal)
                <option value="{{ $meal->name }}">{{ $meal->name }}</option>
            @endforeach
        </select>
        @error('food_type')
            <span class="error text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>

<div class="col-md-2">
    <div class="form-group">
       <label class="form-label">{{ __('booking.number_of_units') }}<span class="text-danger">*</span></label>
        <div class="input-group">
            <button type="button" class="btn btn-outline-third" onclick="decrease('units_count')">-</button>
            <input type="number" id="units_count" name="units_count" class="form-control text-center"
                value="1" min="1" required>
            <button type="button" class="btn btn-outline-third" onclick="increase('units_count')">+</button>
        </div>
        @error('units_count')
            <span class="error text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>




</div>

</div>



</div>
