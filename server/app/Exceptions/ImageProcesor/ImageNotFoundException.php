<?php

namespace App\Exceptions\ImageProcesor;

use Exception;

class ImageNotFoundException extends ImageProcesorException {
    public function __construct($message='', $code=404, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}