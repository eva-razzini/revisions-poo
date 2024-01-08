<?php

class Category
{
    private $id;
    private $name;
    private $description;
    private $createdAt;
    private $updatedAt;

    public function __construct($id, $name, $description, $createdAt, $updatedAt)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    // Getters and setters for Category class
    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }
}

class Product
{
    private $id;
    private $name;
    private $photos;
    private $price;
    private $description;
    private $quantity;
    private $createdAt;
    private $updatedAt;
    private $category_id; 

    public function __construct(
        $id,
        $name,
        $photos,
        $price,
        $description,
        $quantity,
        $createdAt = null,
        $updatedAt = null,
        $category_id = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->photos = $photos;
        $this->price = $price;
        $this->description = $description;
        $this->quantity = $quantity;
        $this->createdAt = $createdAt ?? new DateTime();
        $this->updatedAt = $updatedAt ?? new DateTime();
        $this->category_id = $category_id;
    }

    // Getters and setters for Product class
    
    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function getPhotos()
    {
        return $this->photos;
    }
    public function setPhotos($photos)
    {
        $this->photos = $photos;
    }
    public function getPrice()
    {
        return $this->price;
    }
    public function setPrice($price)
    {
        $this->price = $price;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function setDescription($description)
    {
        $this->description = $description;
    }
    public function getQuantity()
    {
        return $this->quantity ;
    }
    public function setQuantity($quantity)
    {
        $this->quantity  = $quantity ;
    }
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }
    public function getCategory_id()
    {
        return $this->category_id;
    }

    public function setCategory_id($category_id)
    {
        $this->category_id = $category_id;
    }


}

// Exemple d'utilisation
$createdAtCategory = new DateTime('2022-01-01');
$updatedAtCategory = new DateTime('2022-01-02');

$category = new Category(1, 'Clothing', 'A category for clothing items', $createdAtCategory, $updatedAtCategory);

$createdAtProduct = new DateTime('2022-01-03');
$updatedAtProduct = new DateTime('2022-01-04');

$product = new Product(1, 'T-shirt', ['https://picsum.photos/200/300'], 1000, 'A beautiful T-shirt', 10, $createdAtProduct, $updatedAtProduct, $category->getId());

// Utilisation des getters pour récupérer les propriétés
var_dump($product->getId());
var_dump($product->getName());
var_dump($product->getPhotos());
var_dump($product->getPrice());
var_dump($product->getDescription());
var_dump($product->getQuantity());
var_dump($product->getCreatedAt()->format('Y-m-d H:i:s'));
var_dump($product->getUpdatedAt()->format('Y-m-d H:i:s'));
var_dump($product->getCategory_id());

// Utilisation des setters pour modifier les propriétés
$product->setName('New Product Name');
$product->setPrice(120);
$product->setQuantity(15);
$product->setCategory_id(2); 

var_dump($product->getName());
var_dump($product->getPrice());
var_dump($product->getQuantity());
var_dump($product->getCategory_id());

?>
