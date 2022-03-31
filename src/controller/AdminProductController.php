<?php

require_once __DIR__.'/AbstractController.php';

Class AdminProductController extends AbstractController
{
    //add method index to display the list of all products
    public function index()
    {
        $this->checkUserIsLogAndAdmin();

        //obtain products list form database
        $products = ($this->db->query('SELECT * FROM products'))->fetchAll();
        $categories = ($this->db->query('SELECT * FROM categories'))->fetchAll();

        foreach ($products as &$product) {
            $query = $this->db->prepare('SELECT * FROM categories WHERE id = :id');
            $query->execute(['id' => $product['category_id']]);
            $category = $query->fetch();
            $product['category_name'] = $category['name'];
        }

        $template = $this->twig->load('AdminProduct.html.twig');
        echo $template->render(['products' => $products, 'categories' => $categories]);
    }

    public function add()
    {
        $this->checkUserIsLogAndAdmin();

        //check if the product exists
        $query = $this->db->prepare('SELECT * FROM products WHERE name = :name');
        $query->execute(['name' => $_POST['product_name']]);
        $product = $query->fetch();

        //if the product exists
        if($product){
            //redirect to the add product page
            //header('Location: /add-product');

            $categories = $this->db->query('SELECT * FROM categories');

            $template = $this->twig->load('AdminProduct.html.twig');
            echo $template->render(['error' => 'Product already exists', 'categories' => $categories]);

        }else{
            //create the product
            $query = $this->db->prepare('INSERT INTO products (name, description, price, img_url, category_id) VALUES (:name, :description, :price, :img_url, :category_id)');
            $query->execute(
                [
                    'name' => $_POST['product_name'], 
                    'description' => $_POST['product_description'], 
                    'price' => $_POST['product_price'],
                    'img_url' => $_POST['product_image'],
                    'category_id' => $_POST['product_category']
                ]
            );

            //redirect to the add product page
            header('Location: /admin-product');
        }
    }

    //add method to delete a product with post parameters $id and use the database to delete a product
    public function delete()
    {
        $this->checkUserIsLogAndAdmin();

        //check if the product exists
        $query = $this->db->prepare('SELECT * FROM products WHERE id = :id');
        $query->execute(['id' => $_POST['product_id']]);
        $product = $query->fetch();

        //if the product exists
        if($product){
            //delete the product
            $query = $this->db->prepare('DELETE FROM products WHERE id = :id');
            $query->execute(['id' => $_POST['product_id']]);

            //redirect to the add product page
            header('Location: /admin-product');
        }else{
            //redirect to the add product page
            header('Location: /admin-product');
        }
    }

    //edit method to edit a product with post parameters $id and use the database to edit a product
    public function edit()
    {
        $this->checkUserIsLogAndAdmin();

        //check if the product exists
        $query = $this->db->prepare('SELECT * FROM products WHERE id = :id');
        $query->execute(['id' => $_POST['product_id']]);
        $product = $query->fetch();

        //if the product exists
        if($product){
            //edit the product
            $query = $this->db->prepare('UPDATE products SET name = :name, description = :description, price = :price, img_url = :img_url, category_id = :category_id WHERE id = :id');
            $query->execute(
                [
                    'name' => $_POST['product_name'], 
                    'description' => $_POST['product_description'], 
                    'price' => $_POST['product_price'],
                    'img_url' => $_POST['product_image'],
                    'category_id' => $_POST['product_category'],
                    'id' => $_POST['product_id']
                ]
            );

            //redirect to the add product page
            header('Location: /admin-product');
        }else{
            //redirect to the add product page
            header('Location: /admin-product');
        }
    }

}