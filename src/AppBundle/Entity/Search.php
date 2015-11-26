<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;


class Search
{
    /**
     * @Assert\Choice(
     * choices = { "nama", "description" },
     * message = "-- Choose --."
     * )
     */
    public $fieldOptions;

    public $keyWord;
}
