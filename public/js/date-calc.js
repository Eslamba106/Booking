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

function validateDate() {
    const arrivalInput = document.getElementById('arrival_date');
    const checkoutInput = document.getElementById('check_out_date');
    const arrivalError = document.getElementById('arrivalDateError');
    const checkoutError = document.getElementById('checkoutDateError');

    const arrivalDate = new Date(arrivalInput.value);
    const checkoutDate = new Date(checkoutInput.value);
    const today = new Date();
    today.setHours(0, 0, 0, 0);

    arrivalError.style.display = 'none';
    checkoutError.style.display = 'none';

    let hasError = false;

    if (!arrivalInput.value || arrivalDate < today) {
        arrivalError.style.display = 'inline';
        hasError = true;
    }

    if (!checkoutInput.value || checkoutDate <= arrivalDate) {
        checkoutError.style.display = 'inline';
        hasError = true;
    }

    return !hasError;
}

$('#arrival_date, #check_out_date').on('change', calculateNights);