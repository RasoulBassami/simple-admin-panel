<?php

namespace App\Utilities;

use App\Models\Image;
use Illuminate\Support\Facades\File;

class ImageUploader implements FileUploaderInterface
{
    public static function uploadMany ($destination_path, $images)
    {
        foreach ($images as $file) {
            $upload_path = $destination_path . $file->getClientOriginalName();
            $path = $file->store($upload_path, ['disk' => 'public']);
            $uploaded_images[] = [
                'name' => $file->getClientOriginalName(),
                'path' => $path
            ];
        }
        return $uploaded_images;
    }

    public static function update($destination_path, $oldImage, $newImage)
    {
        self::delete($oldImage);
        $upload_path = $destination_path . $newImage->getClientOriginalName();
        return $newImage->store($upload_path, ['disk' => 'public']);
    }

    public static function delete($image)
    {

        if(File::exists(public_path($image->path))) {
            File::delete(public_path($image->path));
        }
    }

    public static function deleteMany($images)
    {
        foreach ($images as $image) {
            self::delete($image);
        }
    }
}
