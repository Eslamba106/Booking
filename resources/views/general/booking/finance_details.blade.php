<div class="card mt-4">
    <div class="card-header">
        <h4>{{ __('Financial Summary') }}</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <!-- Purchase Details -->
            <div class="col-md-6">
                <div class="border p-3 mb-3">
                    <h5 class="bg-light p-2">{{ __('Purchase Details') }}</h5>
                    <div class="row">
                        <div class="col-6">
                            <p class="mb-1"><strong>{{ __('Room Cost') }}:</strong></p>

                            <input type="number" onkeyup="calculate_earn()" name="buy_price" class="form-control">
                         @error('buy_price') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-6">
                            <p class="mb-1"><strong>{{ __('booking.buy_price') }} {{ __('booking.currency') }}:</strong></p>

              <!-- Currency for Purchase -->
<div class="currency-toggle" id="buy_currency_group" role="group" aria-label="Currency Toggle">
    <input type="radio" class="btn-check" name="buy_currency" id="buy_currency_euro" value="euro" autocomplete="off" checked>
    <label class="btn btn-outline-primary" for="buy_currency_euro">{{ __('booking.euro') }}</label>

    <input type="radio" class="btn-check" name="buy_currency" id="buy_currency_dolar" value="dolar" autocomplete="off">
    <label class="btn btn-outline-success" for="buy_currency_dolar">{{ __('booking.dolar') }}</label>

    <input type="radio" class="btn-check" name="buy_currency" id="buy_currency_lira" value="lira" autocomplete="off">
    <label class="btn btn-outline-warning" for="buy_currency_lira">{{ __('booking.lira') }}</label>
</div>

<!-- Currency for Sale -->


                     <div>
                        <span id="currency-error" class="text-danger">{{ __('Currency Mismatch') }}</span>

                    </div>
                        </div>
                    </div>
                    <div class="mt-2">
                        <p class="mb-1"><strong>{{ __('Hotel Commission') }}:</strong></p>
                         <div class="btn-group btn-group-toggle w-100">
                        <input type="radio" class="btn-check" name="commission" id="commission_no" value="no" checked>
                        <label class="btn btn-outline-secondary" for="commission_no">{{ __('booking.no') }}</label>

                        <input type="radio" class="btn-check" name="commission" id="commission_yes" value="yes">
                        <label class="btn btn-outline-secondary" for="commission_yes">{{ __('booking.yes') }}</label>
                    </div>
                    @error('commission') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                    <div class=" row">
                <div class=" col-md-6 commission_html">
                <div class="form-group">
                    <label for="">{{ __('booking.commission_type') }} <span class="text-danger">*</span></label>
                    <select name="commission_type" onchange="toggleCommissionFields()" id="commission_type" class="form-control js-select2-custom">
                        <option value="percentage">{{ __('booking.percentage') }}</option>
                        <option value="night">{{ __('booking.night') }}</option>
                    </select>
                    @error('commission_type')
                        <span class="error text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Percentage Input Field -->
            <div class=" col-md-6 commission_html percentage_html" style="display:none;">
                <div class="form-group">
                    <label for="">{{ __('booking.commission_percentage') }} <span class="text-danger">*</span></label>
                    <input type="number" name="commission_percentage" onkeyup="calculate_earn()" class="form-control">
                    @error('commission_percentage')
                        <span class="error text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6 commission_html night_html" style="display:none;">
                <div class="form-group">
                    <label for="">{{ __('booking.days_count') }} <span class="text-danger">*</span></label>
                    <input type="number" name="commission_night" onkeyup="calculate_earn()" class="form-control">
                    @error('commission_night')
                        <span class="error text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
                </div>
            </div>
            </div>
   <!-- Commission Type -->


            <!-- Percentage Input Field -->


            <!-- Night Input Field -->

            <!-- Sale Details -->
            <div class="col-md-6">
                <div class="border p-3 mb-3">
                    <h5 class="bg-light p-2">{{ __('Sale Details') }}</h5>
                    <div class="row">
                        <div class="col-6">
                            <p class="mb-1"><strong>{{ __('Room Selling Price') }}:</strong></p>

                            <input type="number" onkeyup="calculate_earn()" name="price" class="form-control">
                    @error('price') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-6">
                              <p class="mb-1"><strong>{{ __('booking.currency') }}:</strong></p>
                            <div class="currency-toggle" id="sell_currency_group" role="group" aria-label="Currency Toggle">
                        <input type="radio" class="btn-check" name="currency" id="sell_currency_euro" value="euro" autocomplete="off" checked>
                        <label class="btn btn-outline-primary" for="sell_currency_euro">{{ __('booking.euro') }}</label>

                        <input type="radio" class="btn-check" name="currency" id="sell_currency_dolar" value="dolar" autocomplete="off">
                        <label class="btn btn-outline-success" for="sell_currency_dolar">{{ __('booking.dolar') }}</label>

                        <input type="radio" class="btn-check" name="currency" id="sell_currency_lira" value="lira" autocomplete="off">
                        <label class="btn btn-outline-warning" for="sell_currency_lira">{{ __('booking.lira') }}</label>
                    </div>

                    <!-- Error Message -->


                @error('currency') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="mt-2">
                        <p class="mb-1"><strong>{{ __('Broker Commission') }}:</strong></p>
                        <div class="btn-group btn-group-toggle w-100">
                        <input type="radio" class="btn-check" name="broker" id="broker_no" value="no" checked>
                        <label class="btn btn-outline-info" for="broker_no">{{ __('booking.no') }}</label>

                        <input type="radio" class="btn-check" name="broker" id="broker_yes" value="yes">
                        <label class="btn btn-outline-info" for="broker_yes">{{ __('booking.yes') }}</label>
                    </div>
                    @error('broker') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                    <div class="row">



                       <div class=" col-md-6 broker_html">
                <div class="form-group">
                    <label>{{ __('booking.broker_name') }} <span class="text-danger">*</span></label>
                    <select name="broker_id" class="form-control js-select2-custom">
                        <option value="null" selected disabled>{{ __('booking.select_broker') }}</option>
                        @foreach ($brokers as $broker_item)
                            <option value="{{ $broker_item->id }}">{{ $broker_item->name }}</option>
                        @endforeach
                    </select>
                    @error('broker') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Broker Amount -->
            <div class=" col-md-6 broker_html">
                <div class="form-group">
                    <label>{{ __('booking.broker_amount') }}</label>
                    <input type="number" name="broker_amount" onkeyup="calculate_earn()" class="form-control">
                    @error('broker_amount') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
                </div>
            </div>
</div>
            <!-- Financial Summary -->
            <div class="col-12">
                <div class="border p-3">
                    <h5 class="bg-light p-2">{{ __('Financial Summary') }}</h5>
                    <div class="row">
                        <div class="col-md-4">
                            <p class="mb-1"><strong>{{ __('Revenue per room') }}:</strong></p>
                            <input type="number" class="form-control" name="revenue_per_room" readonly>
                        </div>
                        <div class="col-md-4">
                            <p class="mb-1"><strong>{{ __('Hotel total cost') }}:</strong></p>
                            <input type="number" class="form-control" name="hotel_total_cost" readonly>
                        </div>
                        <div class="col-md-4">
                            <p class="mb-1"><strong>{{ __('Total booking price') }}:</strong></p>
                            <input type="number" class="form-control" name="total" readonly>
                        </div>
                        <div class="col-md-4 mt-2">
                            <p class="mb-1"><strong>{{ __('Total revenue') }}:</strong></p>
                            <input type="number" class="form-control" name="earn" readonly>
                            <input type="hidden" name="earn" id="earn">

                        </div>
                        <div class="col-md-4 mt-2">
                            <p class="mb-1"><strong>{{ __('Total commission') }}:</strong></p>
                            <input type="number" class="form-control" name="total_commission" readonly>
                        </div>
                        <div class="col-md-4 mt-2">
                            <p class="mb-1"><strong>{{ __('Total broker commission') }}:</strong></p>
                            <input type="number" class="form-control" name="total_broker_commission" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
