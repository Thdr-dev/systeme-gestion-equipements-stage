const autoRemoveToast = (toastId, duration = 3000) => {
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
