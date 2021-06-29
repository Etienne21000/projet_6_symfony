<?php


namespace App\Service;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidationService
{
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function unique_entity($param, $req, $class){
        $entity = $class;
        $errors = $this->validator->validate($entity);

//        foreach ($params as $param) {
            if($param == $req) {
                if (count($errors) > 0) {
                    $strError = (string)$errors;

                    return new Response($strError);
                }
            }
//        }
    }

    public function validate_email(){

    }

    public function validate_password(){

    }

}