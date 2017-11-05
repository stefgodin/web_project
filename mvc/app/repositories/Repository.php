<?php

abstract class Repository
{
    protected $model;

    function __construct()
    {
        $this->model = $this->getRepositoryModel();
    }

    protected function db(){
        return new DatabaseConnector(PDO::FETCH_CLASS,$this->model);
    }

    function find($_id){
        return $this->db()->select("*")->from($this->getModelTable())->where("id = $_id")->getRow();
    }

    function findOneBy($_criteria){
        $conditions = array();
        foreach ($_criteria as $column => $value){
            $conditions[] = "$column = $value";
        }
        return $this->db()->select("*")->from($this->getModelTable())->where($conditions)->getRow();
    }

    function findBy($_criteria){
        $conditions = array();
        foreach ($_criteria as $column => $value){
            $conditions[] = "$column = $value";
        }
        return $this->db()->select("*")->from($this->getModelTable())->where($conditions)->getArray();
    }

    private function getRepositoryModel(){
        $repository = get_class($this);
        $modelName = ucwords(substr($repository,0,strpos($repository,"Repository")));
        $modelPath = __DIR__."/../models/$modelName.php";
        if(!file_exists($modelPath)){
            throw new Exception("Repository name ($repository) doesn't match any model.");
        }

        return $modelName;
    }

    protected function getModelTable(){
        $table = "tbl_".strtolower($this->model);
        return $table;
    }

    /**
     * @param Entity $_entity
     */
    public function persist($_entity){
        try {
            if ($_entity->getId()) {
                $this->updateEntity($_entity);
            } else {
                $this->insertEntity($_entity);
            }
        }
        catch (PDOException $PDOException){
            echo $PDOException->getMessage();
        }
        catch (Exception $exception) {
            echo $exception->getMessage();
        }
    }

    /**
     * @param Entity $_entity
     */
    private function updateEntity($_entity){
        $refClass = new ReflectionClass($this->model);
        $table = $this->getModelTable();

        $updateFields = array();
        foreach ($refClass->getProperties() as $property) {
            $propertyName = $property->getName();
            if ($propertyName != "id" && !is_array($this->$propertyName)) {
                $updateFields[$propertyName] = $this->$propertyName;
            }
        }
        $id = $_entity->getId();
        $this->db()->update($table)->set($updateFields)->where("id = $id")->execute();
    }

    /**
     * @param Entity $_entity
     */
    private function insertEntity($_entity){
        $refClass = new ReflectionClass($this->model);
        $table = $this->getModelTable();

        $insertFields = array();
        foreach ($refClass->getProperties() as $property) {
            $propertyName = $property->getName();
            if ($propertyName != "id" && !is_array($this->$propertyName)) {
                $insertFields[$propertyName] = $this->$propertyName;
            }
        }
        $this->db()->insert($table,$insertFields)->execute();
    }
}