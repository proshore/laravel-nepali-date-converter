<?php

namespace Proshore\NepaliDate\Dto;

class FormattedDate
{
    /**
     * @var string
     */
    public string $d;
    /**
     * @var string
     */
    public string $y;
    /**
     * @var string
     */
    public string $m;
    /**
     * @var string
     */
    public string $M;
    /**
     * @var string
     */
    public string $D;

    /**
     * @var string
     */
    public string $date;


    /**
     * @param array<string,mixed> $data
     * @return $this
     */
    public function get(array $data): static
    {
        $this->d = $data['d'];
        $this->y = $data['y'];
        $this->m = $data['m'];
        $this->M = $data['M'];
        $this->D = $data['D'];
        $this->date = $data['y'] . " " . $data['M'] . " " . $data['d'] . " " . $data['D'];

        return $this;
    }
}
