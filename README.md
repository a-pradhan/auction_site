README
================

Introduction
==================
An auction site that allows users to bid on items and sell their items in auctions.

Setup 
=============
1. Ensure you have git installed
2. Setup an SSH key-pair by following the instructions here: https://help.github.com/articles/generating-a-new-ssh-key/. Press the 'Enter' key when prompted to set the default location for the keys. You do not have to enter a password when prompted and can simply press the 'Enter' key
3. Ensure you have installed VirtualBox (https://www.virtualbox.org/wiki/Downloads)
4. Ensure you have installed Vagrant (https://www.vagrantup.com/downloads.html)
5. Clone the repository if you have not done so already and **checkout the develop branch**
6. In terminal cd into the root of the project folder and enter the command `vagrant up`. This will download the trusty/tahr 64-bit virtual machine image and proceed to setup the required components for the LAMP stack
7. Delete the "index.php" file in the project root. This is created by default when apache is installed on the vm
8. **Optional** - enter the command `vagrant ssh` to enter the virtual machine. Vim can be used to edit configuration files if desired
9. Vagrant is configured to serve files to apache from within the 'src' folder. All website files and folders should be created within
10. To view the website visit "localhost:4567" in your browser
11. To shutdown the vm enter the command `vagrant halt`
12. Enter the command `exit` while inside the VM to return to your machine's terminal.