const typeSelect = document.querySelector('select[name="type"]');

const uniteDiv = document.querySelector(
    'select[name="to_unite_id"]',
).parentElement;

const delaiDiv = document.querySelector(
    'input[name="delai_maintenance"]',
).parentElement;

typeSelect.addEventListener("change", function () {
    if (this.value === "Transfert") {
        uniteDiv.classList.remove("d-none");
    } else {
        uniteDiv.classList.add("d-none");
    }

    if (this.value === "Maintenance") {
        delaiDiv.classList.remove("d-none");
    } else {
        delaiDiv.classList.add("d-none");
    }
});

window.onload = () => typeSelect.dispatchEvent(new Event("change"));
