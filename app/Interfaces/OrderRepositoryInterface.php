<?php

namespace App\Interfaces;

interface OrderRepositoryInterface
{


    /* Function to find a withdrawal model by id
     *
     * @param integer $id
     * @return void
     */
    public function find(int $id);

    /**
     * Function to get instance of the model class
     *
     * @return void
     */
    public function getModelInstance();

    /**
     * Funtion to return all orders
     *
     * @return void
     */
    public function all();

    /**
     * Function to delete book
     *
     * @param integer $id
     * @return void
     */
    public function delete(int $id);


    /**
     * Function to store book
     *
     * @param array $params
     * @return void
     */
    public function storeOrder(array $params);

    /**
     * Function to store book
     *
     * @param array $params
     * @return void
     */
    public function updateStatus(int $id, $status);

}