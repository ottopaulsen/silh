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


function leggInnLink($side_id, $gruppe, $tekst, $url, $egetvindu){
    
    $linksTekst = get_post_meta($side_id, 'linker_' . $gruppe, true);

    if($linksTekst){
    	$linksArr = json_decode($linksTekst, true);
    }

    $linksArr[] = array('tekst'=>$tekst, 'url'=>$url, 'egetvindu'=>($egetvindu == 'Nytt vindu'));

    update_post_meta($side_id, 'linker_' . $gruppe, json_encode($linksArr));
}

function fjernLink ($side_id, $link_nr){

}

   
function byggLinker($linksTekst){

    update_post_meta($side_id, 'Otto byggLinker input', $linksTekst);

    if($linksTekst){
    	$linksArr = json_decode($linksTekst, true);
    }
    
    $res = '';
    foreach($linksArr as $linkItem){
        $res .= '<div class="linker_vertikalt"><a href="' .
                $linkItem['url'] . 
                '"' . 
                ($linkItem['egetvindu'] ? ' target="_blank">' : '>') . 
                $linkItem['tekst'];
    }

    return $res;
}



add_shortcode( 'linker', 'linker_func' );
function linker_func($atts){
    $res = '';

    extract(shortcode_atts(array('gruppe' => '1'), $atts));

    $linker = get_post_meta( get_the_ID(), 'linker_' . $gruppe, true );

    if (empty($linker)){
        if(silhUserCanEdit()) {
            $res .= '<a href="/legg-inn-link?side_id=' . get_the_ID() . '&gruppe=' . $gruppe . '">Legg inn link</a>';
        }
    } else {
        // Tekst funnet
        if(silhUserCanEdit()) {
            $res .= '<br/><p align="right"><a href="/legg-inn-link?side_id=' . get_the_ID() . '&gruppe=' . $gruppe . '">Legg til link</a></p>';
        }
        $res .= byggLinker($linker);
    }

    return $res;
}



/* Place custom code above this line. */
?>