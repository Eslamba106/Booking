document.addEventListener('DOMContentLoaded', function () {
    const input = document.querySelector("#phone");

    const iti = window.intlTelInput(input, {
        nationalMode: false,
        autoHideDialCode: false,
        separateDialCode: false,
        utilsScript: "{{ asset('intel/js/utils.js') }}"
    });

    input.addEventListener('input', function () {
        const val = input.value;
        const countryData = window.intlTelInputGlobals.getCountryData();
        for (let i = 0; i < countryData.length; i++) {
            const code = '+' + countryData[i].dialCode;
            if (val.startsWith(code)) {
                iti.setCountry(countryData[i].iso2);
                break;
            }
        }
    });
});

function keepPlusSign(input) {
    if (!input.value.startsWith("+")) {
        input.value = "+" + input.value.replace(/[^0-9]/g, '');
    }
}