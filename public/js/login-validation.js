document.addEventListener("DOMContentLoaded", function () {
    const email = document.querySelector('input[name="email"]');
    const password = document.querySelector('input[name="password"]');

    const clearLaravelError = (input) => {
        const errorMsg = input.parentElement.querySelector(".text-danger");
        if (errorMsg) errorMsg.innerText = "";
    };

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

    password.addEventListener("input", function () {
        clearLaravelError(this);

        if (this.value.length > 0) {
            this.classList.add("is-valid");
            this.classList.remove("is-invalid");
        } else {
            this.classList.remove("is-valid", "is-invalid");
        }
    });
});
