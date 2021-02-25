<?php
/**
 * @author <a href="mailto:bagus.seno39@gmail.com>seno</a>
 * Created on 25/02/21
 * Project evermos-service
 */

namespace App\Utilities;

/**
 * Class StringHelper
 * @package App\Utilities
 */
class StringHelper
{

    /**
     * Convert string to UTF-8
     *
     * @param string $string
     * @return string
     */
    public static function convertToUtf8(string $string): string
    {
        return mb_convert_encoding($string, 'UTF-8');
    }

    /**
     * Format number to IDR format
     * @param double $str
     * @return string
     */
    public static function formatNumber(float $str): string
    {
        return number_format($str, 2, '.', ',');
    }

    /**
     * Clean string from tab and newline.
     * @param  string $string
     * @return string
     */
    public static function cleanString($string): string
    {
        $string = preg_replace('/[\t]+/', ' ', $string);
        $string = preg_replace('/\r\n|\r|\n/', '\n', $string);

        return $string;
    }

    /**
     * @param $string
     * @return bool
     */
    public static function isJSON($string): bool
    {
        return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE);
    }

    /**
     * @param $strSource
     * @param $strFind
     * @return bool
     */
    public static function contains($strSource, $strFind): bool
    {
        if (empty($strSource) || empty($strFind)) {
            return false;
        }

        if (strpos($strSource, $strFind) !== false) {
            return true;
        } else { return false; }
    }

    /**
     * @param $string
     * @return string|null
     */
    public static function checkIsset(&$string) {
        return isset($string) ? strip_tags(self::convertToUtf8($string)) : null;
    }

}