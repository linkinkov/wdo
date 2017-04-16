<?php
// Application classes defined in _global.php
require_once("_global.php");

foreach ( $distribute_classes as $className )
{
	require_once(sprintf(PD.'/lib/%s.class.php',$className));
}
?>