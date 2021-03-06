<?php

namespace REW\Core;

use REW\Core\Interfaces\RouteInterface;

class Route implements RouteInterface
{

    /**
     * @var string
     */
    protected $path;

    /**
     * @param string $path
     */
    public function __construct($path)
    {
        $this->path = trim($path, '/');
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }
}
