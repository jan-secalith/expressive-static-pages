# -*- mode: ruby -*-
# vi: set ft=ruby :

VAGRANTFILE_API_VERSION = '2'

@script = <<SCRIPT

# Install dependencies

export APP_ENV=development

sudo add-apt-repository ppa:ondrej/php
sudo apt-get update

sudo apt-get install -y apache2
sudo apt-get install -y git
sudo apt-get install -y curl

apt-get install -y php7.2
apt-get install -y php7.2-bcmath php7.2-bz2 php7.2-cli php7.2-curl php7.2-intl php7.2-json php7.2-mbstring
apt-get install -y php7.2-xml php7.2-xsl php7.2-zip libapache2-mod-php7.2 php-xdebug

# Configure Apache
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

# Install Composer
if [ -e /usr/local/bin/composer ]; then
    /usr/local/bin/composer self-update
else
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
fi

# Install the Composer dependencies
cd /var/www/expressive && composer install
composer development-enable

cd ~

# Reset home directory of vagrant user
if ! grep -q "cd /var/www" /home/vagrant/.profile; then
    echo "cd /var/www" >> /home/vagrant/.profile
fi


echo "** Visit http://localhost:8089 in your browser for to view the application **"
SCRIPT

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|

    config.vm.box = 'bento/ubuntu-16.04'
    config.vm.box_version = "201803.24.0"

    config.vm.network "forwarded_port", guest: 80, host: 8089
    config.vm.synced_folder '.', '/var/www'
    config.vm.provision 'shell', inline: @script
    config.vm.hostname = 'expressive-static-pages.local.vm'

    config.vm.provider "virtualbox" do |vb|
        vb.customize ["modifyvm", :id, "--memory", "512"]
        vb.customize ["modifyvm", :id, "--name", "Static Pages Application by Secalith - Ubuntu 16.04"]
    end

end
