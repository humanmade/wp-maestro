WP Maestro
==========

Composer powered WordPress project generator.

WARNING: this is alpha software, here be dragons.

Getting started
---------------

- Add an entry to your `/etc/hosts` file for the sute
- Create a database
- ssh into your vagrant box

- Run the following command while ssh'd from the parent directory where you want to install WordPress.
`composer create-project -sdev humanmade/wp-maestro testinstall`

Where [testinstall] is the name of your project.

For other options, see the [Composer docs](https://getcomposer.org/doc/03-cli.md#create-project)

At the end of the process, you'll be asked:
> Do you want to remove the existing VCS (.git, .svn..) history? [Y,n]?

You should answer 'yes'

You could alias the whole command to something like `wp-maesto [project]`

Prerequisites
-------------

- PHP
- mySQL
- [WP CLI](http://wp-cli.org)
- [Composer](http://getcomposer.org)
