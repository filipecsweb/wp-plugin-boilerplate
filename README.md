# WordPress Plugin Boilerplate by Filipe Seabra

Just another WordPress plugin boilerplate.

## Requirements

* PHP 7+;
* npm;
* [WP-CLI](https://wp-cli.org/).

## Features

* Very easy setup;
* Gulp for task automatization;
* PHP Namespace usage;
* Clean code;
* [Coding standards](http://codex.wordpress.org/WordPress_Coding_Standards).

## Usage/setup

* Download or clone this repository inside your WordPress plugin folder.
* `cd` into this plugin folder and set up your own names by using the following command.
Replace `awesome-plugin`, `awesome_plugin`, `Awesome_Plugin` and `AwesomePlugin` below with the names you want.
```
wp eval-file provision.php --skip-wordpress \
new-filename-prefix=awesome-plugin \
new-function-prefix=awesome_plugin \
new-class-prefix=Awesome_Plugin \
new-namespace-prefix=AwesomePlugin
```
* If you executed the command above but has a change of mind, then you can make it right by using:
```
wp eval-file provision.php --skip-wordpress \
new-filename-prefix=other-plugin-name old-filename-prefix=awesome-plugin \
new-function-prefix=other_plugin_name old-function-prefix=awesome_plugin \
new-class-prefix=Other_Plugin_Name old-class-prefix=Awesome_Plugin \
new-namespace-prefix=OtherPluginName old-namespace-prefix=AwesomePlugin
```

## Contributing

Just create an issue followed by your Pull Request.

I appreciate you taking the initiative to contribute to this project.    