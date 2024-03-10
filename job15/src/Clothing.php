<?php
namespace App;

use App\Abstract\AbstractProduct;
use App\Interface\StockableInterface;

class Clothing extends AbstractProduct implements StockableInterface
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
     // Implémenter les méthodes de l'interface StockableInterface
     public function addStocks(int $stock): self
     {
         $this->quantity += $stock;
         return $this;
     }
 
     public function removeStocks(int $stock): self
     {
         if ($this->quantity >= $stock) {
             $this->quantity -= $stock;
         } else {
             $this->quantity = 0;
         }
 
         return $this;
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