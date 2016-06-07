# PlexAuth
PHP based Plex authenticaion.

I'm using Nginx to reverse proxy a heap of different services that all tie into Plex.
I wanted to be able to have all the people I share my plex with to be able to access these things but didn't really want to share the master passwords for each service.

Using Nginx's Auth_Request module I've now been able to secure all the services using users Plex credentials.

It's not finished and a lot of the code is slapped together. I have the intention to go back and clean a lot of it up when time permits. Hope this helps someone else out there.

I plan to put up a bit of a guide on how to use it but I think its fairly straight forward. I've only tested with Ubuntu 14.04+

This requires you to have:

	1. Nginx. For nginx config check out the example.
	2. PHP
	3. PHP-Curl

You can restrict what some users can access. It works based off a Plex filter, so if the URI is added to the filter then the user can access that URI. Just use auth_request to make a second request to the URI that you wish to secure with a GET request "admin=true". To allow the user add the URI to their photos filter. Sorry, if you use photos on plex this won't work.

Custom fork of plexpy that intergrates PlexAuth and PlexPy login for SSO. https://github.com/hjone72/plexpy

There are a few quick things that need to be done to get this working:

	1. Head to: https://github.com/gbirke/rememberme follow the instructions to install RememberMe
	2. Rename sample_config.ini.php to config.ini.php and edit as needed.
	3. Rename footer_sample.php to footer.php and edit as desired.
	4. Rename nav_sample.php to nav.php and edit as desired.
	
links that may be helpful:
https://www.nginx.com/resources/wiki/start/topics/examples/imapauthenticatewithapachephpscript/
https://developers.shopware.com/blog/2015/03/02/sso-with-nginx-authrequest-module/
http://mamchenkov.net/wordpress/2015/08/19/custom-single-sign-on-with-nginx-and-auth-request-module/



Screenshots:
![alt tag](https://raw.githubusercontent.com/hjone72/PlexAuth/master/screenshots/sign-in.JPG)
![alt tag](https://raw.githubusercontent.com/hjone72/PlexAuth/master/screenshots/signed-in.JPG)

Thanks.
