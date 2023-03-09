<?php

namespace app\models;

use app\Database;
use app\helpers\StringHelper;

class Product
{
    public ?int $id = null;
    public ?string $title = null;
    public ?string $description = null;
    public ?float $price = null;
    public ?string $imagePath = null;
    public ?array $imageFile = null;

    public function load($data)
    {
        $this->id = $data['id'] ?? null;
        $this->title = $data['title'];
        $this->description = $data['description'] ?? '';
        $this->price = $data['price'];
        $this->id = $data['id'] ?? null;
        $this->imageFile = $data['imageFile'] ?? null;
        $this->imagePath = $data['image'] ?? null;
    }

    public function save()
    {
        $errors = [];
        if(!$this->title){
            $errors[] = 'Product Title is Required.';
        }
        if(!$this->price){
            $errors[] = 'Product Price is Required.';
        }
        if(!is_dir(__DIR__ . '/../public/images')){
            mkdir(__DIR__ . '/../public/images');
        }
        if(empty($errors)){

            if($this->imageFile['name']){

                if ($this->imagePath) {
                    unlink(__DIR__ .'/../public/'. $this->imagePath);
                    $dir = dirname($this->imagePath);
                    rmdir($dir);
                }

                $this->imagePath = 'images/'. StringHelper::randPath(8).'/' . $this->imageFile['name'];
                mkdir(dirname(__DIR__ .'/../public/'.$this->imagePath));
                move_uploaded_file($this->imageFile['tmp_name'], __DIR__ .'/../public/'.$this->imagePath);
            }

            $db = Database::$db;
            if($this->id){
                $db->updateProduct($this);
            }else{
                $db->createProduct($this);
            }
        }

        return $errors;
    }
}