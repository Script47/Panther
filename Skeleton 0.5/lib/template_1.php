<?php 

class template {
	public $file;
	public $output;
	public $value = array();
	
	function __construct($file) {
		$this->file = $file;
		$this->output = file_get_contents($file);
	}
	
	function set($key, $value) {
		$this->value[$key] = $value;
	}
	
	function menu($array) {
		$m =  '<div class="well sidebar-nav">
		        <ul class="nav nav-list">';
		foreach($array as $label => $link) {
			if( $link == "##header##" ) {
				$m .= '<li class="nav-header">'. ucwords($label) .'</li>';
			} else {
				$m .= '<li><a href=?page='. $link .'>'. ucwords($label) .'</a></li>';
			}	
		}
		$m .= '</ul>
		      </div>';

		$this->output = str_replace("[menu]", $m, $this->output);	
	}
	
	function output() {
		foreach($this->value as $key => $value) {
			$key = "[$key]";
			$this->output = str_replace($key, $value, $this->output);	
		}
		return $this->output;
	}

}