<?php
namespace App;

use App\Abstract\AbstractProduct;
use App\Interface\StockableInterface;

class Electronic extends AbstractProduct implements StockableInterface
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