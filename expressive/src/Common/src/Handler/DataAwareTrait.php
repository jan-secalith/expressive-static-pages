<?php

declare(strict_types=1);

namespace Common\Handler;

trait DataAwareTrait
{
    protected $data = [];

    public function setData($data = [], string $index=null) : DataAwareInterface
    {
        if($index!==null) {
            $this->addData($data,$index);
        } else {
            $this->data = $data;
        }

        return $this;
    }
    public function getData( string $index=null)
    {
        if($index !== null) {
            if(array_key_exists($index,$this->data)) {
                return $this->data[$index];
            }
        }

        return $this->data;
    }
    public function addData($data,string $index) : DataAwareInterface
    {
        $this->data[$index] = $data;

        return $this;
    }
}
