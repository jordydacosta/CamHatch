# Laravel PHP Framework

[![Build Status](https://travis-ci.org/laravel/framework.svg)](https://travis-ci.org/laravel/framework)
[![Total Downloads](https://poser.pugx.org/laravel/framework/d/total.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/framework/v/stable.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/framework/v/unstable.svg)](https://packagist.org/packages/laravel/framework)
[![License](https://poser.pugx.org/laravel/framework/license.svg)](https://packagist.org/packages/laravel/framework)

## SSH
Registering an SSH key on Windows
1. Check for existing SSH keys
You should check for existing SSH keys on your local computer. You can use an
existing SSH key with the coders academy server if you want.
Open a command prompt, and run:
cd %userprofile%/.ssh

If If you see "No such file or directory", then there aren't any existing keys:  go to step 3.
Check to see if you have a key already:

dir id_*
If there are existing keys, you may want to use those.
2. Back up old SSH keys
If you have existing SSH keys, but you don't want to use them when connecting
to the coders academy server, you should back those up.
In a command prompt on your local computer, run:
mkdir key_backup
copy id_rsa* key_backup
3. Generate a new SSH key
If you don't have an existing SSH key that you wish to use, generate one as follows:

Log in to your local computer as an administrator.
In a command prompt, run:

ssh-keygen -t rsa

Just press  to accept the default location and file name.
If the .ssh directory doesn't exist, the system creates one for you.
Enter, and re-enter, a passphrase when prompted.
You are done!

You can now go ahead and clone the project.

## Setup
+ In your Git Bash: `git clone git@git.codersacademy.nl:camhatch/camhatchv3.git -b develop`
+ In your prompt write `cd camhatchv3`
+ Create an environment file: `copy .env-example .env` or `cp .env-example .env`
+ Open the .env file and edit it to your data
+ Go to mySQL and make a database called database_cam


## Configuration
+ Open Git Bash (or prompt) in your project directory(`cd camhatchv3`) and exectute the following commands in order:
+ `composer install` (this may take some time)
+ `php artisan key:generate`
+ `php artisan migrate`
+ `php artisan db:seed`
+ `php artisan serve`

## ready for work
+ Go to the browser of your choice and go to `http://localhost:8000/`
+ To go to the admin side go to `localhost:8000/admin`
+ The standard Username is `willem@camhatch.com` and the standard password is `camhatch`

