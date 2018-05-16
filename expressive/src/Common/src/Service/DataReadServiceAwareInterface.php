<?php

declare(strict_types=1);

namespace Common\StaticPages\Service;


interface DataReadServiceAwareInterface
{
    public function getAll();
    public function getItem();
    public function getItems();
}