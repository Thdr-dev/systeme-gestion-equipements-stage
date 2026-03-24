let searchTimer;

document.getElementById("search-input").oninput = () => {
    clearTimeout(searchTimer);

    searchTimer = setTimeout(() => {
        document.getElementById("search-form").submit();
    }, 1000);
};
