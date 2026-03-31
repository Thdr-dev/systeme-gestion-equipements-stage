const typeSelect = document.querySelector('select[name="type"]');

const uniteDiv = document.querySelector(
    'select[name="to_unite_id"]',
).parentElement;

typeSelect.addEventListener("change", function () {
    if (this.value === "Transfert") {
        uniteDiv.style.display = "block";
    } else {
        uniteDiv.style.display = "none";
    }
});

window.onload = () => typeSelect.dispatchEvent(new Event("change"));
