<?php

namespace Swoft\Validator;

use Swoft\Bean\Annotation\Bean;
use Swoft\Helper\ValidatorHelper;

/**
 * String validator
 * @Bean()
 */
class CreditCardValidator implements ValidatorInterface
{
    /**
     * @param array ...$params
     *
     * @return mixed
     * @throws \Swoft\Exception\ValidatorException
     */
    public function validate(...$params)
    {
        list($name, $value, $throws, $template) = $params;

        return ValidatorHelper::validateCreditCard($name, $value, $throws, $template);
    }
}
