<?php

class Roller{

    public function rollD5($rollMod = 0)
    {
        return $this->rollDice(5, $rollMod);
    }

    public function rollD6($rollMod = 0)
    {
        return $this->rollDice(6, $rollMod);
    }

    public function rollD8($rollMod = 0)
    {
        return $this->rollDice(8, $rollMod);
    }

    public function rollD10($rollMod = 0)
    {
        return $this->rollDice(10, $rollMod);
    }


    public function rollD12($rollMod = 0)
    {
        return $this->rollDice(12, $rollMod);
    }

    public function rollD20($rollMod = 0)
    {
        return $this->rollDice(20, $rollMod);
    }


    public function rollD100($rollMod = 0)
    {
        return $this->rollDice(100, $rollMod);
    }

    public function rollDice($sidesCount, $rollMod = 0, $diceCount = 1,$rollsCount = 1)
    {
        mt_srand();
        $result = array();
        for ($i = 1; $i <= $rollsCount; $i++) {
            $diceResult = 0;
            for ($j = 1; $j <= $diceCount; $j++) {

                $res = mt_rand(1, $sidesCount);
                $diceResult += $res;

            }
            $diceResult += $rollMod;
            $result[]    = $diceResult;
        }
        return $result;
    }

    public function rollFromString($str){

        $data = array();
        $pattern = "#\d+d\d+\s?([+\-]\d+)?\s?(discard\s\d+\s(low|high)est)?#i";
        if(!preg_match($pattern, $str, $data))
            throw new Exception("Чет немогу разобрать, что вы тут понаписали!" );


        preg_match('#(\d+)d(\d+)\s?([+\-]\d+)?#', $str, $data);

        $diceCount = (int) $data[1];
        $sidesCount = (int) $data[2];

        if(isset($data[3]))
            $rollMod = (int) $data[3];
        else
            $rollMod = 0;
        if($diceCount > 100)
            throw new Exception("Чет дофига кубиков, скромнее быть надо!" );

        if($sidesCount > 100)
            throw new Exception("Чет жирные кубики, скромнее быть надо!" );

        if(abs($rollMod) > 100)
            throw new Exception("Чет жирный модификатор, скромнее быть надо!" );

        $res = $this->rollDice($sidesCount, $rollMod, $diceCount);

        return array_sum($res);
    }//public function rollFromString(){

}
