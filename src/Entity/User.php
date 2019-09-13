<?php
declare(strict_types=1);

namespace App\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column(type="integer")
     */
    private $money = 0;

    public function __construct()
    {
        parent::__construct();
    }

    public function setMoney(int $money): self
    {
        $this->money = $money;
        return $this;
    }


    public function getMoney(): ?int
    {
        return $this->money;
    }

    public function __toString()
    {
        return parent::__toString();
    }
}