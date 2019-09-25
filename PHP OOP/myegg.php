<?php

interface Bird
{
	public function layEgg() : Egg;
}

class Chicken implements Bird
{
	
	public function layEgg() : Egg {
		
		return new Egg("Chicken");
	}
	
}

class Duck implements Bird
{
	
	
	public function layEgg() : Egg {
		
		return new Egg("Duck");
	}
	
}

class Egg
{
	static $hatched;
	static $birdType;
	
	public function __construct(string $birdType)
	{
		echo "<br> Chicken Created ";
		self::$hatched = false;
		self::$birdType = $birdType;
	}
	
	public function hatch() : ? Bird
	{
		if(!self::$hatched){
			self::$hatched=true;
			$Bridclass= self::$birdType;
			echo "<br> 1s time Hatched a an egg of ".$Bridclass." Type";
			return new $Bridclass();
		} else {
			echo "Egg is already hatched";
			throw new Exception("Egg is already hatched" );
		}
		
	}
}

$chickenObj = new Chicken();
$egg = $chickenObj->layEgg();
$egg->hatch();

// $egg->hatch();

$duckObj = new Duck();
$egg = $duckObj->layEgg();
$egg->hatch();

// $egg->hatch();
//echo get_class ($egg->hatch());


