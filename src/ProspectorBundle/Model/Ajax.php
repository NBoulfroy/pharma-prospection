<?php

namespace ProspectorBundle\Model;

class Ajax
{
    public static function JSONResponse($status, $data)
    {
        return json_encode(array(
            'status' => $status,
            'data' => $data
        ));
    }
}
