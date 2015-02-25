<?php

namespace Bucyou;

use Symfony\Component\Serializer\Annotation\Groups;

class Product
{
    /**
     * @Groups({"admins"})
     */
    public $itemSold;

    /**
     * @Groups({"admins", "affiliates"})
     */
    public $commission;

    /**
     * @Groups({"admins", "affiliates", "users"})
     */
    public $price;
}

