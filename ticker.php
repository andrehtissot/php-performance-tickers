<?php
class Ticker {
	protected $lastTick;
	protected $lastCurrentMemory;
	protected $loopTotal;
	function __construct($start = false, $loopTotal = 1){
		if($start) { $this->startMemory(); $this->startTick(); }
		$this->loopTotal = $loopTotal;
	}
	function startTick(){
		$this->lastTick = microtime(true);
	}
	function startMemory(){
		$this->lastCurrentMemory = memory_get_usage();
	}
	function echoTick($messageBefore, $messageAfter = "\n", $decimals = 2, $dec_point = '.'){
		echo $messageBefore . $this->diffTickVerbose($decimals, $dec_point) . $messageAfter;
		$this->lastTick = microtime(true);
	}
	function echoMemory($messageBefore, $messageAfter = "\n", $decimals = 2, $dec_point = '.'){
		echo $messageBefore . $this->diffMemoryVerbose($decimals, $dec_point) . $messageAfter;
		$this->lastCurrentMemory = memory_get_usage();
	}
	function diffTick(){
		return (microtime(true) - $this->lastTick);
	}
	function diffTickVerbose($decimals = 2, $dec_point = '.'){
		return number_format($this->diffTick()/60, $decimals, $dec_point, '').' min.';
	}
	function diffMemory(){
		return (memory_get_usage() - $this->lastCurrentMemory);
	}
	function diffMemoryVerbose($decimals = 2, $dec_point = '.'){
		return number_format($this->diffMemory()/1048576,$decimals, $dec_point, '').'MB';
	}
	function setLoopTotal($total){
		$this->loopTotal = $total+1;
	}
	function getLoopRelative($currentLoop){
		return ($currentLoop+1)/$this->loopTotal;
	}
	function getLoopRelativeVerbose($currentLoop, $decimals = 2, $dec_point = '.'){
		return number_format(100*$this->getLoopRelative($currentLoop), $decimals, $dec_point, '').'%';
	}
	function getEstimatedTimeToLastLoopInMinutesVerbose($currentLoop, $decimals = 2, $dec_point = '.'){
		return number_format(((1/$this->getLoopRelative($currentLoop) - 1)*$this->diffTick())/60,
			$decimals, $dec_point, '');
	}
	static function getUsedMemoryPeakVerbose($decimals = 2, $dec_point = '.'){
		return number_format(memory_get_peak_usage()/1048576,$decimals, $dec_point, '').'MB';
	}
	static function echoUsedMemoryPeakVerbose($messageBefore, $messageAfter = "\n"){
		echo $messageBefore . self::getUsedMemoryPeakVerbose() . $messageAfter;
	}
}
