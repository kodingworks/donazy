<?php

namespace App\Services;

class UniqueCodeGeneratorService
{
    private $sufix;

    public function __construct(int $sufix = null)
    {
        $this->sufix = $sufix;
    }

    public function generate(): int
    {
        if (is_null($this->sufix)) {
            return (int) str_pad(random_int(0, 999), 3, 0, STR_PAD_LEFT);
        }

        $tmp = [];

        for ($i = 3 - strlen($this->sufix); $i > 0; $i--) {
            $tmp[] = 9;
        }

        $maxInt = (int) implode('', $tmp);

        return (int) str_pad((int) (random_int(0, $maxInt) . $this->sufix), 3, 0, STR_PAD_LEFT);
    }
}
