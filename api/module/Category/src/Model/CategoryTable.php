<?php

namespace Category\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class CategoryTable {
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function toArray($rs) {
        foreach ($rs as $row)
          $data[] = (array)$row;

        return $data;
    }

    public function fetchAll() {
        return $this->tableGateway->select();
    }

    public function getCategory($id) {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find category with identifier %d',
                $id
            ));
        }

        return $row;
    }

    public function saveCategory(Category $category) {
        $data = [
            'name' => $category->name,
        ];

        $id = (int) $category->id;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        try {
            $this->getCategory($id);
        } catch (RuntimeException $e) {
            throw new RuntimeException(sprintf(
                'Cannot update category with identifier %d; Simply does not exist',
                $id
            ));
        }
        $this->tableGateway->update($data, ['id' => $id]);
    }

    public function deleteCategory($id) {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
}
