<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 */
class Order
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Product", inversedBy="orders")
     */
    private $products;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $productQuantities;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $productProgress;

    /**
     * @ORM\Column(type="time")
     */
    private $deliverytime;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
        }

        return $this;
    }

    public function getProductQuantities(): ?string
    {
        return $this->productQuantities;
    }

    public function setProductQuantities(string $productQuantities): self
    {
        $this->productQuantities = $productQuantities;

        return $this;
    }

    public function getProductProgress(): ?string
    {
        return $this->productProgress;
    }

    public function setProductProgress(string $productProgress): self
    {
        $this->productProgress = $productProgress;

        return $this;
    }

    public function getDeliverytime(): ?\DateTimeInterface
    {
        return $this->deliverytime;
    }

    public function setDeliverytime(\DateTimeInterface $deliverytime): self
    {
        $this->deliverytime = $deliverytime;

        return $this;
    }
}
