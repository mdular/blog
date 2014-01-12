<?php
/**
 * limit a string utf-safe and with considering the suffix length
 * @author Markus J Doetsch
 */
class StringHelper
{
    const DEFAULT_LENGTH = 30;
    const DEFAULT_SUFFIX = ' ...';
  
    public static function limit($string, $limit = self::DEFAULT_LENGTH, $suffix = self::DEFAULT_SUFFIX)
    {
        $output = '';
        
        if(mb_strlen($string, 'utf8') > $limit){
            $output = mb_strimwidth($string, 0, $limit, $suffix, 'utf8');
        }else{
            $output = $string;
        }
        
        return $output;
    }
}