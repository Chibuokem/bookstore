<?php

namespace App\Repositories;

use App\User;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;


class UserRepository implements UserRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * Function to find a user by id
     *
     * @param integer $id
     * @return void
     */
    public function find(int $id)
    {
        return $this->model->findOrFail($id);
    }


    /**
     * Function to update bank details
     *
     * @param array $params
     * @return void
     */
    public function updatePersonalDetails(array $params, int $id)
    {
        $user = $this->find($id);
        $user->name = Arr::get($params, 'name', $user->name);
        $user->phone = Arr::get($params, 'phone', $user->phone);
        $user->save();
        return $user;
    }

    /**
     * Function to get a user Model instance
     *
     * @return void
     */
    public function getModelInstance()
    {
        return $this->model;
    }

    /**
     * Funtion to return all users
     *
     * @return void
     */
    public function all()
    {
        return $this->model->all();
    }

    public function createUser($data)
    {
        // return $this->model->create($params);
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * Function to create admin user
     *
     * @return void
     */
    public function createAdminUser(){
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'admin_level' => 1,
            'password' => Hash::make($data['password']),
        ]);
    }
}