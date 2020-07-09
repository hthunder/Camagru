let deleteBtns = document.querySelectorAll(".commentary__delete-btn");

for (let i = 0; i < deleteBtns.length; i++) {
    deleteBtns[i].addEventListener("click", deleteComment);
}

function deleteComment() {
    let commentId = this.dataset.commentId;
    if (commentId) {
        let targetComment = this;
        ajax("/comment/delete", "POST", function (response) {
            if (response === true)
                targetComment.parentNode.parentNode.remove();
        }, {commentId});
    }
    
}
