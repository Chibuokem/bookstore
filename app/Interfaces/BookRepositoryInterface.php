<?php

namespace App\Interfaces;

interface BookRepositoryInterface
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
     * Funtion to return all withdrawals
     *
     * @return void
     */
    public function all();

    /**
     * Function to store book
     *
     * @param array $params
     * @return void
     */
    public function storeBook(array $params);

    /**
     * Function to store book
     *
     * @param array $params
     * @return void
     */
    public function updateBook(array $params);

    /**
     * Function to delete book
     *
     * @param integer $id
     * @return void
     */
    public function delete(int $id);

    /**
     * Function to get active books
     *
     * @return void
     */
    public function getActiveBooks();
}