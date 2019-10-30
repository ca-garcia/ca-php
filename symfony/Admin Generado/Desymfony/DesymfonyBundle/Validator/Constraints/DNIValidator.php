<?php
/**
 * Created by PhpStorm.
 * User: joe
 * Date: 29/08/2015
 * Time: 06:28 PM
 */

namespace Desymfony\DesymfonyBundle\Validator\Constraints;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class DNIValidator extends ConstraintValidator {

    /**
     * Checks if the passed value is valid.
     *
     * @param mixed $value The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     *
     * @api
     */
    public function validate($value, Constraint $constraint)
    {

        if ( strlen($value) != 11)
        {
            $this->context->addViolation('El DNI introducido no tiene 11 dígitos', array());
        }
        if (! preg_match("/^[0-9]{11}$/", $value))
        {
            $this->context->addViolation('El DNI introducido tiene caracteres que no son dígitos', array());
        }
    }
}