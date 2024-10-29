<?php

namespace App\Entity;

use App\Repository\CouponsTypesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CouponsTypesRepository::class)]
#[ORM\Table(name:"coupons_types")]
class CouponsTypes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    /**
     * @var Collection<int, PromoCoupons>
     */
    #[ORM\OneToMany(targetEntity: PromoCoupons::class, mappedBy: 'coupons_relation', orphanRemoval: true)]
    private Collection $promoCoupons;

    public function __construct()
    {
        $this->promoCoupons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, PromoCoupons>
     */
    public function getPromoCoupons(): Collection
    {
        return $this->promoCoupons;
    }

    public function addPromoCoupon(PromoCoupons $promoCoupon): static
    {
        if (!$this->promoCoupons->contains($promoCoupon)) {
            $this->promoCoupons->add($promoCoupon);
            $promoCoupon->setCouponsRelation($this);
        }

        return $this;
    }

    public function removePromoCoupon(PromoCoupons $promoCoupon): static
    {
        if ($this->promoCoupons->removeElement($promoCoupon)) {
            // set the owning side to null (unless already changed)
            if ($promoCoupon->getCouponsRelation() === $this) {
                $promoCoupon->setCouponsRelation(null);
            }
        }

        return $this;
    }
}
