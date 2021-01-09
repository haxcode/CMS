<?php

namespace App\Common\Service;

use App\Common\Exception\Services\ServiceParameterRequiredException;
use App\Common\Exception\Services\ServiceTypeParameterException;

trait TServiceParameterValidator {

    static string $SERVICE_NAME = 'SERVICE';

    /**
     * @param array $data
     * @param array $parameters   [ 'key1' => 'required',
     *                            'key2' => 'required|string',
     *                            'key3' => 'required|string|min:1|max:20',
     *                            'key4'  => 'required|int
     *                            ]
     * @param array $aliases
     */
    public function validate(array $data, array $parameters, array $aliases = []): void {
        foreach ($parameters as $parameter => $validation) {
            if (isset($data[$parameter])) {
                $alias = isset($aliases[$parameter]) ? $aliases[$parameter] : $parameter;
                $value = isset($data[$parameter]) ? $data[$parameter] : NULL;
                $this->validateRules($value, $validation, $alias);
            }
        }
    }

    /**
     * @param mixed  $data  data validated
     * @param string $rule  rule expresion to validate data
     * @param string $alias alias for field validated (friendly name for user)
     */
    private function validateRules($data, string $rule, string $alias): void {
        $rules = explode('|', $rule);
        if (in_array('required', $rules) && ($data == null)) {
            throw new ServiceParameterRequiredException(self::$SERVICE_NAME, $alias);
        }
        if (in_array('text', $rules) && (!is_string($data) || empty($data))) {
            throw new ServiceTypeParameterException(self::$SERVICE_NAME, $alias, 'text');
        }
        if (in_array('int', $rules) && (!filter_var($data, FILTER_VALIDATE_INT))) {
            throw new ServiceTypeParameterException(self::$SERVICE_NAME, $alias, 'integer');
        }
        if (in_array('email', $rules) && (!filter_var($data, FILTER_VALIDATE_EMAIL))) {
            throw new ServiceTypeParameterException(self::$SERVICE_NAME, $alias, 'email');
        }
    }

}