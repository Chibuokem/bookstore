<?php

namespace App\Interfaces;

interface UserRepositoryInterface
{


    /* Function to find a user model by id
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

    //function to get all users
    public function all();
}