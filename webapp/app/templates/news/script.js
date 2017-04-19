var ajaxButton = document.getElementById("ajaxButton");
ajaxButton.addEventListener('click', function () {

    httpRequest = new XMLHttpRequest();
    lastElementIndex = document.getElementsByClassName("block").length;
    httpRequest.open('GET', location.href + '?lastIndex=' + lastElementIndex, true);
    httpRequest.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    httpRequest.onreadystatechange = function () {
        if (this.readyState == 4) {
            if (this.status == 200) {
                if (this.responseText === '') {
                    ajaxButton.style.display = 'none';
                }
                var element = document.getElementById("content");
                element.innerHTML += this.responseText;
            }
        }
    };
    httpRequest.send();
});