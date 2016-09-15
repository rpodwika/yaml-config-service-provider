<?php

namespace Rpodwika\Silex;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Application;
use Symfony\Component\Yaml\Yaml;

/**
 * Class YamlConfigServiceProvider
 * @package Rpodwika\Silex\Silex
 */
final class YamlConfigServiceProvider implements ServiceProviderInterface
{
    private $file;

    /**
     * YamlServiceProvider constructor.
     *
     * @param $file
     */
    public function __construct($file)
    {
        $this->file = $file;
    }

    /**
     * @inheritDoc
     */
    public function register(Container $app)
    {
        if (!(file_exists($this->file) && is_readable($this->file))) {
            throw new \Exception("$this->file is cannot be read");
        }
        $config = Yaml::parse(file_get_contents($this->file));
        $this->importSearch($config, $app);

        if (isset($app['config']) && is_array($app['config'])) {
            $app['config'] = array_replace_recursive($app['config'], $config);
        } else {
            $app['config'] = $config;
        }
    }

    /**
     * Looks for import directives in YAML file and recursively invokes YamlConfigServiceProvider on them
     *
     * @param array $config
     * @param Container $app
     */
    private function importSearch(array &$config, Container $app)
    {
        foreach ($config as $key => $value) {
            if ($key == 'imports') {
                foreach ($value as $resource) {
                    $base_dir = str_replace(basename($this->file), '', $this->file);
                    $newConfig = new YamlConfigServiceProvider($base_dir . $resource['resource']);
                    $newConfig->register($app);
                }
                unset($config['imports']);
            }
        }
    }

}
