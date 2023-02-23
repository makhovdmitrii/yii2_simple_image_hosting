<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;
use app\models\Uploadedfiles;

class UploadForm extends Model
{
    /**
     * @var UploadedFile[]
     */
    public $imageFiles;
    private $converter = array(
        'а' => 'a',    'б' => 'b',    'в' => 'v',    'г' => 'g',    'д' => 'd',
        'е' => 'e',    'ё' => 'e',    'ж' => 'zh',   'з' => 'z',    'и' => 'i',
        'й' => 'y',    'к' => 'k',    'л' => 'l',    'м' => 'm',    'н' => 'n',
        'о' => 'o',    'п' => 'p',    'р' => 'r',    'с' => 's',    'т' => 't',
        'у' => 'u',    'ф' => 'f',    'х' => 'h',    'ц' => 'c',    'ч' => 'ch',
        'ш' => 'sh',   'щ' => 'sch',  'ь' => '',     'ы' => 'y',    'ъ' => '',
        'э' => 'e',    'ю' => 'yu',   'я' => 'ya',
    );

    public function rules()
    {
        return [
            [['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'maxFiles' => 5],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            foreach ($this->imageFiles as $file) {
                $file->name = mb_strtolower($file->name);
                $file->name = strtr($file->name, $this->converter);
                if (file_exists('uploads/' . $file->baseName . '.' . $file->extension))
                {
                    //Duplication. Making unique filename.
                    $file->name = $file->baseName . date('Y_m_d_H_i_s') . '.' . $file->extension;
                }
                $file->saveAs('uploads/' . $file->baseName . '.' . $file->extension);
                $uploadedFile = new Uploadedfiles();
                $uploadedFile->name = $file->name;
                $uploadedFile->save();
                switch ($file->extension)
                {
                    case 'png':
                        $this::saveMiniImagePNG('uploads/' . $file->baseName . '.' . $file->extension,'minified/' . $file->baseName . '.' . $file->extension);
                        break;
                    case 'jpg':
                    case 'jpeg':
                        $this::saveMiniImageJPEG('uploads/' . $file->baseName . '.' . $file->extension,'minified/' . $file->baseName . '.' . $file->extension);
                        break;
                    default:
                        echo "There is no supported image type";
                        break;
                }
            }
            return true;
        } else {
            return false;
        }
    }
    private static function saveMiniImagePNG($srcFile, $destFile)
    {
        $size = getimagesize($srcFile);
        $im = imagecreatefrompng($srcFile);

        $w = 400;
        $h = $w * $size[1] / $size[0];

        $imf = imagecreatetruecolor($w, $h);
        imagecopyresampled($imf, $im, 0,0,0,0, $w,$h,$size[0],$size[1]);

        imagePng($imf, $destFile);
    }
    private static function saveMiniImageJPEG($srcFile, $destFile)
    {
        $size = getimagesize($srcFile);
        $im = imagecreatefromjpeg($srcFile);

        $w = 400;
        $h = $w * $size[1] / $size[0];

        $imf = imagecreatetruecolor($w, $h);
        imagecopyresampled($imf, $im, 0,0,0,0, $w,$h,$size[0],$size[1]);

        imagejpeg($imf, $destFile);
    }
}