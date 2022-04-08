<?php

/**
 * Custom Helper class
 * @author Bobur Nuridinov <bobnuridinov@gmail.com> 
 */

namespace App\Helpers;

use Image;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Helper
{
    const INSTRUCTIONS_PATH = 'instructions';
    const PRODUCTS_PATH = 'img/products';
    const RESEARCHES_PATH = 'img/researches';
    const SLIDES_PATH = 'img/slides';

    /**
     * remove tags, replace many spaces by one, remove first whitespace
     * cut string if length givven
     * and return clean text
     * used while sharing in socials/messangers
     * 
     * @param string $string
     * @param integer $length
     * @return string
     */
    public static function cleanText($string, $length = null)
    {
        $cleaned = preg_replace('#<[^>]+>#', ' ', $string); //remove tags
        $cleaned = str_replace('&nbsp;', ' ', $cleaned); //decode space
        if($length) {
            $cleaned = mb_strlen($cleaned) < $length ? $cleaned : mb_substr($cleaned, 0, ($length - 4)) . '...'; //cut length
        }
        $cleaned = preg_replace('!\s+!', ' ', $cleaned); //many spaces into one
        $cleaned = trim($cleaned); //remove whitespaces

        return $cleaned;
    }

    /**
     * remove tags, slice body, replace many spaces by one, remove first whitespace
     * and return clean text
     * used while sharing in socials/messangers
     * 
     * @param string $string
     * @return string
     */
    public static function cleanShareText($string)
    {
        $cleaned = preg_replace('#<[^>]+>#', ' ', $string); //remove tags
        $cleaned = str_replace('&nbsp;', ' ', $cleaned); //decode space
        $cleaned = mb_strlen($cleaned) < 170 ? $cleaned : mb_substr($cleaned, 0, 166) . '...'; //cut length
        $cleaned = preg_replace('!\s+!', ' ', $cleaned); //many spaces into one
        $cleaned = trim($cleaned); //remove whitespaces

        return $cleaned;
    }

    /**
     * Return transliterated lowercased string from russian or tajik into latin
     *
     * @param string $string
     * @return string
     */
    public static function transliterateIntoLatin($string)
    {
        $cyrilic = [
            'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п',
            'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я',
            'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П',
            'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', ' ',
            'ӣ', 'ӯ', 'ҳ', 'қ', 'ҷ', 'ғ', 'Ғ', 'Ӣ', 'Ӯ', 'Ҳ', 'Қ', 'Ҷ',
            '/', '\\', '|', '!', '?', '«', '»', '“', '”'
        ];

        $latin = [
            'a', 'b', 'v', 'g', 'd', 'e', 'io', 'zh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p',
            'r', 's', 't', 'u', 'f', 'h', 'ts', 'ch', 'sh', 'shb', 'a', 'i', 'y', 'e', 'yu', 'ya',
            'a', 'b', 'v', 'g', 'd', 'e', 'io', 'zh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p',
            'r', 's', 't', 'u', 'f', 'h', 'ts', 'ch', 'sh', 'shb', 'a', 'i', 'y', 'e', 'yu', 'ya', '-',
            'i', 'u', 'h', 'q', 'j', 'g', 'g', 'i', 'u', 'h', 'q', 'j',
            '', '', '', '', '', '', '', '', ''
        ];

        $transilation = str_replace($cyrilic, $latin, $string);

        return strtolower($transilation);
    }

    /**
     * Upload file and resize it
     * 
     * Resizing (Only Images) works only if width or height is given
     * Image will be croped from the center, If both width and height are given (fit)
     * Else if one of the parameters is given (width or height), another will be calculated auto (aspectRatio)
     *
     * @param \Http\Request $request
     * @param \Eloquent\Model\ $item
     * @param string $field Column name of Model
     * @param string $name Name for newly creating file
     * @param string $path Path to store
     * @param integer $width Width for resize
     * @param integer $height Height for resize
     * 
     * @return void
     */
    public static function uploadFiles($request, $item, $field, $name, $path, $width = null, $height = null)
    {
        // Any file input is nullable on item update
        $file = $request->file($field);
        if ($file) {
            $filename = $name . '.' . $file->getClientOriginalExtension();
            $filename = Helper::renameIfFileExists($path, $filename);

            $publicPath = public_path($path);

            $file->move($publicPath, $filename);
            $item[$field] = $filename;

            //resize image
            if($width || $height) {
                $image = Image::make($publicPath . '/' . $filename);
                
                if($width && $height) {
                    $image->fit($width, $height, function ($constraint) {
                        $constraint->upsize();
                    }, 'center');
                    
                } else {
                    $image->resize($width, $height, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }

                $image->save($publicPath . '/' . $filename);
            }
        }
    }

    /**
     * Make thumb from original and store it in thumbs folder
     * Image will be croped from the center, If both width and height are given (fit)
     * Else if one of the parameters is given (width or height), another will be calculated auto (aspectRatio)
     * Thumbs will be saved in originalPath/thumbs folder
     * 
     * Warnign
     * To escape errors, thumbs folder must exists in original path
     *
     * @param string $path Path of original image
     * @param string $filename Name of original image 
     * @param integer $width Width of thumb in pixels
     * @param integer $height Height of thumb in pixels
     * @return void
     */
    public static function createThumbs($path, $filename, $width = 400, $height = null)
    {
        $publicPath = public_path($path);
        $thumb = Image::make($publicPath . '/' . $filename);
        
        if($width && $height) {
            $thumb->fit($width, $height, function ($constraint) {
                $constraint->upsize();
            }, 'center');
            
        } else {
            $thumb->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            });
        }

        $thumb->save($publicPath . '/thumbs//' . $filename);

        return true;
    }

    /**
     * Fill item fields. Used while storing & updating item
     * 
     * @param \Http\Request $request
     * @param \Eloquent\Model $item
     * @param array $fields
     * @return void
     */
    public static function fillFields($request, $item, $fields)
    {
        foreach ($fields as $field) {
            $item[$field] = $request[$field];
        }
    }

    /**
     * Rename file if file with the given name is already exists on the given folder
     * 
     * @param string $path
     * @param string $filename
     * @return string
     */
    public static function renameIfFileExists($path, $filename)
    {
        $name = pathinfo($filename, PATHINFO_FILENAME);
        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        $publicPath = public_path($path) . '/';

        while(file_exists($publicPath . $filename)) {
            $name = $name . '(1)'; 
            $filename = $name . '.' . $extension;
        }

        return $filename;
    }

    /**
     * Get previous route name
     *
     * @return string Route name
     */
    public static function previousRoute()
    {
        $previousRequest = app('request')->create(app('url')->previous());

        try {
            $routeName = app('router')->getRoutes()->match($previousRequest)->getName();
        } catch (NotFoundHttpException $exception) {
            return null;
        }

        return $routeName;
    }
}
