<?php
	class PlexUser
	{
		//Plex user class.
		private $username; //Plex username
		private $plexID; //PlexID
		private $email = null; //Primary email
		private $plexemail; //Plex email address
		private $thumb; //Plex picture location
		private $token; //Plex token
		private $pin; //Plex pin. Don't know what to do with this yet. Maybe useful later.
		private $auth = false; //If the user has been authenticated or not.
		private $groups; //Array of uri's that the user can access.
		private $name; //Name array. Firstname $name[0].
		
		public function __construct($token, $username = null, $password = null){
			$loginSuccess = false; //Will quickly finish creating the User if they fail to login correctly.
			if ($username != null && $password != null) {
				if ($this->getPlexToken($username, $password)){
					//Authenticated
					$token = $this->token;
					$loginSuccess = true;
				}
			} else {
				$loginSuccess = true; //The user is returning and has authed before so we'll trust them for now.
			}
			if ($loginSuccess && $token != null){
				$this->Load($token);
				$this->token = $token;
				$this->AuthUser($this->username);
			}
			$_SESSION['ytbuser'] = serialize($this);
		}
		
		private function getPlexToken($username, $password){
			//Gets plex token using UN and PW.
			//Authenticates a user
			if ($username == "" || $password == ""){
				//If username or password is blank then don't do anything.
				$username = null;
				$password = null;
			}
			if ($username != null && $password != null){
				//URL to get users details from.
				$host = "https://plex.tv/users/sign_in.json";
				//Header that will be passed to Plex. Details from this will appear in the users Plex.tv 'devices' section.
				$header = array(
								   'Content-Type: application/xml; charset=utf-8',
								   'Content-Length: 0',
								   'X-Plex-Client-Identifier: 8334-8A72-4C28-FDAF-29AB-479E-4069-C3A3',
								   'X-Plex-Product: YTB-SSO',
								   'X-Plex-Version: v2.0',
								   );
				$process = curl_init($host);
				curl_setopt($process, CURLOPT_HTTPHEADER, $header);
				curl_setopt($process, CURLOPT_HEADER, 0);
				curl_setopt($process, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
				curl_setopt($process, CURLOPT_USERPWD, $username . ":" . $password);
				curl_setopt($process, CURLOPT_TIMEOUT, 30);
				curl_setopt($process, CURLOPT_SSL_VERIFYPEER, 0);
				curl_setopt($process, CURLOPT_POST, 1);
				curl_setopt($process, CURLOPT_RETURNTRANSFER, true);
				$data = curl_exec($process);
				$curlError = curl_error($process);
				curl_close($process);
				$json = json_decode($data, true);
				if (!array_key_exists("error",$json)){
					$this->token = $json['user']['authentication_token'];
					return true;
				}
			}
			return false;
		}
		
		private function Load($token) {
			//Loads a plex users details.
			//URL to get users details from.
			$host = "https://plex.tv/users/account?X-Plex-Token=";
			//Loads user info.
			$user_info = simplexml_load_file($host . "$token");

			//While we're grabbing the users details. We should also load in some other useful info to save trips to plex in the coming requests.
			$this->username = (string)$user_info->attributes()['username'];
			$this->plexID = (string)$user_info->attributes()['id'];
			$this->pin = (string)$user_info->attributes()['pin'];
			$this->plexemail = (string)$user_info->attributes()['email'];
			$this->thumb = (string)$user_info->attributes()['thumb'];
		}
		
		public function printGroups(){
			print_r($this->groups);
		}
		
		public function authURI($uri){
			//Check if we have access to this uri.
			$fc = substr($uri, 0, 1); //Get first character. We will check if this is a slash '/'.
			if ($fc == '/') {
				$uri = substr($uri, 1); //Remove leading / (slash) from uri.
			}
			$uri = explode('/',$uri)[0]; //If there are any paths in the URL just grab the URI
			if (in_array("admin", $this->groups)){
				return true;
			} elseif (in_array($uri, $this->groups)){
				return true;
			}
			return false;
		}
		
		public function CheckToken($token){
			//Checks if input token matches stored token.
			if ($token == $this->token){
				return true;
			} else {
				return false;
			}
		}
		
		public function setToken($token){
			$this->token = $token;
			$_SESSION['ytbuser'] = serialize($this);
		}
		
		public function getToken(){
			return $this->token;
		}
		
		public function getID(){
			return $this->plexID;
		}
		
		public function setAuth($status){
			//Sets a users auth status.
			$this->auth = $status;
			$_SESSION['ytbuser'] = serialize($this);
			return $this->auth;
		}
		
		public function getAuth(){
			//Gets a users auth status.
			return $this->auth;
		}
		
		public function setThumb($thumb){
			//Sets the users thumb location.
			$this->thumb = $thumb;
			$_SESSION['ytbuser'] = serialize($this);
		}
		
		public function getThumb(){
			//returns users thumb location. This will be a URL.
			return $this->thumb;
		}
		
		public function getUsername(){
			//returns Username
			return $this->username;
		}
		
		public function setName($name) {
			$name[2] = true;
			$this->name = $name;
			$_SESSION['ytbuser'] = serialize($this);
		}
		
		public function getName() {
			if (isset($this->name)){
				return $this->name;
			} else {
				return array($this->username, null, false);
			}
		}
		
		private function AuthUser($username) {
			//Load plex friends into an array.
			$sxml = simplexml_load_file("https://plex.tv/api/users?X-Plex-Token=" . $GLOBALS['ini_array']['token']);
			$auth = false; //Auth is false unless changed.
			foreach (($sxml->User) as $user){
				//Loop through all uers and convert them to lowercase and add them to array.
				//if (strcmp($username, strtolower($user['username']))){
				if (strcmp(strtolower($username), strtolower($user['username'])) == 0) {
					$auth = true; //set auth to true.
					
					//Right here we are going to get an opportunity to grab the allowed URI's.
					$string = urldecode($user['filterPhotos']); //We are going to use the photo's filer. This could also be done with any Plex restriction option. URLdecode this too.
					$string = substr($string, 6); //Remove the label= from beginning of string.
					$permissions = explode(',',$string); //Explode the string into an array.
					$this->groups = $permissions; //Set permissions.
					
					break; //break the loop.
				}
				
				if ($username == $GLOBALS['ini_array']['plexowner']){
					//This is an override for the Plex server owner. Because the Plex server isn't technically shared with the owner.
					$auth = true;
					//Add the admin group to this user.
					$this->groups = array("admin");
				}
				
			}
			$this->auth = $auth; //Set auth status to value of auth
		}
		
		public function getEmail($plex = false){
			//returns email.
			if ($this->email != null && $plex == false){
				return $this->email;
			} else {
				return $this->plexemail;
			}
		}
		}
	}
?>