$(document).ready(function() {
	$(".view").click(viewClicked);
	$(".edit").click(editClicked);
})

function viewClicked(){
	window.location = $(this).attr("href");
}

function editClicked(){
	window.location = $(this).attr("href") + "&referer=" + window.location;
}