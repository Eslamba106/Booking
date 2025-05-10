function calculate_earn() {
    var buyPrice = parseFloat($('input[name="buy_price"]').val()) || 0;
    var salePrice = parseFloat($('input[name="price"]').val()) || 0;
    var night_count = parseFloat($('input[name="days_count"]').val()) || 0;
    var commission_percentage = parseFloat($('input[name="commission_percentage"]').val()) || 0;
    var commission_night = parseFloat($('input[name="commission_night"]').val()) || 0;
    var broker_amount = parseFloat($('input[name="broker_amount"]').val()) || 0;
    var commission_type = $('#commission_type').val();

    let commission = 0, earn = 0, total = 0;

    if (commission_type === 'percentage') {
        commission = (buyPrice * commission_percentage) / 100;
        earn = ((salePrice - (buyPrice - commission) - broker_amount) * night_count);
    } else if (commission_type === 'night') {
        commission = commission_night;
        earn = ((salePrice - (buyPrice - commission) - broker_amount) * night_count);
    }

    total = salePrice * night_count;

    $('input[name="total"]').val(total.toFixed(2));
    $('input[name="earn"]').val(earn.toFixed(2));
}

$(document).ready(function () {
    $('input[name="buy_price"], input[name="price"]').on('keyup change', calculate_earn);
});