<?php

require_once __DIR__.'/AbstractController.php';

Class HomeController extends AbstractController
{
    //add method index to display the list of all products
    public function index()
    {
        //obtain products list form database
        $products = ($this->db->query('SELECT * FROM products'))->fetchAll();
        $categories = ($this->db->query('SELECT * FROM categories'))->fetchAll();

        foreach ($products as &$product) {
            $query = $this->db->prepare('SELECT * FROM categories WHERE id = :id');
            $query->execute(['id' => $product['category_id']]);
            $category = $query->fetch();
            $product['category_name'] = $category['name'];
        }

        $template = $this->twig->load('Home.html.twig');
        echo $template->render(['products' => $products, 'categories' => $categories]);
    }

    //add method to search a product by name, category, price with parameters
    public function search()
    {
        //obtain products list form database
        $categories = ($this->db->query('SELECT * FROM categories'))->fetchAll();

        $txtreq = 'SELECT * FROM products';
        $array = [];

        if(!empty($_POST['search']))
        {

            $txtreq .= ' WHERE name LIKE :name';
            $array['name'] = '%'.$_POST['search'].'%';
        }

        if(($_POST['category'] != 0) && !empty($_POST['category']))
        {

            if(!empty($_POST['search']))
            {
                $txtreq .= ' AND';
            }else{
                $txtreq .= ' WHERE';
            }

            $txtreq .= ' category_id = :category_id';
            $array = array_merge($array, ['category_id' => $_POST['category']]);
        }

        $txtreq .= ';';

        $query = $this->db->prepare($txtreq);
        $query->execute($array);
        $products = $query->fetchAll();

        foreach ($products as &$product) {
            $query = $this->db->prepare('SELECT * FROM categories WHERE id = :id');
            $query->execute(['id' => $product['category_id']]);
            $category = $query->fetch();
            $product['category_name'] = $category['name'];
        }

        $template = $this->twig->load('Home.html.twig');
        echo $template->render([
            'products' => $products, 
            'categories' => $categories, 
            'name' => $_POST['name'] ?? null, 
            'category' => $_POST['category'] ?? null, 
            'price' => $_POST['price'] ?? null
        ]);
    }
}