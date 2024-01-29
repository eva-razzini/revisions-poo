<?php


class Category
{
    // Propriétés de la classe Category
    private $id;
    private $name;
    private $description;
    private $createdAt;
    private $updatedAt;
    private $pdo;

    // Constructeur de la classe Category
    public function __construct($id, $name, $description, $createdAt, $updatedAt, $pdo)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->pdo = $pdo;
    }

    // Getters pour accéder aux propriétés de la classe Category
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

    // Méthode pour récupérer les produits associés à la catégorie
    public function getProducts()
    {
        // Requête SQL pour récupérer les produits de la catégorie
        $query = "SELECT * FROM product WHERE category_id = :category_id";

        try {
            // Préparer la requête
            $stmt = $this->pdo->prepare($query);

            // Liaison des paramètres
            $stmt->bindParam(':category_id', $this->id, PDO::PARAM_INT);

            // Exécution de la requête
            $stmt->execute();

            // Récupération des données des produits de la catégorie
            $productsData = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Tableau pour stocker les instances de la classe Product
            $products = [];

            // Vérifier si des données ont été récupérées
            if ($productsData) {
                foreach ($productsData as $productData) {
                    // Créer une instance de la classe Product
                    $product = new Product(
                        $productData['id'],
                        $productData['name'],
                        json_decode($productData['photos'], true),
                        $productData['price'],
                        $productData['description'],
                        $productData['quantity'],
                        new DateTime($productData['createdAt']),
                        new DateTime($productData['updatedAt']),
                        $productData['category_id'],
                        $this->pdo
                    );

                    // Ajouter l'instance au tableau
                    $products[] = $product;
                }
            }

            return $products;
        } catch (PDOException $e) {
            die('Erreur lors de la récupération des produits de la catégorie : ' . $e->getMessage());
        }
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
    private $pdo;

    public function __construct(
        $id = null,
        $name = null,
        $photos = null,
        $price = null,
        $description = null,
        $quantity = null,
        $createdAt = null,
        $updatedAt = null,
        $category_id = null,
        $pdo = null
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
        $this->pdo = $pdo;
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
        // Si $photos est une chaîne JSON, décodez-la en tableau
        if (is_string($photos)) {
            $this->photos = json_decode($photos, true);
        } else {
            $this->photos = $photos;
        }
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
        return $this->quantity;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
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

    public static function findOneById($id, $pdo)
    {
        // Requête SQL pour récupérer un produit par ID
        $query = "SELECT * FROM product WHERE id = :id";

        try {
            // Préparer la requête
            $stmt = $pdo->prepare($query);

            // Liaison des paramètres
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            // Exécution de la requête
            $stmt->execute();

            // Récupération des données du produit
            $productData = $stmt->fetch(PDO::FETCH_ASSOC);

            // Vérifier si des données ont été récupérées
            if ($productData) {
                // Créer une instance de la classe Product
                $product = new Product(
                    $productData['id'],
                    $productData['name'],
                    json_decode($productData['photos'], true),
                    $productData['price'],
                    $productData['description'],
                    $productData['quantity'],
                    new DateTime($productData['createdAt']),
                    new DateTime($productData['updatedAt']),
                    $productData['category_id'],
                    $pdo
                );

                return $product;
            } else {
                // Aucune ligne trouvée, retourner false
                return false;
            }
        } catch (PDOException $e) {
            // Gérer les erreurs lors de l'exécution de la requête
            die('Erreur lors de la récupération du produit par ID : ' . $e->getMessage());
        }
    }
    public function create()
    {
        // Requête SQL pour insérer un nouveau produit
        $query = "INSERT INTO product (name, photos, price, description, quantity, createdAt, updatedAt, category_id) 
                  VALUES (:name, :photos, :price, :description, :quantity, :createdAt, :updatedAt, :category_id)";

        try {
            // Préparer la requête
            $stmt = $this->pdo->prepare($query);

            // Liaison des paramètres
            $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
            $stmt->bindParam(':photos', json_encode($this->photos), PDO::PARAM_STR);
            $stmt->bindParam(':price', $this->price, PDO::PARAM_INT);
            $stmt->bindParam(':description', $this->description, PDO::PARAM_STR);
            $stmt->bindParam(':quantity', $this->quantity, PDO::PARAM_INT);
            $stmt->bindParam(':createdAt', $this->createdAt->format('Y-m-d H:i:s'), PDO::PARAM_STR);
            $stmt->bindParam(':updatedAt', $this->updatedAt->format('Y-m-d H:i:s'), PDO::PARAM_STR);
            $stmt->bindParam(':category_id', $this->category_id, PDO::PARAM_INT);

            // Exécution de la requête
            $stmt->execute();

            // Récupération de l'ID du nouveau produit
            $this->id = $this->pdo->lastInsertId();

            return $this;
        } catch (PDOException $e) {
            // Gérer les erreurs lors de l'exécution de la requête
            die('Erreur lors de l\'insertion du produit : ' . $e->getMessage());
        }
    }
    public static function findAll($pdo)
    {
        // Requête SQL pour récupérer tous les produits
        $query = "SELECT * FROM product";

        try {
            // Préparer la requête
            $stmt = $pdo->query($query);

            // Récupération des données de tous les produits
            $productsData = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Tableau pour stocker les instances de la classe Product
            $products = [];

            // Vérifier si des données ont été récupérées
            if ($productsData) {
                foreach ($productsData as $productData) {
                    // Créer une instance de la classe Product
                    $product = new Product(
                        $productData['id'],
                        $productData['name'],
                        json_decode($productData['photos'], true),
                        $productData['price'],
                        $productData['description'],
                        $productData['quantity'],
                        new DateTime($productData['createdAt']),
                        new DateTime($productData['updatedAt']),
                        $productData['category_id'],
                        $pdo
                    );

                    // Ajouter l'instance au tableau
                    $products[] = $product;
                }
            }

            return $products;
        } catch (PDOException $e) {
            // Gérer les erreurs lors de l'exécution de la requête
            die('Erreur lors de la récupération de tous les produits : ' . $e->getMessage());
        }
    }
    public function update()
    {
        // Vérifier si l'instance a déjà un ID
        if ($this->id === null) {
            die('Impossible de mettre à jour le produit sans ID.');
        }

        // Requête SQL pour mettre à jour un produit
        $query = "UPDATE product 
                  SET name = :name, 
                      photos = :photos, 
                      price = :price, 
                      description = :description, 
                      quantity = :quantity, 
                      updatedAt = :updatedAt, 
                      category_id = :category_id
                  WHERE id = :id";

        try {
            // Préparer la requête
            $stmt = $this->pdo->prepare($query);

            // Liaison des paramètres
            $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
            $stmt->bindParam(':photos', json_encode($this->photos), PDO::PARAM_STR);
            $stmt->bindParam(':price', $this->price, PDO::PARAM_INT);
            $stmt->bindParam(':description', $this->description, PDO::PARAM_STR);
            $stmt->bindParam(':quantity', $this->quantity, PDO::PARAM_INT);
            $stmt->bindParam(':updatedAt', $this->updatedAt->format('Y-m-d H:i:s'), PDO::PARAM_STR);
            $stmt->bindParam(':category_id', $this->category_id, PDO::PARAM_INT);
            $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

            // Exécution de la requête
            $stmt->execute();

            return $this;
        } catch (PDOException $e) {
            // Gérer les erreurs lors de l'exécution de la requête
            die('Erreur lors de la mise à jour du produit : ' . $e->getMessage());
        }
    }

    // New method to get products associated with the category
    public function getProducts()
    {
 // Vérifier si la catégorie existe
    $categoryData = getCategoryById($this->id);
     if (!$categoryData) {
    throw new Exception('Category not found.');
    }
    
// Récupérer les produits associés à la catégorie
     $query = "SELECT * FROM product WHERE category_id = :category_id";
     try {
     $stmt = $this->pdo->prepare($query);
     $stmt->bindParam(':category_id', $this->id, PDO::PARAM_INT);
     $stmt->execute();
    
     $productsData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
// Tableau pour stocker les instances de la classe Product
     $products = [];
    
// Vérifier si des données ont été récupérées
     if ($productsData) {
    foreach ($productsData as $productData) {
   // Créer une instance de la classe Product
     $product = new Product(
     $productData['id'],
     $productData['name'],
     json_decode($productData['photos'], true),
     $productData['price'],
     $productData['description'],
     $productData['quantity'],
     new DateTime($productData['createdAt']),
     new DateTime($productData['updatedAt']),
     $productData['category_id']
     );
    
 // Ajouter l'instance au tableau
    $products[] = $product;
     }
     }
    
    return $products;
     } catch (PDOException $e) {
     die('Error retrieving products from category: ' . $e->getMessage());
     }
    }
}
class Clothing extends Product
{
    private $size;
    private $color;
    private $type;
    private $material_fee;

    public function __construct(
        $id = null,
        $name = null,
        $photos = null,
        $price = null,
        $description = null,
        $quantity = null,
        $createdAt = null,
        $updatedAt = null,
        $category_id = null,
        $pdo = null,
        $size = null,
        $color = null,
        $type = null,
        $material_fee = null
    ) {
        parent::__construct($id, $name, $photos, $price, $description, $quantity, $createdAt, $updatedAt, $category_id, $pdo);
        $this->size = $size;
        $this->color = $color;
        $this->type = $type;
        $this->material_fee = $material_fee;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function setSize($size)
    {
        $this->size = $size;
    }

    public function getColor()
    {
        return $this->color;
    }

    public function setColor($color)
    {
        $this->color = $color;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getMaterialFee()
    {
        return $this->material_fee;
    }

    public function setMaterialFee($material_fee)
    {
        $this->material_fee = $material_fee;
    }
    public static function findOneById($id, $pdo)
    {
        $query = "SELECT * FROM clothing WHERE id = :id";

        try {
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $clothingData = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($clothingData) {
                return new Clothing(
                    $clothingData['id'],
                    $clothingData['name'],
                    // ... (autres propriétés spécifiques à Clothing)
                    $clothingData['category_id'],
                    $pdo
                );
            } else {
                return false;
            }
        } catch (PDOException $e) {
            die('Error fetching clothing by ID: ' . $e->getMessage());
        }
    }
}
class Electronic extends Product
{
    private $brand;
    private $warranty_fee;

    public function __construct(
        $id = null,
        $name = null,
        $photos = null,
        $price = null,
        $description = null,
        $quantity = null,
        $createdAt = null,
        $updatedAt = null,
        $category_id = null,
        $pdo = null,
        $brand = null,
        $warranty_fee = null
    ) {
        parent::__construct($id, $name, $photos, $price, $description, $quantity, $createdAt, $updatedAt, $category_id, $pdo);
        $this->brand = $brand;
        $this->warranty_fee = $warranty_fee;
    }

    public function getBrand()
    {
        return $this->brand;
    }

    public function setBrand($brand)
    {
        $this->brand = $brand;
    }

    public function getWarrantyFee()
    {
        return $this->warranty_fee;
    }

    public function setWarrantyFee($warranty_fee)
    {
        $this->warranty_fee = $warranty_fee;
    }
    public static function findOneById($id, $pdo)
    {
        $query = "SELECT * FROM electronic WHERE id = :id";

        try {
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $electronicData = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($electronicData) {
                return new Electronic(
                    $electronicData['id'],
                    $electronicData['name'],
                    // ... (autres propriétés spécifiques à Electronic)
                    $electronicData['category_id'],
                    $pdo
                );
            } else {
                return false;
            }
        } catch (PDOException $e) {
            die('Error fetching electronic by ID: ' . $e->getMessage());
        }
    }
}



// Fin de classe



$dsn = 'mysql:host=127.0.0.1;dbname=draft-shop';
$username = 'pma';
$password = 'plomkiplomki';


try {
    // Create a PDO instance
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur de connexion à la base de données : ' . $e->getMessage());
}

// Example: Get category by ID
$categoryID = 1; // Replace with the desired category ID
$query = "SELECT * FROM category WHERE id = :id";

try {
    // Prepare the query
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $categoryID, PDO::PARAM_INT);
    $stmt->execute();

    // Fetch category data
    $categoryData = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($categoryData) {
        // Create an instance of the Category class
        $category = new Category(
            $categoryData['id'],
            $categoryData['name'],
            $categoryData['description'],
            new DateTime($categoryData['createdAt']),
            new DateTime($categoryData['updatedAt']),
            $pdo
        );    

// Afficher les informations de la catégorie
echo "Category ID: " . $category->getId() . "<br>";
echo "Category Name: " . $category->getName() . "<br>";
echo "Category Description: " . $category->getDescription() . "<br>";
echo "Category Created At: " . $category->getCreatedAt()->format('Y-m-d H:i:s') . "<br>";
echo "Category Updated At: " . $category->getUpdatedAt()->format('Y-m-d H:i:s') . "<br>";

// Récupérer les produits associés à la catégorie
$products = new Product();
$product->update();

// Afficher les informations des produits
echo "<h2>Products in this category:</h2>";

if (!empty($products)) {
    foreach ($products as $product) {
        echo "Product ID: " . $product->getId() . "<br>";
        echo "Product Name: " . $product->getName() . "<br>";
        // Afficher d'autres informations sur le produit au besoin
        echo "<br>";
    }
} else {
    echo "No products found in this category.";
}


    } else {
        echo "Category not found.";
    }
} catch (PDOException $e) {
    die('Error executing query: ' . $e->getMessage());
}
?>