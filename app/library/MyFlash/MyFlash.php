<?php
namespace Gutshot\MyFlash;

use Phalcon\Flash\Direct as Flash;

/**
 * Gutshot\MyFlash\MyFlash
 */
class MyFlash extends Flash
{
    /**
     *
     * @return string
     */
    public function message($type, $message)
    {
        if (is_array($message)) {
            foreach ($message as $key => $value) {
                $message[$key] .= ' <a class="close" data-dismiss="alert" href="#">&times;</a>';
            }
        } else
            $message .= ' <a class="close" data-dismiss="alert" href="#">&times;</a>';
        parent::message($type, $message);
    }
}
