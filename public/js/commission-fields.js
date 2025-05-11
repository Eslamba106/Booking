function toggleCommissionFields() {
    let commission = $('#commission').val();
    let type = $('#commission_type').val();

    if (commission === 'yes') {
        $('.commission_html').show();
    } else {
        $('.commission_html').hide();
        $('.percentage_html').hide();
        $('.night_html').hide();
    }

    if (type === 'percentage') {
        $('.percentage_html').show();
        $('.night_html').hide();
    } else if (type === 'night') {
        $('.night_html').show();
        $('.percentage_html').hide();
    } else {
        $('.percentage_html, .night_html').hide();
    }
}

$(document).ready(function() {
    $('.commission_html, .percentage_html, .night_html').hide();
    $('#commission, #commission_type').on('change', toggleCommissionFields);
});
$(document).ready(function() {
    $('.broker_html').hide();
    $('#has_broker').on('change', function() {
        if ($(this).val() === 'yes') {
            $('.broker_html').show();
        } else {
            $('.broker_html').hide();
        }
    });
});
