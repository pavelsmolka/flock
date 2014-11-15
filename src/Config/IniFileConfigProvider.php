<?php

namespace Flock\Config;

use Flock\FlockConfigException;
use Flock\FlockException;

class IniFileConfigProvider extends AbstractConfigProvider {

    /** @var string */
    protected $configPath;
    protected $config;

    public function __construct($configPath) {
        $this->configPath = $configPath;

        if (!is_file($this->configPath) || !is_readable($this->configPath)) {
            throw new FlockConfigException("Config file $this->configPath does not exist or it cannot be read.");
        }
        $settings = parse_ini_file($this->configPath);

        if (!is_array($settings)) {
            throw new FlockConfigException("File $this->configPath apparently contains some bullshit, not INI values.");
        }

        $this->config = $settings;
    }


}
