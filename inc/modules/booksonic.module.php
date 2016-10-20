<?php
	function getBooksonicDetails($User) {
		//Print data in a way that Booksonic is expecting.
		$data = array ("username" => $User->getUsername());
		return $data;
	}
?>
