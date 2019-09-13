<?php
declare(strict_types=1);

namespace App\Entity;

use App\Entity\Traits\IdentityTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CheckRepository")
 * @ORM\Table(name="order_check")
 */
class Check
{
    use IdentityTrait;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Order")
     */
    private $cart;

    /**
     * @ORM\Column(type="boolean")
     */
    private $payed;

    /**
     * @ORM\Column(type="integer")
     */
    private $money;

    public function getCart(): ?Order
    {
        return $this->cart;
    }

    public function setCart(Order $cart): self
    {
        $this->cart = $cart;

        return $this;
    }

    public function getPayed(): ?bool
    {
        return $this->payed;
    }

    public function setPayed(bool $payed): self
    {
        $this->payed = $payed;

        return $this;
    }

    public function getMoney(): ?int
    {
        return $this->money;
    }

    public function setMoney(int $money): self
    {
        $this->money = $money;

        return $this;
    }
}
