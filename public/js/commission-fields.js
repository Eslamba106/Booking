function toggleCommissionFields() {
    var commission = document.querySelector('input[name="commission"]:checked')?.value;
    var commissionType = document.getElementById('commission_type').value;

    if (commission === "yes") {
        document.querySelector('.commission_html').style.display = 'block';
        if (commissionType === "percentage") {
            document.querySelector('.percentage_html').style.display = 'block';
            document.querySelector('.night_html').style.display = 'none';
        } else {
            document.querySelector('.night_html').style.display = 'block';
            document.querySelector('.percentage_html').style.display = 'none';
        }
    } else {
        document.querySelector('.commission_html').style.display = 'none';
        document.querySelector('.percentage_html').style.display = 'none';
        document.querySelector('.night_html').style.display = 'none';
    }
}

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('input[name="commission"]').forEach(el => {
        el.addEventListener("change", toggleCommissionFields);
    });
    document.querySelector('input[name="commission"]:checked')?.dispatchEvent(new Event('change'));
    toggleCommissionFields();
});