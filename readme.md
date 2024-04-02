
# config-manager
Add Or Edit And Delete key/value  pairs in a configuration file.
And Save changes to the configuration file in script.

## Installing

Install using Composer `composer require nasermekky/config-manager`.

## Using GUI 

You can use link 'http://your-site.com/configs'

## Using the repository

You can also use the repository `Nasermekky\ConfigManager\Core\Repo` which works a little like a model.

Example:
```
$config = new Nasermekky\ConfigManager\Core\Repo('app'); // loading the config from config/app.php

$config->edit('debug', false); // set the config you wish

if ($config->get('url') == 'http://localhost') // you can even get config from this
{
    $config->add('key', 'value'); // add key to config file
	$config->edit('debug', true); // add key to config fil
    $config->delete('key', 'value'); // delete key from  config file
    // all will return true or Exception 
}

// save those settings to the config file once done editing
```

If you do this a lot I recommend adding the alias `'ConfigManager' => Nasermekky\ConfigManager\Core\Repo::class` under the `alias`-section in the config file `config/app.php`.

