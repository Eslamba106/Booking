function updateTotal() {
    const adults = parseInt(document.getElementById("adults_count").value) || 0;
    const children = parseInt(document.getElementById("childerns_count").value) || 0;
    const infants = parseInt(document.getElementById("babes_count").value) || 0;
    const total = adults + children + infants;
    document.getElementById("total_person_count").value = total;
}

function increase(id) {
    const input = document.getElementById(id);
    input.value = parseInt(input.value || 0) + 1;
    updateTotal();
}

function decrease(id) {
    const input = document.getElementById(id);
    const min = parseInt(input.min || 0);
    if (parseInt(input.value || 0) > min) {
        input.value = parseInt(input.value) - 1;
    }
    updateTotal();
}

document.addEventListener('DOMContentLoaded', function () {
    updateTotal();
    ["adults_count", "childerns_count", "babes_count"].forEach(id => {
        document.getElementById(id).addEventListener("input", updateTotal);
    });
});