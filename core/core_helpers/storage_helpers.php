<?php

/**
 * -------------------------------------------------------------------------------------------------------
 * uploaded file and return uploaded file address in storage
 * -------------------------------------------------------------------------------------------------------
 */
function uploadFileStorage($file, $newDirectory, $newFileName = null)
{
    // prepare new directory
    $newDirectory = "../storage/".trim($newDirectory, "/")."/";
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
 * -------------------------------------------------------------------------------------------------------
 * php delete function that delete a storage directory with include files recursively 
 * -------------------------------------------------------------------------------------------------------
 */
function deleteDirectoryStorage($directory) 
{
	$directory = stripos($directory, "../storage/") === 0 ? $directory : "../storage/".$directory;
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



/**
 * -------------------------------------------------------------------------------------------------------
 * php download function that download a storage file  
 * -------------------------------------------------------------------------------------------------------
 */
function downloadStorageFile($file)
{
	if(file_exists($file)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($file).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        flush(); // Flush system output buffer
        readfile($file);
        die();
    } else {
        http_response_code(404);
        die();
    }
}