<?php

namespace App\Repositories;

use App\User;
use App\Models\Book;
use App\Interfaces\BookRepositoryInterface;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class BookRepository implements BookRepositoryInterface
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
    public function __construct(Book $model)
    {
        $this->model = $model;
    }

    /* Function to find a  model by id
     *
     * @param integer $id
     * @return void
     */
    public function find(int $id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Funtion to return all withdrawals
     *
     * @return void
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Function to get a  Model instance
     *
     * @return void
     */
    public function getModelInstance()
    {
        return $this->model;
    }

    /**
     * Function to store book
     *
     * @param array $params
     * @return void
     */
    public function storeBook(array $params)
    {
        $bookModel = $this->model;
        $bookModel->name = $params['name'];
        $bookModel->author = $params['author'];
        $bookModel->image = $params['image'];
        $bookModel->book = $params['book'];
        $bookModel->price = $params['price'];
        $bookModel->save();
        return $bookModel;
    }

    /**
     * Function to store book
     *
     * @param array $params
     * @return void
     */
    public function updateBook(array $params)
    {
        $book = $this->find($params['id']);
        $book->name = $params['name'];
        $book->author = $params['author'];
        if(isset($params['image'])){
            $book->image = $params['image']; 
        }

        if (isset($params['book'])) {
            $book->book = $params['book'];
        }  
        $book->price = $params['price'];
        $book->save();
        return $book;
    }

    /**
     * Function to delete book
     *
     * @param integer $id
     * @return void
     */
    public function delete(int $id)
    {
        $book = $this->find($id);
        $book->delete();
        return $book;
    }

    /**
     * Function to get active books
     *
     * @return void
     */
    public function getActiveBooks()
    {
        $books = $this->model::where('status', 1)->get();
        return $books;
        
    }

    
}