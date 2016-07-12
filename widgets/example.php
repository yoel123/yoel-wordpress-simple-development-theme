<?php
add_action( 'widgets_init', create_function( '', 'register_widget("yitem");' ) );

class yitem extends WP_Widget
{
    /**
     * Constructor
     **/
    public function __construct()
    {
        $widget_ops = array(
            'classname' => 'y_item',
            'description' => ''
        );

        parent::__construct( 'yitem', 'y item', $widget_ops );
    }


    public function widget( $args, $instance )
    {
        extract($args,EXTR_SKIP);
		
		$title =($instance['title'])?$instance['title']:''; 
		$body =($instance['body'])?$instance['body']:''; 
		$img =(isset($instance['img']))?$instance['img']:''; 
		
		echo $before_widget;
		echo $before_title.$title.$after_title;
		echo "<p> ".$body."</p>";
		echo "<img src='".$img."'/>";
    }
	public function update( $new_instance, $old_instance ) {
	
		return $new_instance;
	}

 
    public function form( $instance )
    {
		
       $in = "<input ";
	   $put = "/>"; 
	   $text = "<textarea ";
	   $area = "</textarea>"; 
	   
	   $g_title_id = $this->get_field_id('title');
	   $g_body_id = $this->get_field_id('body');
	   
	   $g_title_name = $this->get_field_name('title');
	   $g_body_name = $this->get_field_name('body');
	   
	   $i_title = (!empty($instance['title']))?$instance['title']:"";
	   $i_body = (!empty($instance['body']))?$instance['body']:"";
	   $i_img = (!empty($instance['img']))?$instance['img']:"";
	   
	   $title = $in.
	   "id = ".$g_title_id.
	   ' class="widefat"'.
	   " name = '".$g_title_name."'".
	   "value = '".$i_title."'".
	   $put;
	   
	 
	   $body =$text.
	   "id = ".$g_body_id.
	   ' class="widefat"'.
	   " name = '".$g_body_name."'>".
	   $i_body.
	   $area;
	   
	   $img_tst = '
	   <input type="text" name="'.$this->get_field_name('img').'" value="'.$i_img.'" />
	   <input class="yupload_image_btn" type="button" value="Upload Image" />';
	   
	   //lables
	   $l_body =  '<label >body:</label>';
	   $l_title =  '<label >title:</label>';
	   
	   echo $l_title.$title.$l_body.$body.$img_tst;
    }
}
?>