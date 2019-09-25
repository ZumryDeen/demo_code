<?php
class CropRatio {
	
	private $totalWeight;
	private $crops = [ ];
	
	public function add(string $name, int $cropWeight): void {
		
		$currentCropWeight = 0;
		if (! array_key_exists ( $name, $this->crops )) {
			
			$this->crops [$name] = $currentCropWeight;
		} else {
			
			$currentCropWeight = $this->crops [$name];
		}
	//	echo "<br> ".$currentCropWeight."+".$cropWeight;
		$currentCropWeight += $cropWeight;
		//echo "<br> ".$name."-".$currentCropWeight;
		
		$this->crops [$name] = $currentCropWeight;
		
		$this->totalWeight = array_sum ( $this->crops );
	
	}
	
	public function proportion(string $name): float {
		
		//echo "<br> $name".$this->crops [$name]."totalWeight".$this->totalWeight;
		return $this->crops [$name] / $this->totalWeight;
	}
	
}

$cropRatio = new CropRatio ();
$cropRatio->add ( 'Wheat', 4 );
$cropRatio->add ( 'Wheat', 5 );

$cropRatio->add ( 'Rice', 1 );

echo "<br>Wheat: " . $cropRatio->proportion ( 'Wheat' );


// result Wheat: 0.9
