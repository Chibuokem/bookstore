<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\BookRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\OrderRepositoryInterface;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
   
    public function __construct(OrderRepositoryInterface $orderRepositoryInterface, UserRepositoryInterface $userRepositoryInterface, BookRepositoryInterface $bookRepositoryInterface)
    {
        $this->orderRepositoryInterface = $orderRepositoryInterface;
        $this->userRepositoryInterface = $userRepositoryInterface;
        $this->bookRepositoryInterface = $bookRepositoryInterface;
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $data['user'] = $user;
        return view('dashboard.home', $data);
    }

    /**
     * View user orders
     *
     * @return void
     */
    public function viewOrders()
    {
        $user = Auth::user();
        $data['user'] = $user;
        $data['orders'] = $this->orderRepositoryInterface->getOrdersByEmail($user->email);
        return view('dashboard.orders', $data);   
    }
}