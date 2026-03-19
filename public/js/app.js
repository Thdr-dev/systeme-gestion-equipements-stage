// Error message

let errorTimer;

const errorToast = document.getElementById("errorToast");
if (errorToast) {
    clearTimeout(errorTimer);

    errorTimer = setTimeout(() => {
        errorToast.remove();
    }, 3000);
}

// Sucess message

let successTimer;

const successToast = document.getElementById("successToast");
if (successToast) {
    clearTimeout(successTimer);

    successTimer = setTimeout(() => {
        successToast.remove();
    }, 3000);
}

// Form Search
let searchTimer;
document.getElementById("search-input").oninput = () => {
    clearTimeout(searchTimer);

    searchTimer = setTimeout(() => {
        document.getElementById("search-form").submit();
    }, 1000);
};
