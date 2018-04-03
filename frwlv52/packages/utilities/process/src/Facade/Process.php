<?php
namespace Utilities\Process\Facade;
 
use Illuminate\Support\Facades\Facade;
 
class Process extends Facade
{
	protected static function getFacadeAccessor() { return 'process'; }
}