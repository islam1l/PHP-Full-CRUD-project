<?php

namespace app;

use app\models\Product;
use PDO;

class Database
{
    public PDO $pdo;
    public static Database $db;
    public function __construct()
    {
        $this->pdo = new PDO('mysql:host=localhost;dbname=products_crud', 'islam', '123456',
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        self::$db = $this;
    }

    public function getProducts($search = '')
    {
        if($search){
            $statement = $this->pdo->prepare('SELECT * FROM products WHERE title LIKE :title ORDER BY create_date DESC');
            $statement->bindValue(':title', "%$search%");
        }else{
            $statement = $this->pdo->prepare('SELECT * FROM products ORDER BY create_date DESC');
        }
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createProduct(Product $product)
    {
        $statement = $this->pdo->prepare("insert into products (title, image, description, price, create_date) 
                    VALUES (:title, :image, :description, :price, :date)"
        );
        $statement->bindValue(':title', $product->title);
        $statement->bindValue(':image', $product->imagePath);
        $statement->bindValue(':description', $product->description);
        $statement->bindValue(':price', $product->price);
        $statement->bindValue(':date', date('Y-m-d H:i:s'));
        $statement->execute();
    }

    public function deleteProduct($id){
        $statement = $this->pdo->prepare('SELECT * FROM products WHERE id = :id');
        $statement->bindValue(':id',$id);
        $statement->execute();
        $product = $statement->fetch(PDO::FETCH_ASSOC);
        $path = $product['image'];

        if (is_file(__DIR__.'/public/'.$path)) {
            unlink(__DIR__.'/public/'.$path);
            $dir = dirname(__DIR__.'/public/'.$path);
            rmdir($dir);
        }


        $statement = $this->pdo->prepare('DELETE FROM products WHERE id= :id');
        $statement->bindValue(':id', $id);
        $statement->execute();
    }

    public function getProductById($id)
    {
        $statement = $this->pdo->prepare('SELECT * FROM products WHERE id = :id');
        $statement->bindValue(':id',$id);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function updateProduct(Product $product)
    {
        $statement = $this->pdo->prepare("UPDATE products 
            SET title = :title, image = :image, description = :description, 
                price = :price
                WHERE id = :id"
        );
        $statement->bindValue(':title', $product->title);
        $statement->bindValue(':image', $product->imagePath);
        $statement->bindValue(':description', $product->description);
        $statement->bindValue(':price', $product->price);
        $statement->bindValue(':id', $product->id);
        $statement->execute();
    }
}