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
use Exception;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ApiException
 * @package App\Exception
 */
class BadRequest extends ApiException
{
    const ERROR_CODE = Response::HTTP_BAD_REQUEST;
    const ERROR_MESSAGE = 'The submitted data was invalid';
    private $errors;

    /**
     * InvalidFormException constructor.
     * @param $errors
     */
    public function __construct($errors = [])
    {
        parent::__construct(self::ERROR_MESSAGE, self::ERROR_CODE);
        $this->errors = $errors;
    }

    /**
     * @return array
     */
    public function getErrorDetails()
    {
        return [
            'code' => self::ERROR_CODE,
            'message' => self::ERROR_MESSAGE,
            'errors' => $this->errors
        ];
    }
}