<?php
namespace Category\Form;

use Zend\Form\Form;

class CategoryForm extends Form {
    public function __construct($name = null) {
        parent::__construct('category');

        $this->add([
            'name' => 'id',
            'type' => 'hidden',
        ]);
        $this->add([
            'name' => 'name',
            'type' => 'text',
        ]);
    }
}
