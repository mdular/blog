/**
* admin pages scripts
*/

$(document).ready(function () {
	tinymce.init({
            //theme : "advanced",
            //mode : "specific_textareas",
            selector : ".tinymce",
            menubar : false,
            //content_css: "css/content.css",
            plugins: "code image link",
            // info: http://www.tinymce.com/wiki.php/Configuration:toolbar
            // list: http://www.tinymce.com/wiki.php/Controls
            toolbar: "undo redo | styleselect | bold italic underline strikethrough | blockquote alignleft aligncenter alignright alignjustify | bullist numlist | outdent indent | link image | code"
            /*
		    image_list: [ 
		        {title: 'My image 1', value: 'http://www.tinymce.com/my1.gif'}, 
		        {title: 'My image 2', value: 'http://www.moxiecode.com/my2.gif'} 
		    ]*/
            /*
            style_formats: [
		        {title: 'Bold text', inline: 'b'},
		        {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
		        {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
		        {title: 'Example 1', inline: 'span', classes: 'example1'},
		        {title: 'Example 2', inline: 'span', classes: 'example2'},
		        {title: 'Table styles'},
		        {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
		    ],*/
    });
});