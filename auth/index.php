<?php
		//Load static values from ini. $ini_array['token']
		$ini_array = parse_ini_file("config.ini.php");
        $host = "https://plex.tv/users/account?X-Plex-Token=";
        $user_token = $_COOKIE[$ini_array['cookie']];
        if (isset($_COOKIE[$ini_array['cookie']])){
                $user_info = simplexml_load_file($host . $user_token);

                $auth = false;

                $ClaimedUser = ($user_info->attributes()['username']);
                $Token = $ini_array['token'];
                $sxml = simplexml_load_file("https://plex.tv/pms/friends/all?X-Plex-Token=" . "$Token");

                foreach (($sxml->User) as $user){
                        #print ($user['username']);
                        if (strcmp(strtolower($ClaimedUser), strtolower($user['username'])) == 0){
                                $auth = true;
                                break;
                        }
                }

                if ($ClaimedUser == $ini_array['plexowner']){
                        $auth = true;
                }
        }
        if ($auth){
				setcookie($ini_array['cookie'], $user_token, time() + 129600, '/', $ini_array['domain'], true);
                header('X-Username: ' . 'test', true, 200);
                        print '<HTML>';
                        print '<h1>Welcome to YTB</h1>';
                        print '<img src="' . $user_info->attributes()['thumb'] . '" alt="Profile Pic" height="60" width="60">';
                        print '<p>'.$ClaimedUser.'</p>';
                        print '</HTML>';
				//setcookie($ini_array['cookie'], $user_token, time() + 3600, '/', $ini_array['domain'], true);
        } else {
                header('X-Username: ' . 'test', true, 401);
                print 'Not authenticated';
        }
?>

