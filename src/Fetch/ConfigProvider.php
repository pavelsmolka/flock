<?php

namespace Flock\Fetch;

use FlockConfigException;

class ConfigProvider {

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
        return $this->config;
    }

    public function getConfigField($name) {
        if (isset($this->config["name"])) {
            return $this->config["name"];
        } else {
            throw new FlockConfigException("There is not any record for name '" . $name . "' in the config file");
        }
    }

    public function getAuthPair($name) {
        if ($this->isNameSet("ot_" . $name) &&
                $this->isNameSet("ots_" . $name)) {
            return [
                "oauth_access_token" => $this->config["ot_" . $name],
                "oauth_access_token_secret" => $this->config["ots_" . $name]
            ];
        } else {
            throw new FlockConfigException("Pair with name '" . $name . "' is not in the config file");
        }
    }

    public function getConsumerSecretPair() {
        if($this->isNameSet("consumer_key") && $this->isNameSet("consumer_secret")) {
            return [
                "consumer_key" => $this->config["consumer_key"],
                "consumer_secret" => $this->config["consumer_secret"]
            ];
        } else {
            throw new FlockConfigException("There is not any customer secret pair in the config file");
        }
    }
    
    private function isNameSet($name) {
        if (isset($this->config[$name])) {
            return true;
        } else {
            return false;
        }
    }

}
