<?php
	function test_login() {
	  $CI = & get_instance();  //get instance, access the CI superobject
	  $isLoggedIn = $CI->session->userdata('logged_in');
	  if( $isLoggedIn ) {
	     return TRUE;
	  }
	  return FALSE;  
	}
?>