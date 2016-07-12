<?php 
//oop option page
class yoption_page_test extends yoption_page  
{
  function theme_options_init()
  {
	 parent::defult_val('yoption', 'defult_val');
  
  }//end theme_options_init

  function theme_options_do_page()
  {
		$this->y_form_action();//when form is sent
		
		$yoption = get_option('yoption'); //call option val
		
		echo '<h2>theme options:</h2>';
		//the html form
		$form ='
			 
			 <p>
			 test option
			 </p >
			 <input type="text" name="yoption" value="'.$yoption .'"/>
			 <p class="submit">
				<input type="submit" class="button-primary" value="Save Options" name="update_theme_options" />
			 </p>
		';
		
		parent::yupdated_msg('Options saved',"update_theme_options");//update massage 
		echo parent::yoption_html_form($form);//render form
	}//end theme_options_do_page

  function y_form_action()
  {
		parent::update_option('yoption');
  }//end y_form_action
}

new yoption_page_test('Theme Options','edit_theme_options','theme_options');

?>