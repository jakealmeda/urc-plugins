 <?php

if( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$v = new URCVideoMainFunction();
echo $v->urcv_main( $block );
// EOF