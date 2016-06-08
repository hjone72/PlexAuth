Here are some instructions that I have used to create a working PlexAuth on a digital Ocean dropplet.
http://PlexAuth.sytes.net/plexauth

1.	Sudo apt-get update
2.	Sudo apt-get install nginx #Must be version 1.5.4+ or custom built with auth_request. If you are running a version of nginx lower than 1.5.4 this link may help: https://by-example.org/install-nginx-with-http2-support-on-ubuntu-14-04-lts/
3.	Sudo apt-get install php5 #ignore any errors about apache2
4.	Sudo apt-get install php5-curl
5.	Sudo apt-get install php5-fpm #Depending on your setup you may need to change who nginx/php is running as.
6.	Sudo apt-get install git
7.	cd /usr/share/nginx/html
8.	sudo git clone https://github.com/hjone72/PlexAuth
9. sudo mv ./PlexAuth ./plexauth
10.	cd plexauth
11.	sudo cp ./nginx_example/example_2.conf /etc/nginx/conf.d/www.conf #Note that with newer versions of nginx the config might be in a different spot.
12. #Edit /etc/nginx/conf.d/www.conf as needed.
13.	#In my example_2 I will use a free domain name “PlexAuth.sytes.net”. This will not be SSL.
14. sudo mv ./plexauth/inc/sample_config.ini.php ./plexauth/inc/config.ini.php #Edit as needed.
15. sudo mv ./plexauth/inc/nav_sample.php ./plexauth/inc/nav.php #Edit as needed.
16. sudo mv ./plexauth/inc/footer_sample.php ./plexauth/inc/footer.php #Edit as needed.
17. sudo mkdir ./plexauth/inc/tokens
18. sudo chown www-data -R ./plexauth
19. sudo chmod 775 -R ./plexauth
