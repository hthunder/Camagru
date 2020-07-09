let addBtn = document.querySelector(".commentaries__form-submit");
let form = document.querySelector(".commentaries__form");
let formText = document.querySelector(".commentaries__form-text").value;

form.addEventListener("submit", addComment);

function addComment() {
    event.preventDefault();

    let formText = document.querySelector(".commentaries__form-text").value;
    let newContent = document.createTextNode(formText);
    if (formText.length != 0) {
        let photoName = addBtn.dataset.photoName;
        let photoOwner = addBtn.dataset.photoOwner;
        let commentAuthor = addBtn.dataset.guestName;
        let totalCommentsNumber = document.querySelectorAll(".commentary").length;

        let article = document.createElement("article");
        article.classList.add("commentary");
        if (totalCommentsNumber >= 5)
            article.classList.add("commentary_hidden");

        let paragraph = document.createElement("p");
        paragraph.classList.add("commentary__text");

        let span = document.createElement("span");
        span.classList.add("commentary__author");
        span.textContent = commentAuthor + ": ";

        let button = document.createElement("button");
        button.classList.add("commentary__delete-btn");
        button.textContent += "x";
        button.addEventListener("click", deleteComment);

        article.appendChild(paragraph);
        paragraph.appendChild(span);
        paragraph.appendChild(newContent);
        paragraph.appendChild(button);

        let showMore = document.querySelector(".commentaries__show-more");
        document.querySelector(".page__commentaries").insertBefore(article, showMore);
        
        let totalHidden = document.querySelectorAll(".commentary_hidden").length;
        if (totalHidden > 0) {
            let input = document.createElement("input");
            input.classList.add("commentaries__show-more");
            input.type = "button";
            input.value = "Показать больше";
            input.onclick = showMoreComments;
            if (document.querySelector(".commentaries__show-more"))
                document.querySelector(".commentaries__show-more").remove();
            document.querySelector(".page__commentaries").insertBefore(input, null);  
        } else if (totalHidden == 0) {
            if (showMore)
                showMore.remove();
        }
        let allDelBtns = document.querySelectorAll(".commentary__delete-btn");
        let numbOfBtns = allDelBtns.length;
        ajaxFormData(form, "/comment/add", "POST", {photoName, photoOwner}, function(response){
            if (response) {
                allDelBtns[numbOfBtns - 1].dataset.commentId = response;
            }
        });
        document.querySelector(".commentaries__form-text").value = "";
    }
}
