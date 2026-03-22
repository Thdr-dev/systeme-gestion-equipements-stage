document.addEventListener("DOMContentLoaded", function () {
    const email = document.querySelector('input[name="email"]');
    const password = document.querySelector('input[name="password"]');

    const clearLaravelError = (input) => {
        const errorMsg = input.parentElement.querySelector(".text-danger");
        if (errorMsg) errorMsg.innerText = "";
    };

    email.addEventListener("input", function () {
        clearLaravelError(this);
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (re.test(this.value)) {
            this.classList.remove("is-invalid");
            this.classList.add("is-valid");
        } else {
            this.classList.remove("is-valid");
            if (this.value.length > 0) this.classList.add("is-invalid");
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
