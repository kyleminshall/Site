#!/bin/sh
echo This script will configure your machine for working with heroku

echo Installing gcc
sudo yum -y install gcc

echo Installing make
sudo yum -y install make

echo Installing cmake
sudo yum -y install cmake

echo Installing tar
sudo yum -y install tar

echo Installing ruby
sudo yum -y install ruby

echo Installing rubygems
sudo yum -y install rubygems

echo Installing rb-readline
gem install rb-readline

echo Downloading Heroku toolbelt
wget -c https://toolbelt.herokuapp.com/install.sh

echo Installing Heroku toolbelt
sudo sh install.sh

echo Adding to path
echo 'PATH="/usr/local/heroku/bin:$PATH"' >> ~/.profile

echo Reloading bash
source ~/.bashrc

echo Fixing symlink
sudo ln -s /usr/local/heroku/bin/heroku /usr/bin/heroku

echo Reloading bash
source ~/.bashrc

echo "\033[0;32m Script has completed successfully"

