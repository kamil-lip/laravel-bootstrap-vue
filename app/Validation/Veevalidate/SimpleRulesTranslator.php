<?php

namespace App\Validation\Veevalidate;

class SimpleRulesTranslator implements RulesTranslatorInterface
{
    /**
     * @var array rules which are not needed on the client side
     */
    protected $rulesToFilter = ['unique'];

    /**
     * Translate routes to VeeValidate format. It ignores some rules if they are impossible to use on the frontend side.
     *
     * @param array $rules
     * @return Array translated rules
     */
    public function translate(Array $rules): Array
    {
        $patterns = array_map(function ($rule) { return '/\|?' . $rule . '[^\|]*/'; }, $this->rulesToFilter);

        foreach ($rules as &$fieldRules) {
            $fieldRules = trim(preg_replace($patterns, '', $fieldRules), '|');
        }
        unset($fieldRules);

        return $rules;
    }

}