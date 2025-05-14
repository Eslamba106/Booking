


<div class="card mt-2">
    <div class="card-header">
        <div class="d-flex gap-2">
            <h4 class="mb-0">{{ __('booking.finance_details') }}</h4>
        </div>
    </div>
    <div class="card-body">
        <div class="row">

            <!-- Buy Price -->
            <div class="col-12">
                <div class="form-group">
                    <label>{{ __('booking.buy_price') }}</label>
                    <input type="number" onkeyup="calculate_earn()" name="buy_price" class="form-control">
                    @error('buy_price') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label>{{ __('booking.buy_price') }} {{ __('booking.currency') }}</label>
                    <div class="currency-toggle">
                        <input type="radio" id="currency_euro_buy" name="currency_buy" value="euro" checked>
                        <label for="currency_euro_buy">{{ __('booking.euro') }}</label>

                        <input type="radio" id="currency_dolar_buy" name="currency_buy" value="dolar">
                        <label for="currency_dolar_buy">{{ __('booking.dolar') }}</label>

                        <input type="radio" id="currency_lira_buy" name="currency_buy" value="lira">
                        <label for="currency_lira_buy">{{ __('booking.lira') }}</label>
                    </div>
                    <br>
                    <div>
                        <span id="currency-error" class="alert alert-danger mt-2 p-2 d-none" >{{ __('Currency Mismatch') }}</span>

                    </div>

                </div>
            </div>
            <!-- Sale Price -->
            <div class="col-12">
                <div class="form-group">
                    <label>{{ __('booking.sale_price') }}</label>
                    <input type="number" onkeyup="calculate_earn()" name="price" class="form-control">
                    @error('price') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Currency Toggle -->
            <div class="col-12">
            <<div class="form-group">
                <label>{{ __('booking.currency') }} <span class="text-danger">*</span></label>
                <div class="currency-toggle">
                    <input type="radio" id="currency_euro" name="currency" value="euro" checked>
                    <label for="currency_euro">{{ __('booking.euro') }}</label>

                    <input type="radio" id="currency_dolar" name="currency" value="dolar">
                    <label for="currency_dolar">{{ __('booking.dolar') }}</label>

                    <input type="radio" id="currency_lira" name="currency" value="lira">
                    <label for="currency_lira">{{ __('booking.lira') }}</label>
                </div>
                @error('currency') <span id="currency-error" class="alert alert-danger mt-2 p-2 d-none" >{{ __('Currency Mismatch') }}</span>
                @enderror
                @error('currency') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
        </div>

            <!-- Commission Toggle -->
            <div class="col-12">
                <div class="form-group">
                    <label>{{ __('booking.commission') }} <span class="text-danger">*</span></label>
                    <div class="btn-group btn-group-toggle w-100">
                        <input type="radio" class="btn-check" name="commission" id="commission_no" value="no" checked>
                        <label class="btn btn-outline-secondary" for="commission_no">{{ __('booking.no') }}</label>

                        <input type="radio" class="btn-check" name="commission" id="commission_yes" value="yes">
                        <label class="btn btn-outline-secondary" for="commission_yes">{{ __('booking.yes') }}</label>
                    </div>
                    @error('commission') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Commission Type -->
            <div class="col-12 commission_html">
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
            <div class="col-12 commission_html percentage_html" style="display:none;">
                <div class="form-group">
                    <label for="">{{ __('booking.commission_percentage') }} <span class="text-danger">*</span></label>
                    <input type="number" name="commission_percentage" onkeyup="calculate_earn()" class="form-control">
                    @error('commission_percentage')
                        <span class="error text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Night Input Field -->
            <div class="col-12 commission_html night_html" style="display:none;">
                <div class="form-group">
                    <label for="">{{ __('booking.days_count') }} <span class="text-danger">*</span></label>
                    <input type="number" name="commission_night" onkeyup="calculate_earn()" class="form-control">
                    @error('commission_night')
                        <span class="error text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Broker Toggle -->
            <div class="col-12">
                <div class="form-group">
                    <label>{{ __('booking.broker') }} <span class="text-danger">*</span></label>
                    <div class="btn-group btn-group-toggle w-100">
                        <input type="radio" class="btn-check" name="broker" id="broker_no" value="no" checked>
                        <label class="btn btn-outline-info" for="broker_no">{{ __('booking.no') }}</label>

                        <input type="radio" class="btn-check" name="broker" id="broker_yes" value="yes">
                        <label class="btn btn-outline-info" for="broker_yes">{{ __('booking.yes') }}</label>
                    </div>
                    @error('broker') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Broker Name -->
            <div class="col-12 broker_html">
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
            <div class="col-12 broker_html">
                <div class="form-group">
                    <label>{{ __('booking.broker_amount') }}</label>
                    <input type="number" name="broker_amount" onkeyup="calculate_earn()" class="form-control">
                    @error('broker_amount') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Earn -->
            <div class="col-12">
                <div class="form-group">
                    <label>{{ __('booking.earn') }}</label>
                    <input type="number" name="earn" class="form-control" readonly>
                    @error('earn') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Total -->
            <div class="col-12">
                <div class="form-group">
                    <label>{{ __('booking.total') }}</label>
                    <input type="number" name="total" class="form-control" readonly>
                    @error('total') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                <label class="form-label">{{ __('Extra service') }}</label><br>
                <div class="btn-group btn-group-toggle w-100" role="group">
                    <input type="radio" class="btn-check" name="toggle_service" id="service_yes" autocomplete="off" value="yes">
                    <label class="btn btn-outline-success" for="service_yes">Yes</label>

                    <input type="radio" class="btn-check" name="toggle_service" id="service_no" autocomplete="off" value="no" checked>
                    <label class="btn btn-outline-danger" for="service_no">No</label>
                </div>
          </div>

                     <div id="serviceFormContainer" style="display: none;">


                                <div class="col-md-6 col-lg-4 col-xl-6">
                                    <div class="form-group">
                                        <label for="clientName">{{ __('roles.name') }} <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control" id="clientName" style="text-transform:uppercase;" />
                                        @error('name')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                     </div>
                                <div class="form-group">
                                    <label>{{ __('Price') }} <span class="text-danger">*</span></label>
                                    <input type="number" name="service_price" class="form-control" id="price" />
                                    @error('price') <span class="error text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="form-group">
                                    <label>{{ __('Quantity') }} <span class="text-danger">*</span></label>
                                    <input type="number" name="qyt" class="form-control" id="qty" />
                                    @error('qty') <span class="error text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="form-group">
                                    <label>{{ __('booking.total') }}</label>
                                    <input type="number" name="total_price" class="form-control" id="total_price" readonly />
                                    @error('total') <span class="error text-danger">{{ $message }}</span> @enderror
                                </div>

                            </div>



                        </div>




    </div>
</div>
