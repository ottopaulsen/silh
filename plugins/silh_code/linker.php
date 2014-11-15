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

function fjernLink ($side_id, $gruppe, $link_nr){

}


function byggLinkerH($linksTekst, $em){
    // Horisontal linje med linker (minst mulig plass i bredden)

    if($linksTekst){
        $linksArr = json_decode($linksTekst, true);
    }
    
    $res = '';
    foreach($linksArr as $linkItem){
        $res .= '<span class="linker_h_span" style="font-size:' . $em . 'em">';
        $res .= '<a class="linker linker_h"';
        //$res .= '" style="font-size:' . $em . 'em"';
        $res .= ' href="' . $linkItem['url'] . '"' . ($linkItem['egetvindu'] ? ' target="_blank">' : '>');
        $res .=  $linkItem['tekst'];
        //if(silhUserCanEdit()) $res .= '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp';
        $res .= '</a>';
        if(silhUserCanEdit()){
            $res .= '<span class="link_red_h"><a href="flyttLinkOpp">&#9664;</a>';
            $res .= '<a align="right" href="slettLink">&nbsp;X&nbsp;</a>';
            $res .= '<a align="right" href="flyttLinkNed">&#9654;&nbsp</a></span>';
        }
        $res .= '</span>';
        //  $res .= '&nbsp;&nbsp;';
    }


    return $res;
}   

function byggLinkerV($linksTekst, $em){

    if($linksTekst){
        $linksArr = json_decode($linksTekst, true);
    }
    
    $res = '';
    foreach($linksArr as $linkItem){
        $res .= '<div class="linker linker_v"';
        $res .= ' onclick="window.location=   \'' . $linkItem['url'] . '\';"';
        $res .= ' style="font-size:' . $em . 'em">';
        $res .= '<table><tr>';
        $res .= '<td width="90%">' . '<a class="linker_a" href="' .
                $linkItem['url'] . '"' . 
                ($linkItem['egetvindu'] ? ' target="_blank">' : '>') . 
                $linkItem['tekst'] .  
                '</a></td>';
        if(silhUserCanEdit()){
            $res .= '<td>';
            $res .= '<span class="link_red_v"><a href="flyttLinkOpp">&#9650;</a>';
            $res .= '<a align="right" href="flyttLinkNed">&#9660;</a></span>';
            $res .= '<a align="right" href="slettLink">&nbsp;X&nbsp;</a>';
            $res .= '</td>';
        }
        $res .= '</tr></table>';
        $res .= '</div>';
    }


    return $res;
}



add_shortcode( 'linker', 'linker_func' );
function linker_func($atts){
    $res = '';

    extract(shortcode_atts(array('gruppe' => '1'), $atts));
    extract(shortcode_atts(array('type' => 'v'), $atts));
    extract(shortcode_atts(array('em' => '1.35'), $atts));

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
        //$res .= byggLinker3($linker, (strtolower($type) == 'h' ? 'linker_h' : 'linker_v'), $em);
        $res .= (strtolower($type) == 'h' ? byggLinkerH($linker, $em) : byggLinkerV($linker, $em));
    }

    return $res;
}






function install_linker() 
{

     wp_enqueue_script( 'linker_handle', plugins_url() . '/silh_code/linker.js', array('jquery'), null);
     wp_localize_script( 'linker_handle', 'linker_script', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );

}


add_action('template_redirect', 'install_linker');

add_action("wp_ajax_nopriv_linker_up", "linker_up");
add_action("wp_ajax_linker_up", "linker_up");

function linker_up()
{
    $page_id = $_POST['page_id'];
    $var_name = $_POST['var_name'];
    $default_value = $_POST['default_value'];

    $vis_innhold = get_post_meta( $page_id, $var_name, true );

    if(empty($vis_innhold))
        $vis_innhold = $default_value;

    if(strtolower($vis_innhold) == 'ja')
        $vis_innhold = 'nei';
    else
        $vis_innhold = 'ja';

    update_post_meta($page_id, $var_name, $vis_innhold);

    die();
}


/* Place custom code above this line. */
?>