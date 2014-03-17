<?php
namespace Flock\Publish;


class StaticAccountListProvider {
    
    private static $accounts;
    
    public static function provideAccounts() {
        if(self::$accounts == null) {
            self::$accounts = [
                "programovanicz" => "programovaniCZ",
                "vareni" => "vareni",
            ];
        }
        return self::$accounts;
    }
}