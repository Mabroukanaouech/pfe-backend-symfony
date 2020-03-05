<?php
/**
 * Copyright (C) KOCHTI, Inc - All Rights Reserved
 *
 * This file is part of the pointcash_api
 * Created by  KOCHTI AYMEN
 * @author <kochti.aymen.ing@gmail.com>
 * 2/21/20
 * 10:08 AM
 *
 * For the full copyright and license information, please view the LICENSE
 */


namespace App\Exception;

use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class InvalidFormException
 * @package App\Exception
 */
class InvalidFormException extends ApiException
{
    const ERROR_CODE = Response::HTTP_BAD_REQUEST;
    const ERROR_MESSAGE = 'The submitted data was invalid';

    /**
     * @var FormInterface
     */
    protected $form;

    /**
     * InvalidFormException constructor.
     * @param FormInterface $form
     */
    public function __construct(FormInterface $form)
    {
        parent::__construct(self::ERROR_MESSAGE, self::ERROR_CODE);
        $this->form = $form;
    }

    /**
     * @return array
     */
    public function getErrorDetails()
    {
        return [
            'code' => self::ERROR_CODE,
            'message' => self::ERROR_MESSAGE,
            'errors' => $this->getFormErrors($this->form),
        ];
    }

    /**
     * List all errors of a given bound form.
     *
     * @param FormInterface $form
     * @return array
     */
    private function getFormErrors(FormInterface $form)
    {
        $errors = [];
        /** @var FormError $error */
        foreach ($form->getErrors() as $error) {
            $template = $error->getMessageTemplate();
            $parameters = $error->getMessageParameters();

            foreach ($parameters as $var => $value) {
                $template = str_replace($var, $value, $template);
            }

            $errors[] = $template;
        }
        foreach ($form->all() as $childForm) {
            if (!$childForm->isSubmitted() || ($childForm->isSubmitted() && !$childForm->isValid())) {
                $errors[$childForm->getName()] = $this->getFormErrors($childForm);
            }
        }

        return $errors;
    }
}
