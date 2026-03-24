const autoRemoveToast = (toastId, duration = 3500) => {
    const toast = document.getElementById(toastId);
    if (toast) {
        setTimeout(() => {
            if (toast.parentNode) {
                toast.remove();
            }
        }, duration);
    }
};

document.addEventListener("DOMContentLoaded", () => {
    autoRemoveToast("errorToast");
    autoRemoveToast("successToast");
});

document.addEventListener("animationend", (e) => {
    if (e.animationName === "fadeOut") {
        e.target.remove();
    }
});
