<?php

/**
 * Util class to handle files easier.
 * 
 * @author Ademir Mazer Jr (Nuno Mazer) - http://ademir.winponta.com.br
 */
class Agana_Util_FileHandle {

    /**
     * Fix the path \ separator to / anb, if last char is not a / put it
     * 
     * @param string $path
     * @param boolean fix last separator char
     * @return string $path
     */
    public static function fixPathSeparator($path, $putLastSeparator = true) {
        $path = strtr($path, '\\', '/');
        if ($putLastSeparator) {
            $last = substr($path, strlen($path) - 1);
            $path .= ($last != '/' && $last != '\\') ? '/' : '';
        }

        return $path;
    }

    /**
     * Generates the md5 from a given file name.
     * 
     * @param mixed string with full file path and name or array with optionals: 'path', 'name', 'extension' indexes. The name should not start with separator \ or /
     * @return string 32 char md5 or false
     */
    public static function genMD5($file) {
        $name = '';

        if (is_array($file)) {
            $name .= (isset($file['path'])) ? self::fixPathSeparator($file['path']) : '';
            $name .= (isset($file['name'])) ? $file['name'] : '';
            $name .= (isset($file['extension'])) ? '.' . $file['extension'] : '';
        } else {
            $name = $file;
        }

        if (file_exists($name)) {
            return md5_file($name);
        } else {
            return false;
        }
    }

    /**
     * Generate a folder name structure based on a name of file passed.
     * If the file name is 123456789, the folder structure for 3 levels, each level (1,2,2) is
     * 1/23/45/
     * 
     * @param string file name
     * @param integer the namber of levels to generate
     * @param array the number of chars to use in each level, an array like arra(1,2,2)
     * @return string the folder structure
     */
    public static function genFolderNameStructure($fileName, $levels, $divisionByLevel) {
        $folder = '';
        $nextpos = 0;
        for ($i = 0; $i < $levels; $i++) {
            $folder.= substr($fileName, $nextpos, $divisionByLevel[$i]) . '/';
            $nextpos += $divisionByLevel[$i];
        }

        return $folder;
    }

    /**
     * Test if the folder is writable, if it does not exist, creates it.
     * 
     * @param String $path
     * @param boolean $create
     * @return boolean 
     */
    public static function isWritableDir($path, $create = true) {
        if (!is_dir($path) && $create) {
            try {
                return mkdir($path, 0766, true);
            } catch (Exception $e) {
                return is_writable($path);
            }
        } else {
            return is_writable($path);
        }
    }

    /**
     * Generates and returns a file name based on a type name passed.
     * Sample: file name is logo.jpg, type name is 'medium', returns logo.medium.jpg
     * Note that the type name is not the MIME type of the file, it's like a classification
     * 
     * @param String $filename
     * @param String $typename 
     */
    public static function genFileNameByClassification($filename, $typename) {
        if (trim($typename) != '') {
            $newfilename = substr($filename, 0, strpos($filename, '.'));
            $newfilename.= '.' . $typename . substr($filename, strpos($filename, '.'));
            return $newfilename;
        } else {
            return $filename;
        }
    }

    public static function getFileNameWithoutExtension($filename) {
        return substr($filename, 0, strpos($filename, '.'));
    }

}