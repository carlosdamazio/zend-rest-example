<?php

namespace Category\Controller;

use Category\Model\CategoryTable;
use Category\Model\Category;
use Category\Form\CategoryForm;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\Http\Response;


class CategoryController extends AbstractActionController {
    private $table;

    public function __construct(CategoryTable $table) {
        $this->table = $table;
    }

    public function indexAction() {

        $method = $this->getRequest()->getMethod();

        switch ($method) {
            case 'GET':
                $resultSet = $this->table->fetchAll();
                $categories = $this->table->toArray($resultSet);
                $return_data = new JsonModel($categories);
                break;

            case 'POST':
                $return_data = $this->addAction();
                break;

            case 'PUT':
                $return_data = $this->editAction();
                break;

            case 'DELETE':
                $return_data = $this->deleteAction();
                break;

            case 'OPTIONS':
              $return_data = new Response();
              $return_data->getHeaders()->addHeaders(array(
                'Access-Control-Allow-Origin' => 'http://localhost:4200',
                'Access-Control-Allow-Methods' => '*',
                'Access-Control-Allow-Credentials' => 'true',
                'Access-Control-Allow-Headers' => 'Content-Type, Authorization'
              ));
        }

        return $return_data;
    }

    public function addAction() {
        $category = new Category();

        $data = (array)json_decode($this->getRequest()->getContent(), true);
        $category->exchangeArray($data);

        $this->table->saveCategory($category);

        $return_data = new JsonModel([
          $data
        ]);

        return $return_data;
    }

    public function editAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        $category = $this->table->getCategory($id);

        $data = (array) json_decode($this->getRequest()->getContent(), true);
        $category->name = $data['name'];
        $this->table->saveCategory($category);

        $return_data = new JsonModel([
            'data' => [
                $category, $id
            ]
        ]);

        return $return_data;
    }

    public function deleteAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        $this->table->deleteCategory($id);

        $return_data = new JsonModel([
            'data' => [
                'DELETE',
            ]
        ]);

        return $return_data;
    }
}
