<?php
/*
Plugin Name: Hebrew Username
Plugin URI: www.dossihost.net
Description: add Hebrew charachters to sanitize_user 
Version: 1
Author: DrMosko
Author URI: www.dossihost.net
*/



add_filter ('sanitize_user', 'hu_sanitize_user', 10, 3);

 //Overrides the Wordpress sanitize_user filter to allow hebrew letters and english letters only

function hu_sanitize_user ($username, $raw_username, $strict)
{
	//Strip HTML Tags
	$username = wp_strip_all_tags ($raw_username);

	//Remove Accents
	$username = remove_accents ($username);

	//Kill octets
	$username = preg_replace ('|%([a-fA-F0-9][a-fA-F0-9])|', '', $username);
	

	//Kill entities
	$username = preg_replace ('/&.+?;/', '', $username);

	if ($strict){
		//Replace
		$username = preg_replace( '[\p{Hebrew}a-zA-Z]', '', $username );
	}

	//Remove Whitespaces
	$username = trim ($username);

	// Consolidate contiguous Whitespaces
	$username = preg_replace ('|\s+|', ' ', $username);

	return $username;
}
