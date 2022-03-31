<?php

require_once __DIR__.'/AbstractController.php';

Class AdminCategoryController extends AbstractController
{
    //add method index to display the list of categories
    public function index()
    {
        $this->checkUserIsLogAndAdmin();

        //obtain categories list form database
        $categories = $this->db->query('SELECT * FROM categories');

        $template = $this->twig->load('AdminCategory.html.twig');
        echo $template->render(['categories' => $categories]);
    }

    //add method to add a category with post parameters $name and use the database to create a category
    public function add()
    {
        $this->checkUserIsLogAndAdmin();

        //check if the category exists
        $query = $this->db->prepare('SELECT * FROM categories WHERE name = :name');
        $query->execute(['name' => $_POST['category_name']]);
        $category = $query->fetch();

        //if the category exists
        if($category){
            //redirect to the add category page
            //header('Location: /add-category');

            $categories = $this->db->query('SELECT * FROM categories');

            $template = $this->twig->load('AdminCategory.html.twig');
            echo $template->render(['error' => 'Category already exists', 'categories' => $categories]);            
        }else{
            //create the category
            $query = $this->db->prepare('INSERT INTO categories (name) VALUES (:name)');
            $query->execute(['name' => $_POST['category_name']]);

            //redirect to the add category page
            header('Location: /admin-category');
        }
    }

    //add method to delete a category with post parameters $id and use the database to delete a category
    public function delete()
    {
        $this->checkUserIsLogAndAdmin();

        //check if the category exists
        $query = $this->db->prepare('SELECT * FROM categories WHERE id = :id');
        $query->execute(['id' => $_POST['category_id']]);
        $category = $query->fetch();

        //if the category exists
        if($category){
            //delete the category
            $query = $this->db->prepare('DELETE FROM categories WHERE id = :id');
            $query->execute(['id' => $_POST['category_id']]);

            //redirect to the add category page
            header('Location: /admin-category');
        }else{
            //redirect to the category page

            header('Location: /admin-category');
        }
    }
}