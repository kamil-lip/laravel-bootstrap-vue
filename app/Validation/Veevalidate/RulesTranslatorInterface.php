<?php

namespace App\Validation\Veevalidate;

/**
 * Interface RulesTranslatorInterface
 * @package App\Validation\Veevalidate
 */
interface RulesTranslatorInterface
{
    /**
     * Translate routes to VeeValidate format. It ignores some rules if they are impossible to use on the frontend side.
     *
     * @param array $rules
     * @return Array translated rules
     */
    public function translate(Array $rules) : Array;

}