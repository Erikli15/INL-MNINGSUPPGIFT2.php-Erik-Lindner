<?php
class Product
{
    public $id;
    public $productName;
    public $category;
    public $price;

    function __construct($id, $productName, $category, $price)
    {
        $this->id = $id;
        $this->productName = $productName;
        $this->category = $category;
        $this->price = $price;
    }
}

