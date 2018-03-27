<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 12/03/18
 * Time: 9:57 PM
 */

include_once __dir__.'/SolsticeDistribution.php';
echo __dir__."/../Random.php\n";
include_once __dir__.'/../Random.php';





class SolsticeDistributionTest extends PHPUnit_Framework_TestCase
{


    public function testValueOf(){
        $base = 1/20;
        $upper = 0.05;
        $pop = 1500;
        $solDist = new SolsticeDistribution($base, $upper, $pop);

        try{

            $solDist->valueForDay(0);
        }catch (InvalidArgumentException $e){
            self::assertTrue(true);
        }

        $min = 1*($base)*$pop;
        $max = 2.001*($base + $upper)*$pop;

        //echo $min."\n";
        //echo $max."\n\n";

        $minObserved = 1000;
        $maxObserved = 0;
        //Gross test, but we are dealing with probability
        for($i = 1; $i < 1000; $i++){
            $v = $solDist->valueForDay(355);
            if($v <$minObserved){
                $minObserved = $v;
            }elseif($v > $maxObserved){
                $maxObserved = $v;
            }
        }

        self::assertTrue($min <= $minObserved);
        self::assertTrue($max >= $maxObserved);
        //echo "Min:\t".$minObserved."\tMax:\t".$maxObserved."\n";
    }

    function testSolsticeDistribution(){
        $min = 1;
        $max = 2.000001;

        $minObserved = 20;
        $maxObserved = 0;
        for($i = 1; $i < 365; $i++){
            $v = SolsticeDistribution::solsticeDistribution($i);
            if($v <$minObserved){
                $minObserved = $v;
            }elseif($v > $maxObserved){
                $maxObserved = $v;
            }
        }

        //echo "Min:\t".$minObserved."\tMax:\t".$maxObserved."\n";

        self::assertTrue($min <= $minObserved);
        self::assertTrue($max >= $maxObserved);

        $tollerance = 0.00001;
        self::assertTrue(abs($maxObserved - SolsticeDistribution::solsticeDistribution(355)) < $tollerance);
        self::assertTrue(abs($maxObserved - SolsticeDistribution::solsticeDistribution(172)) < $tollerance);

    }
}


?>
