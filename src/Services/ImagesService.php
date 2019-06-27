<?php


namespace App\Services;


class ImagesService
{
    public function uploadImage($image)
    {
        $fileName = '';

        if (!empty($image)) {

            $fileName = md5(uniqid()).'.'.$image->guessExtension();
            $image->move('uploads', $fileName);

        }

        return $fileName;
    }
}