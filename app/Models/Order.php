<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Book;

class Order extends Model
{
    //
    /*
	 * Create reference id for orders
	 */
    public function create_id()
    {
        $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $letters = str_shuffle($letters);
        $letters = substr($letters, 0, 5);
        $id = mt_rand(10000, 99999) . $letters . time();
        $id = str_shuffle($id);
        $id = substr($id, 0, 7);
        while (true) {
            $count = $this::where('reference', $id)->count();
            if ($count == 0) break;
            $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $letters = str_shuffle($letters);
            $letters = substr($letters, 0, 5);
            $id = mt_rand(10000, 99999) . $letters . time();
            $id = str_shuffle($id);
            $id = substr($id, 0, 7);
        }
        return $id;
    }

    /**
     * Order relationship with product
     *
     * @return void
     */
    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }
}