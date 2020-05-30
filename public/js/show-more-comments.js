function showMoreComments() {
	let hiddenComment;
	let showMore;
	let counter = 0;
	while (counter < 5) {
		if (hiddenComment = document.querySelector('.commentary_hidden')) {
			hiddenComment.classList.remove('commentary_hidden');
		} else {
			if (showMore = document.querySelector('.commentaries__show-more')) {
				showMore.classList.add('commentaries__show-more_hidden');
			}
			break;
		}
		counter++;
	}
}