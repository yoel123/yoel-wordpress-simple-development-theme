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
		
		$vars = y_widget_vars("title,body,img,ytype",$instance);
		extract($vars,EXTR_SKIP);
		
		//echo "<div class='yitem_".$ytype."'>";
		//echo $before_title.$title.$after_title;
		//echo "<p> ".$body."</p>";
		//echo "<img src='".$img."'/>";
		//echo "</div>";
		 yitem_render($ytype,$vars);
    }
	
/*	public function update( $new_instance, $old_instance ) {
	
		return $new_instance;
	}
*/
 
    public function form( $instance )
    {
	   $title = y_widget_text('title',$instance,$this);
	   $body = y_widget_textarea('body',$instance,$this);
	   $img_tst = y_widget_img("img",$instance,$this);
	   
	   $select_options = array(1=>'normal',2=>'botom img');
	   $select_type = y_widget_create_selectbox('ytype' ,$select_options,$instance,$this);
	  
	   //print_r($instance);//check vals
	   
	   //lables
	   $l_body =  '<label >body:</label>';
	   $l_title =  '<label >title:</label>';
	   
	   echo $l_title.$title.$l_body.$body.$img_tst."<br><br>".$select_type;
    }
}

function yitem_render($type,$data)
{
	extract($data,EXTR_SKIP);
	if($type == 1)
	{
		echo "<div class='yitem_".$type." col-md-4'>";
		echo "<h2>".$title."</h2>";
		echo "<p> ".$body."</p>";
		echo "<img src='".$img."'/>";
		echo "</div>";
	}else
	{
		echo "<div class='yitem_".$type." col-md-4'>";
		echo "<h2>".$title."</h2>";
		echo "<img src='".$img."'/>";
		echo "<p> ".$body."</p>";
		
		echo "</div>";
	}
}

?>