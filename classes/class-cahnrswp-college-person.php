<?php
/**
 * Defines person object
 * @author Danial Bleile
 * @version 0.0.1
 */
class CAHNRSWP_College_Person {
	
	//@var int $id
	protected $id;
	
	//@var string $slug
	protected $slug;
	
	//@var string $name
	protected $name;
	
	//@var string $image URL
	protected $image;
	
	//@var string $email
	protected $email;
	
	//@var string $phone
	protected $phone;
	
	//@var string $title
	protected $title;
	
	/**
	 * Get method for id property
	 * @return int
	 */
	public function get_id(){ return $this->id; }
	
	/**
	 * Get method for slug property
	 * @return string slug
	 */
	public function get_slug(){ return $this->slug; }
	
	/**
	 * Get method for name property
	 * @return string name
	 */
	public function get_name(){ return $this->name; }
	
	/**
	 * Get method for name property
	 * @return string name
	 */
	public function get_image(){ return $this->image; }
	
	/**
	 * Get method for email property
	 * @return string email
	 */
	public function get_email(){ return $this->email; }
	
	/**
	 * Get method for phone property
	 * @return string phone
	 */
	public function get_phone(){ return $this->phone; }
	
	/**
	 * Get method for title property
	 * @return string
	 */
	public function get_title(){ return $this->title; }
	
	/**
	 * Set person by slug
	 * @param $slug
	 * @param array $atts Attributes from shortcode
	 */
	public function set_person_by_netid( $netid , $atts ){
		
		$url = 'https://people.wsu.edu/wp-json/wp/v2/people?filter[meta_key]=_wsuwp_profile_ad_nid&filter[meta_value]=' . $netid;
		
		$request = wp_remote_get( $url , array( 'sslverify' => false, ) );
		
		if( is_array($request) ) {
			
			$response = json_decode( wp_remote_retrieve_body( $request ) , true );
			
			if ( ! empty( $response ) ){
				
				foreach( $response as $respond ){
					
					$this->set_person_by_json( $respond , $atts );
					
				} // end foreach
				
				return true;
				
			} else {
				
				return false;
				
			} // end if
			
			
		} // end if
		
		return false;
		
		//var_dump( $request );
		
	} // end set_person_by_slug
	
	/**
	 * Set properties from json response
	 * @param array $response JSON response from WP Rest Request V2
	 * @param array $atts Attributes from shortcode
	 */
	public function set_person_by_json( $response , $atts ){
		
		//var_dump( $response );
		
		$this->id = $response['id'];
		
		$this->slug = $response['slug'];
		
		$this->name = $response['title']['rendered'];
		
		$this->image = $response['profile_photo'];
		
		$this->email = $response['email'];
		
		$this->phone = $response['phone'];
		
		$this->title = $response['position_title'];
		
	} // end set_person_by_json
	 
	
	
} // end CAHNRSWP_College_Person
