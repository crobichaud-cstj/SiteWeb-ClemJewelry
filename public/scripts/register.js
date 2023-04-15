$(document).ready(() => {

    $('.txtPhone').mask('000-000-0000', { placeholder: '___-___-____' });



    $('.txtZipCode').mask('A0A 0A0', {
        placeholder: '___-___', translation: {
            A: { pattern: /[A-Za-z]/ },
        }
    });

    $('.txtZipCode').keyup(function () {
        $(this).val($(this).val().toUpperCase());
    });

    const registrationForm = document.querySelectorAll('.needs-validation-register');

    addValidationToForm(registrationForm);

});

function addValidationToForm(forms) {
    Array.prototype.slice.call(forms)
        .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        });
}