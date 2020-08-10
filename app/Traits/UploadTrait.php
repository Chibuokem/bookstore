<?php
namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait UploadTrait
{
    /**
     * function to upload a file 
     */
    public function uploadOne(UploadedFile $uploadedFile, $folder = null, $disk = 'public', $filename = null)
    {
        $name = !is_null($filename) ? $filename : str_random(25);

        $file = $uploadedFile->storeAs($folder, $name . '.' . $uploadedFile->getClientOriginalExtension(), $disk);

        return $file;
    }

    /**
     * function to upload a file 
     */
    public function uploadSingleFile(UploadedFile $uploadedFile, $folder = null, $filename = null, $disk = 'public'){
    
        $name = !is_null($filename) ? $filename : str_random(25);

        $file = $uploadedFile->storeAs($folder, $name . '.' . $uploadedFile->getClientOriginalExtension(), $disk);

        return $file;
    }

    /**
     * function to delete a file
     */
    public function deleteOne($file = null, $disk = 'public')
    {
        //Storage::disk($disk)->delete($folder . $filename);
        Storage::disk($disk)->delete($file);
    }

     /**
     * anotherfunction to upload a file 
     */
    public function uploadOnejpg(UploadedFile $uploadedFile, $folder = null, $disk = 'public', $filename = null)
    {
        $name = !is_null($filename) ? $filename : str_random(25);
       // $originalextenstion = $uploadedFile->getClientOriginalExtension()
       $originalextenstion = 'jpg';
        $file = $uploadedFile->storeAs($folder, $name . '.' . $originalextenstion, $disk);

        return $file;
    }

    /**
     * function to check if file exists
     */
    public function checkExistence($file = null, $disk = 'public'){
        $exists = Storage::disk($disk)->exists($file);
        return $exists;
    }

    /**
     * function to get file url
     *
     * @param [type] $file
     * @param string $disk
     * @return void
     */
    public function getFileUrl($file = null, $disk = 'public'){
        $url = Storage::url($file);
        return $url;
    }
}