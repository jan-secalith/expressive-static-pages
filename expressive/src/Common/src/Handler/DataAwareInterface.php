<?php

declare(strict_types=1);

namespace Common\Handler;

interface DataAwareInterface
{
    public function setData($data=null) : DataAwareInterface;
    public function getData(string $index=null);
    public function addData($data,string $index) : DataAwareInterface;
}
