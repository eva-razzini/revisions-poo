class Product
{
    // ... (autres méthodes et propriétés de la classe Product)

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

    // ... (autres méthodes de la classe Product)
}
