<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mail
 *
 * @ORM\Table(name="mail")
 * @ORM\Entity
 */
class Mail
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="sender", type="string", length=255, nullable=false)
     */
    private $sender;

    /**
     * @var string
     *
     * @ORM\Column(name="dest", type="string", length=255, nullable=false)
     */
    private $dest;

    /**
     * @var string
     *
     * @ORM\Column(name="object", type="string", length=255, nullable=false)
     */
    private $object;

    /**
     * @var string|null
     *
     * @ORM\Column(name="body", type="text", length=0, nullable=true)
     */
    private $body;


}
