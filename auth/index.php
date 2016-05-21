<?php	
		//$path = __DIR__;
		$path = dirname(__DIR__);
		//$path .= '/..'
		//Adds inc directory to includes. Ensure this actually adds the path to where your files are located. /var/www/PlexAuth/inc
        set_include_path(get_include_path() . PATH_SEPARATOR . $path . '/inc');
		//Include all the files needed for PlexAuth
		$ini_array = parse_ini_file($path."/inc/config.ini.php"); //Config file that has configurations for site.
		$GLOBALS['ini_array'] = $ini_array;
		session_start(); //Start PHP session.
		require_once('plex_function.php');
		require_once('PlexUser.class.php');
		
		require_once $path.'/inc/rememberme/vendor/autoload.php';
		use Birke\Rememberme;
		
		$storagePath = $path."/inc/tokens";
		if(!is_writable($storagePath) || !is_dir($storagePath)) {
			die("'$storagePath' does not exist or is not writable by the web server.
					To run the example, please create the directory and give it the
					correct permissions.");
		}
		$storage = new Rememberme\Storage\File($storagePath);
		$rememberMe = new Rememberme\Authenticator($storage);
		$rememberMe->setExpireTime($GLOBALS['ini_array']['expire_time']);
		$rememberMe->setCookieName($GLOBALS['ini_array']['remember_cookie']);
		$new_cookie = $rememberMe->getCookie();
		$new_cookie->setPath('/');
		$new_cookie->setDomain($GLOBALS['ini_array']['domain']);
		$new_cookie->setSecure(true);
		$new_cookie->setHttpOnly(false);
		$rememberMe->setCookie($new_cookie);
		
		// First, we initialize the session, to see if we are already logged in
		session_start();
		$debug = true; //Debug.
		if ($debug) {
			$logPath = $path."/inc/tokens/auth.log";
		} else {
			$logPath = "";
		}
		
		function writeLog($message = "", $logPath = "", $debug = false){
			if (!$debug) {
				return;
			} else {
				$logFile = fopen($logPath, "a");
				$message = "\n".date("h:i:sa").": ".$message;
				fwrite($logFile, $message);
				fclose($logFile);
			}
		}
		
		if(!empty($_SESSION['ytbuser'])) {
			writeLog("User exists in Session", $logPath, $debug);
			writeLog($_SESSION['ytbuser'], $logPath, $debug);
			$User = unserialize($_SESSION['ytbuser']);
			if ($_GET['admin']){
				if ($User->authURI($_GET['uri'])){
					returnAuth(true, $User);
				} else {
					returnAuth(false, $User, true);
				}
			} else {
				if($User->getAuth()){
					// User is still logged in - show content
					returnAuth(true, $User);
				}else{
					//User has been loaded but not authed. This is odd.
					//print_r ($_SESSION);
					returnAuth(false, $User);
					writeLog("User was loaded but noth authed.", $logPath, $debug);
					print 'ERROR User has been loaded but not authed. This is odd.';
				}
			}
		} else {
			writeLog("No session exists.", $logPath, $debug);
			//$loginresult = $rememberMe->login();
			writeLog("Cookie will not be used to login.", $logPath, $debug);
			$loginresult = false;
			//writeLog("Cookie status: " . $loginresult, $logPath, $debug);
			if ($loginresult) {
				if(CookieLogin($loginresult)){
					writeLog("Logged in user: " . $_SESSION['ytbuser'], $logPath, $debug);
					// There is a chance that an attacker has stolen the login token, so we store
					// the fact that the user was logged in via RememberMe (instead of login form)
					$_SESSION['remembered_by_cookie'] = true;
					$User = unserialize($_SESSION['ytbuser']);
					writeLog("Return true auth for: " . $User->getUsername(), $logPath, $debug);
					returnAuth(true, $User);
				} else {
					writeLog("User failed login. CookieLogin.", $logPath, $debug);
					returnAuth(false);
					print 'CookieLogin';
				}
			} else {
				writeLog("No login result returned.", $logPath, $debug);
				returnAuth(false);
				print 'LoginResult';
			}
		}
		
		function returnAuth($value, $User = 'Unknown', $admin = false){
			if ($User !== 'Unknown') {
				$Username = $User->getUsername();
			} else {
				$Username = $User;
			}
			if ($value) {
				header('X-Username: ' . $Username, true, 200);
				print 'Authenticated';
			} else {
				if ($admin) {
					header('X-Username: ' . $Username, true, 403);
				} else {
					print 'ERROR User isnt authorized.';
					header('X-Username: ' . $Username, true, 401);
				}
			}
		}
?>

