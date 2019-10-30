<?php
/**
 * Created by PhpStorm.
 * User: joe
 * Date: 29/08/2015
 * Time: 06:24 PM
 */

namespace Desymfony\DesymfonyBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;


/**
 * @Annotation
 */
class DNI extends Constraint{
    public $message = 'El dni debe contener exactamente 11 dígitos';
} 