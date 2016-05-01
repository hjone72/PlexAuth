<?php
	$ini_array = parse_ini_file("config.ini.php");
	if (isset($_COOKIE[$ini_array['cookie']])){
		//Plex Token already exists. Attempt to authenticate.
		if (AttemptAuth($_COOKIE[$ini_array['cookie']])){
			//User logged in successfully.
			?>
			<!DOCTYPE html>
			<html lang="en">
			<head>
			<!-- Get Plex Info -->
			  <?php $user = GetUserInfo($_COOKIE[$ini_array['cookie']]); ?>

			<!--  Meta  -->
			  <?php require_once 'inc/meta.php'; ?>

			  <title>Your Tech Base</title>

			<!--  CSS  -->
			  <?php require_once 'inc/css.php'; ?>

			</head>
			<body class="grey lighten-4">

			<!--  Nav  -->
			  <?php require_once 'inc/nav.php'; ?>

			<main>
			  <div class="container">
				<div class="section">

				  <div class="row">
					<div class="col s12">
					  <h1>Welcome loser</h1>
					</div>
				  </div>

				</div>
			  </div>
			</main>

			<!--  Footer  -->
			  <?php require_once 'inc/footer.php'; ?>

			<!--  Scripts  -->
			  <?php require_once 'inc/javascripts.php'; ?>

			  </body>
			</html>
		<?php
		} else {
			//User must login.
			Login();
		}
		
	} else {
		//Plex token doesn't exist. User needs to login again.
		Login();
	}
	function AttemptAuth($token) {
		//Load static values from ini. $ini_array['token']
		$ini_array = parse_ini_file("config.ini.php");
		//Attempt to authenticate with supplied token.
		$host = "https://plex.tv/users/account?X-Plex-Token="; //Plex account info URL.
		$user_info = simplexml_load_file($host . $token); //Attempt to login as user with supplied token.
		
		$auth = false; //Auth is false unless set otherwise.
		
		if (!array_key_exists("error",$json)){ //user successfully authenticated with plex.
			$PA_Token = $ini_array['token'];
			$sxml = simplexml_load_file("https://plex.tv/pms/friends/all?X-Plex-Token=" . "$PA_Token"); //Load friends list.
			
			$ClaimedUser = ($user_info->attributes()['username']); //Set the username that is trying to authenticate into variable.
			foreach (($sxml->User) as $user){ //foreach user that Plex is shared with check if it is this user.
				if (strcmp(strtolower($ClaimedUser), strtolower($user['username'])) == 0){
					$auth = true; //User is a match. Auth is true.
					break;
				}
			}
			if ($ClaimedUser == $ini_array['plexowner']){
                //Override for PlexOwner since plex isn't shared with the owner.
				$auth = true;
			}
		}
		return $auth;
	}
	
	function GetUserInfo($token) {
		//Attempt to authenticate with supplied token.
		$host = "https://plex.tv/users/account?X-Plex-Token="; //Plex account info URL.
		$user_info = simplexml_load_file($host . $token); //Attempt to login as user with supplied token.
		return $user_info;
	}
	
	function Login(){
		?>
			<html lang="en">
			<head>

			<!--  Meta  -->
			  <?php require_once 'inc/meta.php'; ?>

			  <title>Secure Sign in - Your Tech Base</title>

			<!--  CSS  -->
			  <?php require_once 'inc/css.php'; ?>

			<!--  Login  -->
			  <?php require_once 'inc/login.php'; ?>

			</head>
			<body class="grey lighten-4">

			<main class="valign-wrapper">
			  <div class="container valign">
				<div class="section">

				<div class="row">
				  <div class="col col l6 offset-l3 m8 offset-m2 s12 z-depth-4 holding-box grey lighten-5">

				  <div class="row">
					<div class="col s12 center">
					  <h1 class="text-inset">Sign in</h1>
					</div>
				  </div>
				  <form method="post">
					<div class="row">
					  <div class="input-field col s12">
						<input id="email" name="PlexEmail" type="email" class="validate">
						<label for="email">Email</label>
					  </div>
					</div>
					<div class="row">
					  <div class="input-field col s12">
						<input id="password" name="PlexPassword" type="password" class="validate">
						<label for="password">Password</label>
					  </div>
					</div>
					<div class="row right-align">
					  <button class="btn waves-effect waves-light light-blue" type="submit" name="action">Submit
						<i class="material-icons right">send</i>
					  </button>
					</div>
				  </form>
				  </div>
				</div>

				</div>
			  </div>
			</main>

			<!--  Scripts  -->
			  <?php require_once 'inc/javascripts.php'; ?>

			  </body>
			</html>
			
		<?php
		
	}
?>
