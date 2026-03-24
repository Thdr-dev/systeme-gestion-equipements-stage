let searchTimer;

const inputs = document.getElementsByClassName("search-input");

Array.from(inputs).forEach((element) => {
    element.oninput = () => {
        clearTimeout(searchTimer);

        searchTimer = setTimeout(() => {
            document.getElementById("search-form").submit();
        }, 1000);
    };
});
