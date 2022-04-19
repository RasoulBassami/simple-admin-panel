<?php

namespace App\Utilities;

use App\Image;
use Illuminate\Support\Facades\File;

class ImageUploader implements FileUploaderInterface
{
    public static function uploadMany ($destination_path, $images)
    {
        foreach ($images as $file) {
            $upload_path = $destination_path . $file['image']->getClientOriginalName();
            $path = $file['image']->store($upload_path, ['disk' => 'public']);
            $images_paths[] = $path;
        }
        return $images_paths;
    }

    public static function update($destination_path, $oldImage, $newImage)
    {
        self::delete($oldImage);
        $upload_path = $destination_path . $newImage->getClientOriginalName();
        return $newImage->store($upload_path, ['disk' => 'public']);
    }

    public static function delete($image)
    {
        if(File::exists(public_path($image->image))) {
            File::delete(public_path($image->image));
        }
    }
}
