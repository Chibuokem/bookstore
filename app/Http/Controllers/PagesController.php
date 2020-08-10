<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\BookRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\OrderRepositoryInterface;
use App\Models\Book;

class PagesController extends Controller
{
    //
    public function __construct(OrderRepositoryInterface $orderRepositoryInterface, UserRepositoryInterface $userRepositoryInterface, BookRepositoryInterface $bookRepositoryInterface)
    {
        $this->orderRepositoryInterface = $orderRepositoryInterface;
        $this->userRepositoryInterface = $userRepositoryInterface;
        $this->bookRepositoryInterface = $bookRepositoryInterface;
    }

    public function index(){
        $data['books'] = $this->bookRepositoryInterface->getActiveBooks();
        return view('pages.home', $data);
    }

    /**
     * Function to return books
     *
     * @return void
     */
    public function books(){
        $data['books'] = $this->bookRepositoryInterface->getActiveBooks();
        return view('pages.books', $data);
    }

    public function viewBook(Book $book)
    {
        $data['book'] = $book;
        return view('pages.book', $data);  
    }


}