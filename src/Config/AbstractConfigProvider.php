<?php

namespace Flock\Config;


use Flock\FlockConfigException;
use Flock\FlockException;

abstract class AbstractConfigProvider {

    protected $config = [];

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

    protected function isNameSet($name) {
        if (isset($this->config[$name])) {
            return true;
        } else {
            return false;
        }
    }

}