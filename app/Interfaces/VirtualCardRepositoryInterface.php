<?php

namespace App\Interfaces;

interface VirtualCardRepositoryInterface
{
    /* Function to find a virtual card by id
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

    //function to get all cards
    public function all();
}