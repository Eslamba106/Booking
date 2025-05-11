 function calculate_earn() {
            var buyPrice = parseFloat($('input[name="buy_price"]').val()) || 0;
            var salePrice = parseFloat($('input[name="price"]').val()) || 0;
            var night_count = parseFloat($('input[name="days_count"]').val()) || 0;
            var commission_percentage = parseFloat($('input[name="commission_percentage"]').val()) || 0;
            var commission_night = parseFloat($('input[name="commission_night"]').val()) || 0;
            var broker_amount = parseFloat($('input[name="broker_amount"]').val()) || 0;
            var commission_type = $('#commission_type').val();
            if (commission_type === 'percentage') {
                var commission = (buyPrice * commission_percentage) / 100;
                var earn = ((salePrice - (buyPrice - commission) - broker_amount) * night_count);
                var total = (salePrice * night_count);
            } else if (commission_type == 'night') {
                var commission = commission_night;
                var earn = ((salePrice - (buyPrice - commission)  - broker_amount) * night_count)
                var total = (salePrice * night_count) ;
            } else {
                var commission = 0;
            }

            $('input[name="total"]').empty();
            $('input[name="earn"]').empty();
            $('input[name="total"]').val(total.toFixed(2));
            $('input[name="earn"]').val(earn.toFixed(2));
        }
        $(document).ready(function() {
            $('input[name="buy_price"], input[name="price"]').on('keyup change', function() {
                calculate_earn();
            });
        });
        function calculateNights() {
            const checkIn = new Date($('#arrival_date').val());
            const checkOut = new Date($('#check_out_date').val());

            if (!isNaN(checkIn) && !isNaN(checkOut) && checkOut > checkIn) {
                const diffTime = Math.abs(checkOut - checkIn);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                $('#days_count').val(diffDays);
            } else {
                $('#days_count').val('');
            }
        }

        $('#arrival_date, #check_out_date').on('change', calculateNights);
