<?php
	//Print data a way that plexpy is expecting.
	//uid, token, group
	print $User->getID() . PHP_EOL;
	print $User->getToken() . PHP_EOL;
	if ($User->authURI($_GET['info'])){
		print 'admin' . PHP_EOL;
	} else {
		print 'guest' . PHP_EOL;
	}
	print $User->getUsername() . PHP_EOL;
?>