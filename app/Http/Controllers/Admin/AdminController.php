<?php

namespace App\Http\Controllers\Admin;

use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\BookRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\OrderRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Book;
use App\Models\Order;


class AdminController extends Controller
{
    use UploadTrait;
    public function __construct(OrderRepositoryInterface $orderRepositoryInterface, UserRepositoryInterface $userRepositoryInterface, BookRepositoryInterface $bookRepositoryInterface)
    {
        $this->orderRepositoryInterface = $orderRepositoryInterface;
        $this->userRepositoryInterface = $userRepositoryInterface;
        $this->bookRepositoryInterface = $bookRepositoryInterface;
        $this->middleware('auth');
        $this->middleware('admin');
    }


    /**
     * Function to view list of books on the platform
     *
     * @return void
     */
    public function viewBooks()
    {
        $data['user'] = Auth::user();
        $books = $this->bookRepositoryInterface->all();
        $data['books'] = $books;
        return view('admin.books', $data);
    }

    /**
     * Function to view list of books on the platform
     *
     * @return void
     */
    public function viewOrders()
    {
        $data['user'] = Auth::user();
        $orders = $this->orderRepositoryInterface->all();
        $data['orders'] = $orders;
        return view('admin.view-orders', $data);
    }

    /**
     * Function to add book
     *
     * @param Request $request
     * @return void
     */
    public function addBook(Request $request)
    {
        $this->validateBookUpload($request);
        $params = array();
        $params['name'] = $request->name;
        $params['author'] = $request->author;
        $params['price'] = $request->price;

        $image = "";
        $book = "";
        if ($request->has('image')) {
            // Get media file
            $image = $request->file('image');
            // Make a image name based on gig name and current timestamp
            $filename = Str::slug('book_'.$params['name']) . '_' . time();
            // Define folder path
            $folder = '/uploads/books';
            //upload media 
            $uploadedMedia = $this->uploadSingleFile($image, $folder, $filename);
            //   $input['media'] = $uploadedMedia;
            $image  = $uploadedMedia;
        }

        if ($request->has('book')) {
            // Get media file
            $book = $request->file('book');
            // Make a image name based on gig name and current timestamp
            $bookname = Str::slug('book_file_' . $params['name']) . '_' . time();
            // Define folder path
            $foldername = '/uploads/bookfiles';
            //upload media 
            $uploadedBook = $this->uploadSingleFile($book, $foldername, $bookname);
            //   $input['media'] = $uploadedMedia;
            $book  = $uploadedBook;
        }
        $params['image']= $image;
        $params['book'] = $book; 
         $store = $this->bookRepositoryInterface->storeBook($params);
         return response()->json(['data' => $store]);
    }
    
    /**
     * Function to update book
     *
     * @param Request $request
     * @return void
     */
    public function updateBook(Request $request)
    {
        $this->validateBookUpdate($request);
        $params = array();
        $params['name'] = $request->name;
        $params['author'] = $request->author;
        $params['price'] = $request->price;
        $params['id'] = $request->id;        

        if ($request->has('image')) {
            // Get media file
            $image = $request->file('image');
            if($image != ""){
                // Make a image name based on gig name and current timestamp
                $filename = Str::slug('book_' . $params['name']) . '_' . time();
                // Define folder path
                $folder = '/uploads/books';
                //upload media 
                $uploadedMedia = $this->uploadSingleFile($image, $folder, $filename);
                //   $input['media'] = $uploadedMedia;
                $image  = $uploadedMedia;
                $params['image'] = $image;
            }
            
        }

        if ($request->has('book')) {
            // Get media file
            $book = $request->file('book');
            if($book != ""){
                // Make a image name based on gig name and current timestamp
                $bookname = Str::slug('book_file_' . $params['name']) . '_' . time();
                // Define folder path
                $foldername = '/uploads/bookfiles';
                //upload media 
                $uploadedBook = $this->uploadSingleFile($book, $foldername, $bookname);
                //   $input['media'] = $uploadedMedia;
                $book  = $uploadedBook;
                $params['book'] = $book;
            }
            
        }
        
        $store = $this->bookRepositoryInterface->updateBook($params);
        return response()->json(['data' => $store]);
    }

    /**
     * Function to delete book
     *
     * @param Request $request
     * @return void
     */
    public function deleteBook(Request $request)
    {
        $id = $request->id;
        $delete = $this->bookRepositoryInterface->delete($id);
        return response()->json(['data' => $delete]);
    }

    /**
     * Function to get book detail
     *
     * @param Book $book
     * @return void
     */
    public function getBook(Book $book){
        return response()->json(['data' => $book]);
    }

    /**
     * Manually confirm order
     *
     * @param Order $order
     * @return void
     */
    public function confirmOrder(Order $order)
    {
        $status = 1;
        $confirmOrder = $this->orderRepositoryInterface->updateStatus($order->id, $status);
        return response()->json(['data' => $confirmOrder]);
    }

    /**
     * Manually confirm order
     *
     * @param Order $order
     * @return void
     */
    public function disableConfirmation(Order $order)
    {
        $status = 0;
        $disable = $this->orderRepositoryInterface->updateStatus($order->id, $status);
        return response()->json(['data' => $disable]);
    }

    /**
     * Validate book update
     *
     * @param Request $request
     * @return array
     */
    private function validateBookUpload(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'author' => 'required|string',
            'price' => 'required|regex:/^\d*(\.\d{2})?$/',
            'image' => 'required|image|max:2048',
            //'image' => 'required|file|image|mimes:jpeg,png,gif,webp|max:2048',
            "book" => "required|mimes:pdf|max:10000"
        ]);

        return $validatedData;
    }

    /**
     * Validate book upload
     *
     * @param Request $request
     * @return array
     */
    private function validateBookUpdate(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'author' => 'required|string',
            'price' => 'required|regex:/^\d*(\.\d{2})?$/',
            'image' => 'nullable|image|max:2048',
            //'image' => 'nullable|file|image|mimes:jpeg,png,gif,webp|max:2048',
            "book" => "nullable|mimes:pdf|max:10000"
        ]);

        return $validatedData;
    }

    /**
     * Function to view users
     *
     * @return void
     */
    public function viewUsers(){
        $data['user'] = Auth::user();
        $data['users'] = $this->userRepositoryInterface->all();
        return view('admin.users', $data);
    }

    /**
     * Function to switch admin level
     *
     * @param Request $request
     * @return void
     */
    public function switchAdminLevel(Request $request)
    {
        $id = $request->id;
        $status = $request->status;
        $changeAdminLevel = $this->userRepositoryInterface->switchAdminLevel($id, $status);
        return response()->json(['data' => $changeAdminLevel]);
    }

    /**
     * Function to delete user
     *
     * @param User $user
     * @return void
     */
    public function deleteUser(User $user){
       $user->delete();
        return response()->json(['data' => $user]); 
    }
}