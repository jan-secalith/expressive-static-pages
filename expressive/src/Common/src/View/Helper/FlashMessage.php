<?php

declare(strict_types=1);

namespace Common\View\Helper;

use Zend\View\Helper\AbstractHelper;

class FlashMessage extends AbstractHelper
{
    public function __invoke($messages=null,$type=null)
    {
        $output = null;
        if( $messages !== null ) {

            switch ($type){
                case 'error':
                    $output .= "<ul class='alert alert-warning'>";
                    foreach($messages as $message) {
                        $output .= $this->getView()->plugin('partial')('common::flash-message',['message'=>$message]);
                    }
                    $output .= "</ul>";

                    $output .= "<hr />";

                    break;
                default:
                case 'info':
                    $output .= "<ul class='alert alert-info'>";
                    foreach($messages as $message) {
                        $output .= $this->getView()->plugin('partial')('common::flash-message',['message'=>$message]);
                    }
                    $output .= "</ul>";

                    $output .= "<hr />";

                break;
            }

        }

        return $output;

    }
}
