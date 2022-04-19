<?php

namespace App\Utilities;

interface FileUploaderInterface
{
    public static function uploadMany ($destination_path, $files);

    public static function update ($destination_path, $oldFile, $newFile);

    public static function delete ($file);
}
