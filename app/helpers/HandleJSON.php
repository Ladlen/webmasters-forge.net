<?php

class HandleJSON
{
    public static function prepareRequest($arr)
    {
        array_walk_recursive($arr, function(&$item) {
           if(is_string($item))
           {
               $item = mb_convert_encoding($item, 'UTF-8', DOCUMENT_ENCODING);
           }
        });

        return json_encode($arr);
    }
}

