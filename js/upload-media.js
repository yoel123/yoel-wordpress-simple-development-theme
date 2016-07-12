jQuery(document).ready(function($) {
    $(document).on("click", ".yupload_image_btn_front", function() {

        jQuery.data(document.body, 'prevElement', $(this).prev());

        window.send_to_editor = function(html) {
            var imgurl = jQuery(html).find("img:first").attr('src');
            var inputText = jQuery.data(document.body, 'prevElement');

            if(inputText != undefined && inputText != '')
            {
                inputText.val(imgurl);
				
            }

            tb_remove();
        };

        //tb_show('', 'media-upload.php?type=image&TB_iframe=true');
		tb_show('', 'wp-admin/media-upload.php?type=image&TB_iframe=true');
	    return false;
    });
	
	  $(document).on("click", ".yupload_image_btn", function() {

        jQuery.data(document.body, 'prevElement', $(this).prev());

        window.send_to_editor = function(html) {
            var imgurl = jQuery(html).find("img:first").attr('src');
            var inputText = jQuery.data(document.body, 'prevElement');

            if(inputText != undefined && inputText != '')
            {
                inputText.val(imgurl);
				
				
            }

            tb_remove();
        };

        //tb_show('', 'media-upload.php?type=image&TB_iframe=true');
		tb_show('', 'media-upload.php?type=image&TB_iframe=true');
	    return false;
    });
});