<?php
/**
 * Description: Kode for SIL Håndball. 
 * Author: Otto Paulsen
 * 
 * Version: 0.1.0
 */

/* Place custom code below this line. */


/* Ide: Legg linker i en variabel på siden. Les denne inn i form.
   Kan form kalle php? Kortkode?


*/


   
add_shortcode( 'linker', 'linker_func' );
function linker_func($atts){
    $res = '';

    extract(shortcode_atts(array('gruppe' => '1'), $atts));

    return $res;

}

/* Place custom code above this line. */
?>