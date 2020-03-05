<?php
/**
 * Copyright (C) KOCHTI, Inc - All Rights Reserved
 *
 * This file is part of the point_cash_api
 * Created by  KOCHTI AYMEN
 * @author <kochti.aymen.ing@gmail.com>
 * 2/25/20
 * 3:43 PM
 *
 * For the full copyright and license information, please view the LICENSE
 */


namespace App\Doctrine\Entity;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class User
 * @package App\Doctrine\Entity
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
}