<?php	
		$path = dirname(__DIR__);
		$path .= '/inc';
		//Adds inc directory to includes. Ensure this actually adds the path to where your files are located. /var/www/PlexAuth/inc
        set_include_path(get_include_path() . PATH_SEPARATOR . $path . PATH_SEPARATOR . $path . '/modules');
		//Include all the files needed for PlexAuth
		$ini_array = parse_ini_file($path."/config.ini.php"); //Config file that has configurations for site.
		$GLOBALS['ini_array'] = $ini_array;
		if (!isset($_SESSION)) {
			session_start();
		}
		require_once('plex_function.php');
		require_once('PlexUser.class.php');
		
		require_once $path.'/rememberme/vendor/autoload.php';
		use Birke\Rememberme;
		
		$storagePath = $path."/tokens";
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
		
		//Before we continue check if this is an internal request and has a specific session_id
		if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1'){ //If the request isn't coming from the server then ignore the attempt to change Session_id.
			if (isset($_GET['session'])){
				$session_path = $GLOBALS['ini_array']['session_path'];
				$session_id = $_GET['session'];
				$session_info = file_get_contents($session_path . $session_id);
				session_decode($session_info);
			}
		}
		
		$debug = $GLOBALS['ini_array']['debug']; //Debug.
		if ($debug) {
			$logPath = $path."/tokens/auth.log";
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
		
		if(empty($_SESSION['ytbuser'])) {
                        //Give the user a chance to login with Basic auth.
                        if (!isset($_SERVER['PHP_AUTH_USER'])) {
                                header('WWW-Authenticate: Basic realm="My Realm"');
                                header('HTTP/1.0 401 Unauthorized');
                        } else {
                                if (Login($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'])){
                                        returnAuth(true);
                                } else {
                                        writeLog("No login result returned.", $logPath, $debug);
                                        returnAuth(false);
                                        print 'LoginResult';
                                }
                        }
		}

		if(!empty($_SESSION['ytbuser'])) {
			writeLog("User exists in Session", $logPath, $debug);
			writeLog($_SESSION['ytbuser'], $logPath, $debug);
			$User = unserialize($_SESSION['ytbuser']);
			if (isset($_GET['admin'])){
				if ($User->authURI($_GET['uri'])){
					returnAuth(true, $User);
				} else {
					returnAuth(false, $User, true);
				}
			} else {
				if($User->getAuth()){
					// User is still logged in - show content
					returnAuth(true, $User);
					//Handle auth for additional sites.
					if (isset($_GET['info'])){
						switch ($_GET['info']) {
							case 'plexpy':
								include_once('plexpySSO.module.php');
								break;
							case 'getgrav':
								include_once('getgrav.module.php');
								print(json_encode(getGravDetails($User)));
								break;
							case 'comicstreamer':
								include_once('ComicStreamer.module.php');
								break;
							case 'booksonic':
								include_once('booksonic.module.php');
								break;
							default:
								Print 'Unsupported return method';
								break;
						}
					}
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

			//Give the user a chance to login with Basic auth.
			if (!isset($_SERVER['PHP_AUTH_USER'])) {
			        header('WWW-Authenticate: Basic realm="My Realm"');
			        header('HTTP/1.0 401 Unauthorized');
			} else {
		                if (Login($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'])){
	        		        returnAuth(true);
		                } else {
	                                writeLog("No login result returned.", $logPath, $debug);
        	                        returnAuth(false);
                	                print 'LoginResult';
				}
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
				if (isset($_GET['debug'])){
					if ($_GET['debug']){
						print 'Authenticated';
					}
				}
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

