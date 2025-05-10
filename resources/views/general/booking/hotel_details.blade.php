<div class="card mt-2">
    <div class="card-header">
        <div class="d-flex gap-2">
            <h4 class="mb-0">{{ __('booking.hotel_details') }}</h4>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 col-lg-4 col-xl-6">
                <div class="form-group">
                    <label for="">{{ __('general.hotel') }}<button type="button"
                        data-target="#add_hotel" data-add_hotel="" data-toggle="modal"
                        class="btn btn--primary btn-sm">
                        <i class="fa fa-plus-square"></i>
                    </button> <span
                            class="text-danger">*</span></label>
                    <select required name="hotel_id" class="form-control js-select2-custom ">
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
            <div class="col-md-6 col-lg-4 col-xl-6">
                <div class="form-group">
                    <label for="">{{ __('general.country') }} <span
                            class="text-danger">*</span></label>
                    <select name="country" disabled class="form-control js-select2-custom ">
                    </select>
                    @error('country')
                        <span class="error text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6 col-lg-4 col-xl-6">
                <div class="form-group">
                    <label for="">{{ __('general.city') }} </label>
                    <input type="text" name="city" readonly class="form-control">
                    @error('city')
                        <span class="error text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6 col-lg-4 col-xl-6">
                <div class="form-group">
                    <label for="">{{ __('booking.booking_no') }}<span class="text-danger">
                            *</span> </label>
                    <input type="text" required name="booking_no" class="form-control">
                    @error('booking_no')
                        <span class="error text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6 col-lg-4 col-xl-6">
                <div class="form-group">
                    <label for="">{{ __('roles.all_unit_types') }} <span
                            class="text-danger">*</span></label>
                    <select name="unit_type_id" required class="form-control js-select2-custom ">
                        @foreach ($unit_types as $unit_type_item)
                            <option value="{{ $unit_type_item->id }}">{{ $unit_type_item->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('unit_type_id')
                        <span class="error text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6 col-lg-4 col-xl-6">
                <div class="form-group">
                    <label for="">{{ __('Meals') }} <span
                            class="text-danger">*</span></label>

                    <select required name="food_type" class="form-control js-select2-custom ">
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
            <div class="col-md-6 col-lg-4 col-xl-6">
                <div class="form-group">
                    <label for="">{{ __('booking.number_of_units') }} <span
                            class="text-danger">*</span></label>
                    <input type="number" name="units_count" class="form-control">
                    @error('units_count')
                        <span class="error text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>
