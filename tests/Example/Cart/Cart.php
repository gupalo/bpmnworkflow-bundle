<?php

namespace Gupalo\BpmmWorkflowBundle\Tests\Example\Cart;

class Cart
{
    public function __construct(
        private array $items,
        private string $locale,
        private float $price
    ) {
    }
    
    public function getItems(): array
    {
        return $this->items;
    }
    
    public function getLocale(): string
    {
        return $this->locale;
    }
    
    public function getPrice(): float
    {
        return $this->price;
    }

    public function setItems(array $items): void
    {
        $this->items = $items;
    }

    public function setLocale(string $locale): void
    {
        $this->locale = $locale;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }
}
