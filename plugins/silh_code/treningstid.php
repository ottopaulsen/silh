    <?php
/**
 * Description: Kode for SIL Håndball. 
 * Author: Otto Paulsen
 * 
 * Version: 0.1.0
 */

/* Place custom code below this line. */


// Vis alle treningstider registrert med Formidable   
add_shortcode( 'LagetsTreningstider', 'lagetsTreningstider_func' );
function lagetsTreningstider_func($atts){
	$lag_id = get_post_meta( get_the_ID(), 'lag_id', true );
	if ( $lag_id ) :
	  $ret = FrmProDisplaysController::get_shortcode(array('id' => 866, 'lag_id' => $lag_id));
	else :
	  $ret = '<h3>Treningstider</h3>';
	  $ret .= 'Denne modulen heter "Treningstider" og kan brukes for å vise lagets treningstider.';
	  $ret .= '<br>Siden mangler det tilpassede feltet "lag_id", som må til for at modulen skal virke.';
	  $ret .= '<br>Kontakt webmaster om du ikke vet hvordan du skal fikse det selv.';
	endif;

	return $ret;
}   

add_shortcode( 'RegistrerTreningstid', 'registrerTreningstid_func' );
function registrerTreningstid_func($atts){
	$lag_id = get_post_meta( get_the_ID(), 'lag_id', true );
	$res = '';

	if ($lag_id) :
	  if (silhUserCanEdit()) :
	    $res = "<a href='/registrering-av-treningstid/?lag=" . $lag_id . "&tilbake=" . $_SERVER['REQUEST_URI'] . "'>Legg inn ny treningstid</a>";
	  endif;
	endif;

	return $res;
}

/* Place custom code above this line. */
?>