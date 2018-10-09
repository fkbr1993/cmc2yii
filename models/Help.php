<?php
/**
 * Created by PhpStorm.
 * User: dn
 * Date: 03.10.18
 * Time: 6:10
 */

namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class Help extends Model
{
    /**
     * @param $string
     * @return string
     */
    public static function cleanData($string)
    {
        $string = str_replace("'", "", $string);
        $string = str_replace("\"", "", $string);
        $string = strip_tags($string);
        $string = htmlspecialchars($string);
        $string = addslashes($string);

        $quotes = array ("\x27", "\x22", "\x60", "\t", "\n", "\r", "*", "%", "<", ">", "?", "!" , "«", "»", ";");
        $string = str_replace( $quotes, '', $string );

        return $string;
    }

    public static function saveDb($marketCapArray)
    {
        $newArray = [];
        foreach ($marketCapArray as $item){
            foreach ($item['data'] as $i) {
                $newArray[] = $i;
            }
        }
        //var_dump($newArray);die;

        $array = ArrayHelper::map($newArray, 'symbol', 'quotes');
        var_dump($array);die;
    }
}