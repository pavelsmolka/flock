<?php

namespace Flock\Fetch;

use FlockException;

class ConfigProvider {

    /** @var string */
    protected $configPath;

    public function __construct($configPath) {
        $this->configPath = $configPath;
    }

    /**
     * Settings has to be an associative array, config should look like this:
     * oauth_access_token = ...
     * oauth_access_token_secret = ...
     * consumer_key = ...
     * consumer_secret = ...
     *
     * @return array
     * @throws FlockException
     */
    public function getConfig() {

        if (!is_file($this->configPath) || !is_readable($this->configPath)) {
            throw new FlockException("Config file $this->configPath does not exist or it cannot be read.");
        }
        $settings = parse_ini_file($this->configPath);

        if (!is_array($settings)) {
            throw new FlockException("File $this->configPath apparently contains some bullshit, not INI values.");
        }

        return $settings;
    }
} 