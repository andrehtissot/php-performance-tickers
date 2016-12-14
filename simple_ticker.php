<?php
class SimpleTicker {
	protected $lastTick;
	function __construct($start = false){
		if($start) { $this->startTick(); }
	}
	function startTick(){
		$this->lastTick = microtime(true);
	}
	function echoTick($messageBefore, $messageAfter = "\n", $decimals = 2, $dec_point = '.'){
		echo $messageBefore . $this->diffTickVerbose($decimals, $dec_point) . $messageAfter;
		$this->lastTick = microtime(true);
	}
	function diffTick(){
		return (microtime(true) - $this->lastTick);
	}
	function diffTickVerbose($decimals = 2, $dec_point = '.'){
		return number_format($this->diffTick()/60, $decimals, $dec_point, '').' min.';
	}
}
