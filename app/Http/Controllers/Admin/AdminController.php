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


class AdminController extends Controller
{
    use UploadTrait;
    public function __construct(OrderRepositoryInterface $orderRepositoryInterface, UserRepositoryInterface $userRepositoryInterface, BookRepositoryInterface $bookRepositoryInterface)
    {
        $this->orderRepositoryInterface = $orderRepositoryInterface;
        $this->userRepositoryInterface = $userRepositoryInterface;
        $this->bookRepositoryInterface = $bookRepositoryInterface;
        $this->middleware('auth');
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
     * Function to add book
     *
     * @param Request $request
     * @return void
     */
    public function addBook(Request $request)
    {
        $params = array();
        $params['name'] = $request->name;
        $params['author'] = $request->author;
        $params['price'] = $request->price;

        $image = "";
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
        $params['image']= $image; 
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
}