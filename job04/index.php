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
        $id = null,
        $name = null,
        $photos = null,
        $price = null,
        $description = null,
        $quantity = null,
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

// Paramètres de connexion à la base de données
$dsn = 'mysql:host=your_host;port=3307;dbname=draft-shop';  // Remplacez your_host par le nom de votre hôte MySQL et your_database_name par le nom de votre base de données
$username = 'pma';  // Remplacez your_username par votre nom d'utilisateur MySQL
$password = 'plomkiplomki';  // Remplacez your_password par votre mot de passe MySQL

// Essayer de se connecter à la base de données
try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur de connexion à la base de données : ' . $e->getMessage());
}

// Requête SQL pour récupérer le produit avec l'id 7
$query = "SELECT * FROM product WHERE id = 7";

// Exécution de la requête
try {
    $stmt = $pdo->query($query);
    $productData = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('Erreur lors de l\'exécution de la requête : ' . $e->getMessage());
}

// Vérifier si des données ont été récupérées
if ($productData) {
    // Créer une nouvelle instance de la classe Product
    $product = new Product();

    // Hydrater l'instance avec les données du tableau associatif
    $product->setId($productData['id']);
    $product->setName($productData['name']);
    $product->setPhotos(json_decode($productData['photos'], true));  // Décoder les photos depuis le format JSON
    $product->setPrice($productData['price']);
    $product->setDescription($productData['description']);
    $product->setQuantity($productData['quantity']);
    $product->setCreatedAt(new DateTime($productData['createdAt']));
    $product->setUpdatedAt(new DateTime($productData['updatedAt']));
    $product->setCategory_id($productData['category_id']);

    // Afficher les informations du produit
    echo "Product ID: " . $product->getId() . "<br>";
    echo "Product Name: " . $product->getName() . "<br>";
    echo "Product Photos: " . implode(', ', $product->getPhotos()) . "<br>";  // Convertir le tableau en chaîne
    echo "Product Price: " . $product->getPrice() . "<br>";
    echo "Product Description: " . $product->getDescription() . "<br>";
    echo "Product Quantity: " . $product->getQuantity() . "<br>";
    echo "Product Created At: " . $product->getCreatedAt()->format('Y-m-d H:i:s') . "<br>";
    echo "Product Updated At: " . $product->getUpdatedAt()->format('Y-m-d H:i:s') . "<br>";
    echo "Product Category ID: " . $product->getCategory_id() . "<br>";
} else {
    echo "Aucun produit trouvé avec l'ID 7.";
}

?>
