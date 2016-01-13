$(document).ready(function (){
	
$("#file-1").fileinput({
		//showUpload: false,
		// showCaption: false,
		language: 'es',
		allowedFileExtensions : ['jpg','jpeg', 'png','gif'],
		maxFileSize: 1000,
		browseClass: "btn btn-primary btn-sm",
		// fileType: "any",
  //       previewFileIcon: "<i class='glyphicon glyphicon-king'></i>"
	});
});

