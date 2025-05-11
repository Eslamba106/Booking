
let currentStep = 0;
const steps = document.querySelectorAll('.step');
showStep(currentStep);

function showStep(n) {
    steps.forEach((step, i) => step.style.display = i === n ? 'block' : 'none');
    document.getElementById('prevBtn').style.display = n === 0 ? 'none' : 'inline-block';
    document.getElementById('nextBtn').style.display = n === steps.length - 1 ? 'none' : 'inline-block';
    document.getElementById('submitBtn').classList.toggle('d-none', n !== steps.length - 1);
}

function nextPrev(n) {
    if (n === 1 && !validateStep()) return;
    currentStep += n;
    showStep(currentStep);
}

function validateStep() {
    const inputs = steps[currentStep].querySelectorAll('input, select, textarea');
    let valid = true;
    inputs.forEach(input => {
        if (!input.checkValidity()) {
            input.classList.add('is-invalid');
            valid = false;
        } else {
            input.classList.remove('is-invalid');
        }
    });
    return valid;
}
