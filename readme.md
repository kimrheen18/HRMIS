What is HRMIS
==================

The Human Resource Management Information System (HRMIS) is a comprehensive and proactive human resource system designed to provide a single interface for government employees to erform the human resource management functions efficiently and effectively.



Installation
------------------
1.	git clone `https://bitbucket.org/sysdevdost/hrmis.git` hrmis
2.	composer dump-autoload
3.	composer install
4.	cp .htaccess-copy .htaccess
5.	cp .env.sample .env
6.	nano .env
7.	a2enmod rewrite
8.	chmod 775 .env
9.	chmod 775 -R schema/
10.	chmod 775 -R uploads/
11.	nano /etc/apache2/sites-enabled/000-default.conf
12.	add the following block inside

```
	<VirtualHost *:80>

		<Directory /var/www/html>

			Options Indexes FollowSymLinks MultiViews

			AllowOverride All

			Order allow,deny

			allow from all

		</Directory>

```
```sudo service apache2 restart```


```run hrmis/migrate in your localhost```

Server Requirements
------------------

* PHP version 7.1 or newer is recommended.
* Ubuntu 18.
* Git
 
Documentation
------------------

 [HRMISv10 Powerpoint Presentation] (https://docs.google.com/presentation/d/1uGS2of7UIxYarlfvFLySg2kX31DBh_JFYP5vZxuq8Vc/edit#slide=id.g5c00ba7bd3_11_0)
 
Acknowledgement
------------------

	DOSTCO - ITD

Other Setup
------------------

* Hrmisv10 Schema for new users:
* [https://tinyurl.com/hrmisv10-schema] (https://tinyurl.com/hrmisv10-schema)
* Password: hrmisdost
* File upload setup:
	1. Type sudo vim /etc/php/7.1/apache2/php.ini
	2. To increaes file upload size in PHP, you need to modify the upload_max_filesize and post_max_size variable's in your php.ini file, change the following setup:
		upload_max_filesize = 100M
		post_max_size = 100M
		max_file_uploads = 20

Errors:
	  The action you have requested is not allowed. (POST) or timeoutkeepalive 403 (Forbidden):
		config['csrf_regenerate'] = FALSE;

To recieved email notification:
------------------

1. Create bitbucket account here [Here] (https://bitbucket.org/account/signup/)
2. Go to [HRMIS Repository] (https://bitbucket.org/sysdevdost/hrmis)
3. Click `...`
4. Select Manage Notification