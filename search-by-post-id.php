<?php
/*
Plugin Name: Search by Post ID
Description: Enables the user to search by Post ID using the built-in search in all website. Works for all kinds of posts (posts, pages, custom post types and media).
Version: 1.0
Author: Marcos Rezende
Author URI: https://www.linkedin.com/in/rezehnde/
*/
new RezehndeSearchById();

class RezehndeSearchById
{
	function __construct()
	{
		add_filter('posts_where', array($this, 'posts_where'));
	}

	function posts_where($where)
	{
		if(is_search())
		{
			$s = $_GET['s'];

			if(!empty($s))
			{
				if(is_numeric($s))
				{
					global $wpdb;

					$where = str_replace('(' . $wpdb->posts . '.post_title LIKE', '(' . $wpdb->posts . '.ID = ' . $s . ') OR (' . $wpdb->posts . '.post_title LIKE', $where);
				}
				elseif(preg_match("/^(\d+)(,\s*\d+)*\$/", $s)) // string of post IDs
				{
					global $wpdb;

					$where = str_replace('(' . $wpdb->posts . '.post_title LIKE', '(' . $wpdb->posts . '.ID in (' . $s . ')) OR (' . $wpdb->posts . '.post_title LIKE', $where);
				}
			}
		}

		return $where;
	}
}
?>
