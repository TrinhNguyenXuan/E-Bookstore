function filterBook() {
    var input, filter, i, txtValue;
    input = document.getElementById("searching");
    filter = input.value.toUpperCase();
    bookDisplay = document.getElementsByClassName("book")
    titles = document.getElementsByClassName("title")
    for (i = 0; i < titles.length; i++) {
        txtValue = titles[i].innerText
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            bookDisplay[i].style.display = "";
        } else {
            bookDisplay[i].style.display = "none";
        }
    }
}