<?php

namespace Mrgla55\Tabapi\Interfaces;

interface ResourceRepositoryInterface
{
    public function get($resource);
    public function put($resource);
    public function has();
}
