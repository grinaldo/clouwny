<?php

namespace App\Validator;

use Illuminate\Validation\Validator;

class PasswordValidator extends Validator
{

    const MIN_CHARACTER = 8;

    /**
     * Validate that an attribute contains at least MIN_CHARACTER characters.
     *
     * @param  string  $attribute
     * @param  mixed   $value
     * @return bool
     */
    public function validateBasicPassword($attribute, $value)
    {
        if (!is_string($value)) {
            return false;
        }
        return strlen($value) >= self::MIN_CHARACTER;
    }

    /**
     * Replace all place-holders for the basic password rule.
     *
     * @param  string  $message
     * @param  string  $attribute
     * @param  string  $rule
     * @param  array   $parameters
     * @return string
     */
    public function replaceBasicPassword($message, $attribute, $rule, $parameters)
    {
        return str_replace(':min', self::MIN_CHARACTER, $message);
    }


    /**
     * Validate that an attribute is current login attribute
     *
     * @param  string  $attribute
     * @param  mixed   $value
     * @return bool
     */
    public function validateCurrentPassword($attribute, $value, $parameters)
    {
        $this->requireParameterCount(1, $parameters, 'current_password');
        $auth = "\\".$parameters[0];

        return \Hash::check($value, $auth::user()->getAuthPassword());
    }


    /**
     * Require a certain number of parameters to be present.
     *
     * @param  int    $count
     * @param  array  $parameters
     * @param  string  $rule
     * @return void
     * @throws \InvalidArgumentException
     */
    protected function requireParameterCount($count, $parameters, $rule)
    {
        if (count($parameters) < $count) {
            throw new \InvalidArgumentException("Validation rule $rule requires at least $count parameters.");
        }
    }
}
