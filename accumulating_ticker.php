<?php
class AccumulatingTicker {
	protected $maxIncrements;
	protected $incrementsCount = 0;
	protected $lastTick;
	protected $accumulatedTick = 0;
	protected $lastCurrentMemory;
	protected $accumulatedMemory = 0;
	function __construct($maxIncrements = -1){
		$this->maxIncrements = $maxIncrements;
	}
	function start(){
		$this->startTick();
		$this->startMemory();
	}
	function startTick(){
		$this->lastTick = microtime(true);
	}
	function startMemory(){
		$this->lastCurrentMemory = memory_get_usage();
	}
	function accumulate(){
		$this->accumulateTick();
		$this->accumulateMemory();
		$this->incrementsCount--;
	}
	function accumulateTick(){
		$this->accumulatedTick += $this->diffTick();
		$this->incrementsCount++;
	}
	function accumulateMemory(){
		$this->accumulatedMemory += $this->diffMemory();
		$this->incrementsCount++;
	}
	function echoTick($messageBefore, $messageAfter = "\n", $decimals = 2, $dec_point = '.'){
		echo $messageBefore . $this->getTickVerbose($decimals, $dec_point) . $messageAfter;
	}
	function echoMemory($messageBefore, $messageAfter = "\n", $decimals = 2, $dec_point = '.'){
		echo $messageBefore . $this->getMemoryVerbose($decimals, $dec_point) . $messageAfter;
	}
	function getTickVerbose($decimals = 2, $dec_point = '.'){
		return number_format($this->accumulatedTick/60, $decimals, $dec_point, '').' min.';
	}
	function getMemoryVerbose($decimals = 2, $dec_point = '.'){
		return number_format($this->accumulatedMemory/1048576,$decimals, $dec_point, '').'MB';
	}
	function accumulateAndShowResultsIfMaxIncrements(){
		$this->accumulateTick();
		$this->accumulateMemoryAndShowResultsIfMaxIncrements();
		$this->incrementsCount--;
	}
	function accumulateTickAndShowResultsIfMaxIncrements(){
		$this->accumulateTick();
		$this->showResultsIfMaxIncrements();
	}
	function accumulateMemoryAndShowResultsIfMaxIncrements(){
		$this->accumulateMemory();
		$this->showResultsIfMaxIncrements();
	}
	function showResultsIfMaxIncrements(){
		if($this->incrementsCount < $this->maxIncrements) { return; }
		$this->echoTick('Time: ',"\n");
		exit($this->echoMemory('RAM: ',"\n"));
	}
	protected function diffTick(){
		return (microtime(true) - $this->lastTick);
	}
	protected function diffMemory(){
		return (memory_get_usage() - $this->lastCurrentMemory);
	}
}
