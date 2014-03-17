<?php

namespace Flock\Assessment;

use Flock\Publish\StaticAccountListProvider;

abstract class Assessment implements IAssessment {
    
    const PROGRAMOVANI_CZ = 'programovaniCZ';
    const VARENI = 'vareni';

    protected $users = [
        'honzajavorek' => [self::PROGRAMOVANI_CZ],
        'geekovo' => [self::PROGRAMOVANI_CZ],
        'ostoweb' => [self::PROGRAMOVANI_CZ],
        'marek_jelen' => [self::PROGRAMOVANI_CZ],
        'VolmutJ' => [self::PROGRAMOVANI_CZ],
        'pavelsmolka' => [self::PROGRAMOVANI_CZ],
        'cuketka' => [self::VARENI],
    ];
    
    
}
