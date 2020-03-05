<?php
/**
 * Copyright (C) KOCHTI, Inc - All Rights Reserved
 *
 * This file is part of the pointcash_api
 * Created by  KOCHTI AYMEN
 * @author <kochti.aymen.ing@gmail.com>
 * 2/21/20
 * 10:07 AM
 *
 * For the full copyright and license information, please view the LICENSE
 */

namespace App\Exception;

use Exception;
/**
 * Class ApiException
 * @package App\Exception
 */
class ApiException extends Exception
{
    /**
     * @return array
     */
    public function getErrorDetails()
    {
        return [
            'code' => $this->getCode() ? $this->getCode() : 500,
            'message' => $this->getMessage() ?: 'Unhandled api exception',
        ];
    }
}