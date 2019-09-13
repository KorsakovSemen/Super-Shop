<?php
declare(strict_types=1);

namespace App\Entity;

use App\Entity\Traits\IdentityTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 * @ORM\Table(name="cart")
 */
class Order
{
    use IdentityTrait;

    public const STATUS_FINISHED = 'Y';
    public const STATUS_PENDING = 'N';

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id",referencedColumnName="id")
     */
    private $user;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OrderList", mappedBy="cart",cascade={"all"})
     */
    private $rows;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;


    public function __construct()
    {
        $this->rows = new ArrayCollection();
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getStatus(): ?String
    {
        return $this->status;
    }

    public function setStatus(String $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection|OrderList[]
     */

    public function getRows(): Collection
    {
        return $this->rows;
    }

    public function addRows(OrderList $orderList): self
    {
        if (!$this->rows->contains($orderList)) {
            $orderList->setCart($this);
            $this->rows[] = $orderList;
        }

        return $this;
    }

    public function removeRows(OrderList $orderList): self
    {
        if ($this->rows->contains($orderList)) {
            $this->rows->removeElement($orderList);
        }
        return $this;
    }


    public function __toString()
    {
        return (string)$this->getId();

    }

}
