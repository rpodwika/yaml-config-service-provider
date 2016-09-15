YamlConfigServiceProvider for Silex ~2.0
========================================

# Usage

```
<?php

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

$app->register(new Rpodwika\Silex\YamlConfigServiceProvider(PATH_TO_CONFIG_FILE));

echo $app['config']['database']['driver'];
...
```

where `PATH_TO_CONFIG_FILE` is location of YML file with configuration for example `__DIR__ . "/../app/config/parameters.yml"`

considering following directory structure:

- app
    - config
        - parameters.yml
- web
    - index.php 
    
parameters.yml
```
    database:
          driver :  'pdo_mysql'
          dbhost :  'localhost'
          dbname :  'mydbname'
          user :    'root'
          password : ''
```
          
          

# Installation

Add to composer.json 

```
"require": {
    "rpodwika/yaml-config-service-provider": "dev-master"
}
```

or run command `composer require rpodwika/yaml-config-service-provider`


This bundle is inspired on deralex/YamlConfigServiceProvider


# Licence

[GPL 3.0](https://www.gnu.org/licenses/gpl-3.0.html)


