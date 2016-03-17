<?php
/**
 * Defines shortcode and features for displaying people
 * @author Danial Bleile
 * @version 0.0.1
 */
class CAHNRSWP_College_People {
	
	/**
	 * Define actions for init of the plugin
	 */
	public function plugin_init(){
		
		add_shortcode('cahnrs_people', array( $this  , 'get_cahnrs_people' ) );
		
	} // end plugin_init
	
	/**
	 * Do cahnrs_people shortcode
	 * @param array $atts Attributes from shortcode
	 */
	public function get_cahnrs_people( $atts ){
		
		require_once 'class-cahnrswp-college-person.php';
		
		$defaults = array( 
			'display' => 'card',
			'columns' => 4,
			'netids'  => '', 
			);
		
		$atts = shortcode_atts( $defaults , $atts , 'cahnrs_people' );
		
		$people = array();
		
		if ( ! empty( $atts['netids'] ) ){
			
			$net_ids = explode( ',' , $atts['netids'] );
			
			foreach( $net_ids as $slug ){
				
				$person = new CAHNRSWP_College_Person();
				
				$slug = str_replace( '.' , '-' , $slug );
				
				if ( $person->set_person_by_slug( $slug , $atts ) ) $people[] = $person;
				
			} // end foreach
			
		} // end if
		
		// TO DO: add else if for id query
		
		
		switch( $atts['display'] ){
			
			default: 
				$html = $this->get_cahnrs_people_card( $atts , $people );
				break;
		} // end switch
		
		return $html;
		
	} // end get_cahnrs_people
	
	/**
	 * Gets HTML for display=card in cahnrs_people
	 * @param array $people Array of CAHNRSWP_College_Person instances
	 * @param array $atts Shortcode attributes with defaults set
	 * @return string HTML for the card(s)
	 */
	private function get_cahnrs_people_card( $atts , $people ){
		
		//var_dump( $people );
		
		$html = '<div class="cahnrs-people-card-set columns-' . $atts['columns'] . '">';
		
		foreach( $people as $index => $person ){
			
			$image = $person->get_image();
			
			if ( ! $image ) $image = plugins_url( 'images/placeholder.jpg' , dirname(__FILE__) );
			
			$html .= '<div class="cahnrs-people-item cahnrs-people-card profile-' . $person->get_slug() . '">';
			
				$html .= '<ul class="profile-card">';
				
					$html .= '<li class="profile-image"><img src="' . $image . '" alt="Profile Picture for ' . $person->get_name() . '"/></li>';
					
					$html .= '<li class="profile-name">' . $person->get_name() . '</li>';
					
					$html .= '<li class="profile-title">' . $person->get_title() . '</li>';
					
					$html .= '<li class="profile-email"><a href="mailto:' . $person->get_email() . '">' . $person->get_email() . '</a></li>';
					
					$html .= '<li class="profile-phone">Phone: ' . $person->get_phone() . '</li>';
				
				$html .= '</ul>';
		
			$html .= '</div>';
			
		} // end foreach
		
		$html .= '</div>';
		
		return $html;
		
	} // end get_cahnrs_people_card
	
} // end CAHNRSWP_College_People