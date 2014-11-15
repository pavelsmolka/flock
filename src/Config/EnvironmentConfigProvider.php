<?php

namespace Flock\Config;

use Flock\FlockConfigException;

class EnvironmentConfigProvider extends AbstractConfigProvider {

    public function __construct() {

        $configDictionary = [
            'consumer_key' => 'TW_CONSUMER_KEY',
            'consumer_secret' => 'TW_CONSUMER_SECRET',
            'ot_ProgramovaniCZ' => 'OAUTH_TOKEN',
            'ots_ProgramovaniCZ' => 'OAUTH_SECRET',
        ];

        foreach($configDictionary as $configKey => $envVariable) {

            if (isset($_ENV[$envVariable])) {
                $this->config[$configKey] = $_ENV[$envVariable];
                continue;
            }

            if (isset($_SERVER[$envVariable])) {
                $this->config[$configKey] = $_SERVER[$envVariable];
                continue;
            }

            throw new FlockConfigException("Environment variable $envVariable has not been set.");

        }

    }

}