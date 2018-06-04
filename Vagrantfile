# -*- mode: ruby -*-
# vi: set ft=ruby :

VAGRANTFILE_API_VERSION = '2'

@script = <<SCRIPT

# Install dependencies

export APP_ENV=development


###################
#   Install PHP   #
###################

sudo add-apt-repository ppa:ondrej/php
sudo apt-get update

sudo apt-get install -y apache2
sudo apt-get install -y git
sudo apt-get install -y curl

apt-get install -y php7.2
apt-get install -y php7.2-bcmath php7.2-bz2 php7.2-cli php7.2-curl php7.2-intl php7.2-json php7.2-mbstring
apt-get install -y php7.2-xml php7.2-xsl php7.2-zip libapache2-mod-php7.2 php-xdebug
apt-get install -y php7.2-sqlite3
apt-get install -y php-mysql
apt-get -y install php-memcached
##

echo "\n[xdebug]" >> /etc/php/7.2/mods-available/xdebug.ini
echo "xdebug.default_enable=1" >> /etc/php/7.2/mods-available/xdebug.ini
echo "xdebug.remote_autostart=1" >> /etc/php/7.2/mods-available/xdebug.ini
echo "xdebug.remote_connect_back=1" >> /etc/php/7.2/mods-available/xdebug.ini
echo "xdebug.remote_enable=1" >> /etc/php/7.2/mods-available/xdebug.ini
echo "xdebug.remote_handler=dbgp" >> /etc/php/7.2/mods-available/xdebug.ini
echo "xdebug.remote_port='9000'" >> /etc/php/7.2/mods-available/xdebug.ini
echo "xdebug.remote_host='127.0.0.1'" >> /etc/php/7.2/mods-available/xdebug.ini
echo "xdebug.idekey='PHPSTORM'" >> /etc/php/7.2/mods-available/xdebug.ini
echo "xdebug.remote_mode='req'" >> /etc/php/7.2/mods-available/xdebug.ini
echo "xdebug.var_display_max_depth='-1'" >> /etc/php/7.2/mods-available/xdebug.ini
echo "xdebug.var_display_max_children='-1'" >> /etc/php/7.2/mods-available/xdebug.ini
echo "xdebug.var_display_max_data='-1'" >> /etc/php/7.2/mods-available/xdebug.ini

###############
#   Apache2   #
###############

echo "<VirtualHost *:80>
	DocumentRoot \"/var/www/expressive/public\"
	AllowEncodedSlashes On

	ServerName "expressive-static-pages.local.vm";
	ServerAlias "www.expressive-static-pages.local.vm";

	<Directory \"/var/www/expressive/public\">
		Options +Indexes +FollowSymLinks
		DirectoryIndex index.php index.html
		Order allow,deny
		Allow from all
		AllowOverride All
	</Directory>

	ErrorLog /var/www/logs/error-restable.log
	CustomLog /var/www/logs/access.log combined

</VirtualHost>" > /etc/apache2/sites-available/000-default.conf

a2enmod rewrite

# START APACHE2
service apache2 restart

rm -Rf /var/www/html
##

################
#   Composer   #
################

# Install Composer
if [ -e /usr/local/bin/composer ]; then
    /usr/local/bin/composer self-update
else
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
fi

# Install the Composer dependencies
cd /var/www/expressive && composer install
composer development-enable
##


#############
#   MYSQL   #
#############

# Install MySQL
#echo "Install MySQL"
debconf-set-selections <<< 'mysql-server mysql-server/root_password password root'
debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password root'
apt-get update
apt-get install -y mysql-server

mysql -u root -proot -e "CREATE DATABASE restable;"
mysql -u root -proot restable < /var/www/build/data/db/restable.sql

mysql -u root -proot -e "CREATE DATABASE credentials;"
mysql -u root -proot credentials < /var/www/build/data/db/credentials.sql

# Install Adminer.php
cd /var/www/build/bin
sh adminer.sh
##


##############
#   PHINX    #
##############

touch /var/www/expressive/data/db/db.sqlite
cd /var/www
php vendor/bin/phinx migrate
##

################
#   FRONTEND   #
################

## Install Node.js
#curl -sL https://deb.nodesource.com/setup_8.x -o nodesource_setup.sh
#sudo bash nodesource_setup.sh
#sudo rm nodesource_setup.sh

## Install YARN package Manager
#curl -sL https://dl.yarnpkg.com/debian/pubkey.gpg | sudo apt-key add -
#echo "deb https://dl.yarnpkg.com/debian/ stable main" | sudo tee /etc/apt/sources.list.d/yarn.list
#sudo apt-get update && sudo apt-get install -y yarn
## Gulp has to be installed with npm
#sudo npm install --global gulp-cli -D
##

#############
#   Other   #
#############

apt-get -y install memcached

# Reset home directory of vagrant user
if ! grep -q "cd /var/www" /home/vagrant/.profile; then
    echo "cd /var/www" >> /home/vagrant/.profile
fi

cd ~

##

echo "** Visit http://localhost:8089 or http://expressive-static-pages.local.vm in your browser for to view the application **"
SCRIPT

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|

    config.vm.box = 'bento/ubuntu-16.04'
    config.vm.box_version = "201803.24.0"

    config.vm.network "forwarded_port", guest: 80, host: 8089
    config.vm.network :public_network, ip: "192.168.0.201"
    config.vm.synced_folder '.', '/var/www', id:"application-root",owner:"vagrant",group:"www-data",mount_options:["dmode=775,fmode=664"]
    config.vm.provision 'shell', inline: @script
    config.vm.hostname = 'expressive-static-pages.local.vm'

    config.vm.provider "virtualbox" do |vb|
        vb.customize ["modifyvm", :id, "--memory", "512"]
        vb.customize ["modifyvm", :id, "--name", "Static Pages Application by Secalith - Ubuntu 16.04"]
    end

end