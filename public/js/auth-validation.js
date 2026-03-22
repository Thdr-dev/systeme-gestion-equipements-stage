document.addEventListener("DOMContentLoaded", function () {
    const nom = document.querySelector('input[name="nom"]');
    const prenom = document.querySelector('input[name="prenom"]');
    const email = document.getElementById("email");
    const password = document.querySelector('input[name="password"]');
    const passwordConfirm = document.querySelector(
        'input[name="password_confirmation"]',
    );

    const clearLaravelError = (inputElement) => {
        const parent = inputElement.parentElement;
        const errorDiv = parent.querySelector(".form-text.text-danger");
        if (errorDiv) {
            errorDiv.innerText = "";
        }
    };

    [nom, prenom].forEach((input) => {
        if (input) {
            input.addEventListener("input", function () {
                clearLaravelError(this);

                if (this.value.trim().length >= 1) {
                    this.classList.add("is-valid");
                } else {
                    this.classList.remove("is-invalid", "is-valid");
                }
            });
        }
    });

    email.addEventListener("input", function () {
        clearLaravelError(this);
        const re = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

        if (re.test(this.value)) {
            this.classList.remove("is-invalid");
            this.classList.add("is-valid");
        } else if (this.value.length > 0) this.classList.add("is-invalid");

        if (this.value.length === 0) {
            this.classList.remove("is-invalid", "is-valid");
        }
    });

    const validatePasswords = () => {
        clearLaravelError(password);
        const val = password.value;

        const criteria = {
            length: val.length >= 8,
            mixed: /[a-z]/.test(val) && /[A-Z]/.test(val),
            number: /\d/.test(val),
            symbol: /[\W_]/.test(val),
        };

        updateRule("rule-length", criteria.length);
        updateRule("rule-mixed", criteria.mixed);
        updateRule("rule-number", criteria.number);
        updateRule("rule-symbol", criteria.symbol);

        const isStrong = Object.values(criteria).every(Boolean);

        if (val.length === 0) {
            password.classList.remove("is-invalid", "is-valid");
        } else {
            password.classList.toggle("is-valid", isStrong);
            password.classList.toggle("is-invalid", !isStrong);
        }

        if (passwordConfirm.value !== "") {
            const matches = passwordConfirm.value === val && val !== "";
            passwordConfirm.classList.toggle("is-valid", matches);
            passwordConfirm.classList.toggle("is-invalid", !matches);
        } else {
            passwordConfirm.classList.remove("is-invalid", "is-valid");
        }
    };

    const updateRule = (id, isValid) => {
        const el = document.getElementById(id);
        if (el) {
            el.classList.toggle("text-success", isValid);
            el.classList.toggle("text-danger", !isValid);
            el.innerText = (isValid ? "✔ " : "✖ ") + el.innerText.substring(2);
        }
    };

    password.addEventListener("input", validatePasswords);
    passwordConfirm.addEventListener("input", validatePasswords);
});
