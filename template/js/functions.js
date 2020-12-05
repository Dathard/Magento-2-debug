function previewPhoto(input, whereToShow) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function(e) {
			$(whereToShow + " .input-file-wrapper").css("background-image", "url("+e.target.result+")");
			$(whereToShow + " label").addClass("hide-label");
		}

		reader.readAsDataURL(input.files[0]);
	}
}