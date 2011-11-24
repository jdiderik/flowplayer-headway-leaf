<?php
/*
Plugin Name: Alpha Media Lab: Flowplayer Leaf
Plugin URI: http://www.alphamedialab.com
Description: Video Playing leaf
Author: Jeroen Diderik
Version: 0.2
Author URI: http://www.alphamedialab.com
*/

function flowplayer_leaf_options($leaf){
	if($leaf['new']){
		$leaf['config']['show-title'] = true;
		
		$leaf['options']['flowplayer-text-input'] = 'Set a Default Value';
	}


	HeadwayLeafsHelper::create_tabs(array('options' => 'Options'), $leaf['id']);
	
	//////
	
	HeadwayLeafsHelper::open_tab('options', $leaf['id']) ;
	
		HeadwayLeafsHelper::create_text_input(array('name' => 'flowplayer-video', 'value' => $leaf['options']['flowplayer-video'], 'label' => 'Video URL'), $leaf['id']);
		HeadwayLeafsHelper::create_text_input(array('name' => 'flowplayer-width', 'value' => $leaf['options']['flowplayer-width'], 'label' => 'Video width'), $leaf['id']);
		HeadwayLeafsHelper::create_text_input(array('name' => 'flowplayer-height', 'value' => $leaf['options']['flowplayer-height'], 'label' => 'Video height'), $leaf['id']);
		
		HeadwayLeafsHelper::create_textarea(array('name' => 'flowplayer-description', 'value' => $leaf['options']['flowplayer-description'], 'label' => 'Video description'), $leaf['id']);
		
/*		$flowplayer_select_options = array(
				'option-1' => 'Option 1',
				'option-2' => 'Option 2',
				'option-3' => 'Option 3'
			);
*/			
//		HeadwayLeafsHelper::create_select(array('name' => 'flowplayer-select', 'value' => $leaf['options']['flowplayer-select'], 'label' => 'flowplayer Select', 'options' => $flowplayer_select_options), $leaf['id']);
		
		HeadwayLeafsHelper::create_checkbox(array('name' => 'flowplayer-autoplay', 'value' => $leaf['options']['flowplayer-autoplay'], 'left-label' => 'flowplayer autoplay', 'checkbox-label' => 'Enable', 'no-border' => true), $leaf['id']);
				
	HeadwayLeafsHelper::close_tab();
	
	//////
	
/*	HeadwayLeafsHelper::open_tab('miscellaneous', $leaf['id']);
	
		HeadwayLeafsHelper::create_show_title_checkbox($leaf['id'], $leaf['config']['show-title']);
		HeadwayLeafsHelper::create_title_link_input($leaf['id'], $leaf['config']['leaf-title-link']);
		HeadwayLeafsHelper::create_classes_input($leaf['id'], $leaf['config']['custom-css-classes'], true);
		
	HeadwayLeafsHelper::close_tab();
*/
}

function flowplayer_leaf_content($leaf){
	//You can pull content from the leaf options by using the $leaf array.  For instance, if you want to get the value of flowplayer-text-input, you would simply use $leaf['flowplayer-text-input']
	$leafBase = WP_PLUGIN_URL.'/aml_flowplayer_leaf/';
	$autoPlay = $leaf['options']["flowplayer-autoplay"] == "on" ? "true" : "false";
	echo '<script type="text/javascript" src="'.$leafBase.'flowplayer-3.2.6.min.js"></script>
		  <a href="'.$leaf['options']["flowplayer-video"].'"
			 style="display:block;width:'.$leaf['options']["flowplayer-width"].'px;height:'.$leaf['options']["flowplayer-height"].'px;"  
			 id="player"></a> 
			<!-- this will install flowplayer inside previous A- tag. -->
		<script>
			flowplayer("player", "'.$leafBase.'flowplayer-3.2.7.swf", {
			    clip:  {
			        autoPlay: '.$autoPlay.',
			        autoBuffering: false,
			        scaling: "fit"
			    },
			    play: {opacity: 0}
			});
			jQuery(".flowplayer-leaf .headway-leaf-inside .leaf-content").width("'.$leaf['options']["flowplayer-width"].'").height("'.$leaf['options']["flowplayer-height"].'");
		</script>';
}

function register_flowplayer_leaf(){	
	$options = array(
			'id' => 'flowplayer-leaf',
			'name' => 'flowplayer Leaf',
			'options_callback' => 'flowplayer_leaf_options',
			// 'options_width' => 350,
			// 'icon' => WP_PLUGIN_URL.'/'.str_replace(basename(__FILE__), '', plugin_basename(__FILE__)).'icon.png',
			// 'show_hooks' => true,
			'content_callback' => 'flowplayer_leaf_content'
		);
	
	if(class_exists('HeadwayLeaf'))	$flowplayer_leaf = new HeadwayLeaf($options);
}
add_action('init', 'register_flowplayer_leaf');