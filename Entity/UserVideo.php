<?php

namespace UserModule\Entity;

class UserVideo {
	
	protected $id;
	protected $user_id;
	protected $title;
	protected $link;
	
	
	function __construct(array $data) {
		foreach ($data as $key => $value) {
			if (property_exists($this, $key)) {
				$this->{$key} = $value;
			}
		}
	}	
	
	function getID() {
		return $this->id;
	}
	
	function getTitle() {
		return $this->title;
	}
	
	function hasTitle() {
		return !empty($this->title);
	}
	
	function getLink() {
		return $this->link;
	}
	
	function hasLink() {
		return !empty($this->link);
	}
	
	function getUserID() {
		return $this->user_id;
	}
	
}