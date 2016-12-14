# php-performance-tickers
Little PHP classes to test performace.
<br />
##SimpleTicker
Useful to test how code performs.

####Can be used like:
```
$ticker = new SimpleTicker();
$ticker->startTick();
//Do whatever it's needed
echo "Took ".$ticker->diffTick()." seconds!";
```
####Or just:
```
$ticker = new SimpleTicker(true);
//Do whatever it's needed
$ticker->echoTick("Took ");
```
<br />
##Ticker
Like SimpleTicker, but extended to handle memory and track progress within loops nicely.

####Simple use for time and memory:
```
$ticker = new Ticker(true);
//Do whatever it's needed
$ticker->echoTick("Took ");
$ticker->echoMemory("Used ");
```

####Within loops
```
$ticker = new Ticker(true, 100);
for($i = 0; $i < 100; $i++){
  //Do whatever it's needed
  echo 'Ran '.$ticker->getLoopRelativeVerbose($i).' already.';
  echo "It'll probably take ".$ticker->getEstimatedTimeToLastLoopInMinutesVerbose($i).' minutes to end loops.';
}
$ticker->echoTick("In total took ");
$ticker->echoMemory("In total used ");
```
<br />
##AccumulatingTicker
Like Ticker, but specialized to work within loops.
Because some problems somethings only show up at the nth loop.

####Test how long a piece of code performs inside loops, stopping at the 20th loop:
```
$ticker = new AccumulatingTicker(20);
for($i = 0; $i < 100; $i++){
  //Uninteresting code
  $ticker->start();
  //Do whatever it's needed
  $ticker->accumulateAndShowResultsIfMaxIncrements();
  //Uninteresting code
};
```
