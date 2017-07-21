#!/bin/bash

echo "Checking internet connection"
wget -q --tries=10 --timeout=20 --spider http://google.com
if [[ $? -eq 0 ]]; then
	echo "Online"
else
	echo "ERROR: no internet connection"
	exit 1
fi

echo "Updating"
sudo apt-get update -qq >> /dev/null

echo "Upgrading"
sudo apt-get upgrade -y >> /dev/null

echo "Installing Apache, PHP and MySQL"
echo ">>>>>> IMPORTANT: insert 'admin' when a password is needed"
sudo apt-get update -y >> /dev/null
sudo apt-get upgrade -y >> /dev/null
sudo apt-get install apache2 -y >> /dev/null
sudo apt-get install php5 libapache2-mod-php5 -y >> /dev/null
sudo apt-get install mysql-server php5-mysql -y
sudo service apache2 restart >> /dev/null

echo "Database setup"
sudo rm -R /var/www/html/*
sudo cp -R /home/pi/webapp/* /var/www/html/
cd /var/www/html/utils
mysql -u "root" "-padmin" -e "create database webapp;"
mysql -u "root" "-padmin" "webapp" < "webapp.sql"
mysql -u "root" "-padmin" -e "CREATE USER 'webapp'@'localhost' IDENTIFIED BY 'webapp';"
mysql -u "root" "-padmin" -e "GRANT ALL PRIVILEGES ON * . * TO 'webapp'@'localhost';"
mysql -u "root" "-padmin" -e "FLUSH PRIVILEGES;"

echo "Configuring wifi and web permissions"
echo "www-data	ALL = NOPASSWD: /sbin/shutdown, /bin/grep, /sbin/reboot, /bin/sed" >> /etc/sudoers

echo "Setting autostart for: background.php"
sudo touch /lib/systemd/system/webappbackground.service
echo "[Unit]" >> /lib/systemd/system/webappbackground.service
echo "Description=Webapp background service" >> /lib/systemd/system/webappbackground.service
echo "After=multi-user.target" >> /lib/systemd/system/webappbackground.service
echo "[Service]" >> /lib/systemd/system/webappbackground.service
echo "Type=idle" >> /lib/systemd/system/webappbackground.service
echo "ExecStart=/usr/bin/php5 /var/www/html/background.php" >> /lib/systemd/system/webappbackground.service
echo "[Install]" >> /lib/systemd/system/webappbackground.service
echo "WantedBy=multi-user.target" >> /lib/systemd/system/webappbackground.service
sudo chmod 644 /lib/systemd/system/webappbackground.service
sudo systemctl daemon-reload
sudo systemctl enable webappbackground.service

echo " "
echo " "
echo "*******************************"
echo "      INSTALLATION DONE!       "
echo "*******************************"
echo "Rebooting..."

sudo reboot