<?php

use Intervention\Image\ImageManager;

/**
 * --------------------------------------
 * uploaded file and return uploaded image address
 * --------------------------------------
 */
function uploadFile($file, $newDirectory, $newFileName = null)
{
    // prepare new directory
    $newDirectory = trim($newDirectory, "/")."/";
    if(!is_dir($newDirectory))
    {
        if(!mkdir($newDirectory, 0777, true))
        {
            die("Image resize : failed to create directory");
        }
    }
    is_writable($newDirectory);
    //get file type
    $fileType = explode('/', $file['type'])[1];
    // set name
    $fileName = empty($newFileName) ? $file['name'] : $newFileName . "." . $fileType ;
    //upload file
    $result = move_uploaded_file($file['tmp_name'], $newDirectory.$fileName);

    return $result == 0 ? false : $newDirectory.$fileName;
}
/**
 * --------------------------------------
 * return (resize and crop) image address
 * --------------------------------------
 */
function fitImage($filePath, $width, $height, $newDirectory, $newFileName = null, $fileType = null)
{
    //check main file
    if(!file_exists($filePath))
    {
        die("Image resize : file not exist!");
    }

    // prepare new directory
    $newDirectory = trim($newDirectory, "/")."/";
    if(!is_dir($newDirectory))
    {
        if(!mkdir($newDirectory, 0777, true))
        {
            die("Image resize : failed to create directory");
        }
    }
    is_writable($newDirectory);

    // set name
    $newFileName = empty($newFileName) ? basename($filePath) : empty($fileType) ? $newFileName.".".pathinfo($filePath, PATHINFO_EXTENSION) : $newFileName.".".$fileType ;

    // create an image manager instance with favored driver
    $manager = new ImageManager(array('driver' => 'GD'));

    // to finally create image instances
    $image = $manager->make($filePath)->fit($width, $height);

    // save image in new directory
    $image->save($newDirectory.$newFileName);
    unset($manager);
    unset($image);
    return "/".$newDirectory.$newFileName;
}

/**
 * -----------------------------------------------
 * return array of (resize and crop) image address
 * -----------------------------------------------
 */
function fitArrayImage($filePath, $sizes, $newDirectory, $newFileName = null, $fileType = null)
{
    if(empty($sizes))
    {
        die("Image array resize : array is empty!");
    }
    if(!file_exists($filePath))
    {
        die("Image array resize : file not exist!");
    }
    // prepare new directory
    $newDirectory = trim($newDirectory, "/")."/";
    if(!is_dir($newDirectory))
    {
        if(!mkdir($newDirectory, 0777, true))
        {
            die("Image resize : failed to create directory");
        }
    }
    is_writable($newDirectory);
    //pathArray
    $pathArray = [];
    // set name
    $newFileName = empty($newFileName) ? basename($filePath, "." . pathinfo($filePath, PATHINFO_EXTENSION)) : $newFileName;
    foreach ($sizes as $size)
    {
        $pathArray["{$size[0]}x{$size[1]}"] = fitImage($filePath, $size[0], $size[1], $newDirectory, "{$size[0]}x{$size[1]}_".$newFileName, $fileType);
    }
    $imagesArray = ["thumb" => $pathArray["{$sizes[0][0]}x{$sizes[0][1]}"], "images"=> $pathArray, "directory" => $newDirectory];
    return $imagesArray;
}

/**
 * --------------------------------------------------------
 * return array of (resize and crop) uploaded image address
 * --------------------------------------------------------
 */
function fitArrayUploadedImage($file, $sizes, $newDirectory, $newFileName = null)
{
    $newFileName = empty($newFileName) ? basename($file['name'], "." . pathinfo($file['name'] ,PATHINFO_EXTENSION)) : $newFileName ;
    $fitUploadedArray = fitArrayImage($file['tmp_name'], $sizes, $newDirectory, $newFileName, explode('/', $file['type'])[1]);
    $mainImage = uploadFile($file, $newDirectory, "main");
    $fitUploadedArray['images']['main'] = $mainImage;
    return $fitUploadedArray;
}

/**
 * -----------------------------------------------
 * return (resize and crop) uploaded image address
 * -----------------------------------------------
 */
function fitUploadedImage($file, $width, $height, $newDirectory, $newFileName = null)
{
    $newFileName = empty($newFileName) ? basename($file['name'], "." . pathinfo($file['name'] ,PATHINFO_EXTENSION)) : $newFileName ;
    return fitImage($file['tmp_name'], $width, $height, $newDirectory, $newFileName, explode('/', $file['type'])[1]);
}


/**
 * --------------------------------------------------------------------------
 * php delete function that delete a directory with include files recursively
 * --------------------------------------------------------------------------
 */
function delete_directory($directory) {
    if (is_dir($directory))
        $dir_handle = opendir($directory);
    if (!$dir_handle)
        return false;
    while($file = readdir($dir_handle)) {
        if ($file != "." && $file != "..") {
            if (!is_dir($directory."/".$file))
                unlink($directory."/".$file);
            else
                delete_directory($directory.'/'.$file);
        }
    }
    closedir($dir_handle);
    rmdir($directory);
    return true;
}

