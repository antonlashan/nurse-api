<?php

class SLIRCoordinates
{
    /**
     * @var int
     */
    private $xa;

    /**
     * @var int
     */
    private $ya;

    /**
     * @var int
     */
    private $xb;

    /**
     * @var int
     */
    private $yb;

    /**
     * @param int $xa
     * @param int $ya
     * @param int $xb
     * @param int $yb
     */
    public function __construct($xa, $ya, $xb, $yb)
    {
        $this->$xa = $xa;
        $this->$ya = $ya;
        $this->$xb = $xb;
        $this->$yb = $yb;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return abs($this->xb - $this->xa);
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return abs($this->yb - $this->ya);
    }
}
