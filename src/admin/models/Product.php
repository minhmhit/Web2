<?php
class Product {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT p.*, c.CategoryName, b.BrandName 
                                   FROM product p 
                                   LEFT JOIN categories c ON p.CategoryID = c.CategoryID 
                                   LEFT JOIN brand b ON p.BrandID = b.BrandID 
                                   WHERE p.IsDeleted = 0");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM product WHERE ProductID = ? AND IsDeleted = 0");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function add($data) {
        $stmt = $this->pdo->prepare("INSERT INTO product (ProductName, CategoryID, BrandID, Gender, Price, ImageURL) 
                                     VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $data['ProductName'], 
            $data['CategoryID'], 
            $data['BrandID'], 
            $data['Gender'], 
            $data['Price'], 
            $data['ImageURL']
        ]);
    }

    public function update($id, $data) {
        $stmt = $this->pdo->prepare("UPDATE product 
                                     SET ProductName = ?, CategoryID = ?, BrandID = ?, Gender = ?, Price = ?, ImageURL = ? 
                                     WHERE ProductID = ?");
        $stmt->execute([
            $data['ProductName'], 
            $data['CategoryID'], 
            $data['BrandID'], 
            $data['Gender'], 
            $data['Price'], 
            $data['ImageURL'], 
            $id
        ]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("UPDATE product SET IsDeleted = 1 WHERE ProductID = ?");
        $stmt->execute([$id]);
    }
}