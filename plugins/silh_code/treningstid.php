    <?php
/**
 * Description: Kode for SIL Håndball. 
 * Author: Otto Paulsen
 * 
 * Version: 0.1.0
 */

/* Place custom code below this line. */


 

add_shortcode( 'RegistrerTreningstid', 'registrerTreningstid_func' );
function registrerTreningstid_func($atts){
	$lag_id = get_post_meta( get_the_ID(), 'lag_id', true );
	$res = '';

	if ($lag_id) :
	  if (silhUserCanEdit()) :
	    $res = '<p><a class="editlink" href="/registrering-av-treningstid/?lag=' . $lag_id . '&tilbake=' . $_SERVER['REQUEST_URI'] . '">Legg inn ny treningstid</a></p>';
	  endif;
	endif;

	return $res;
}


// Vis alle treningstider registrert med Formidable   
add_shortcode( 'LagetsTreningstider', 'treningstider_func' );
add_shortcode( 'treningstider', 'treningstider_func' );
function treningstider_func($atts){

    global $frm_entry, $frm_entry_meta;

	$lag_id = get_post_meta( get_the_ID(), 'lag_id', true );

    $entries = $frm_entry->getAll("it.form_id=13");

    $dayOrder = array('Mandag'=>1,
    	              'Tirsdag'=>2,
    	              'Onsdag'=>3,
    	              'Torsdag'=>4,
    	              'Fredag'=>5,
    	              'Lørdag'=>6,
    	              'Søndag'=>7);

    $res = '<table class="silhTable">
            <caption style="caption-side:bottom;text-align:left;border:none;background:none;margin:0;padding:0;"></caption>
            <thead>
            <tr>
            <th class="column-1"><div>Dag</div></th>
            <th class="column-2"><div>Sted</div></th>
            <th class="column-3"><div>Tid</div></th>';

    if(!$lag_id) $res .= '<th class="column-4"><div>Lag</div></th>';

    $res .= '</tr></thead><tbody>';

    foreach ( $entries as $entry ) {
        $lag = $frm_entry_meta->get_entry_meta_by_field($entry->id, 125, true);
        if (!$lag_id or $lag == $lag_id) {
	        $dag = $frm_entry_meta->get_entry_meta_by_field($entry->id, 120, true);
	        $sted = $frm_entry_meta->get_entry_meta_by_field($entry->id, 112, true);
	        $tid = $frm_entry_meta->get_entry_meta_by_field($entry->id, 111, true);

	        $sort = $dayOrder[$dag] . $sted . $tid . $lag;
	        $sorter[] = $sort;
	        $tider[] = array('dag' => $dag, 'sted' => $sted, 'tid' => $tid, 'lag' => $lag);
	    }
    }

    array_multisort($tider, SORT_NATURAL, $sorter);

    $odd = true;
    foreach ($tider as $t) {
        $res .= '<tr class="' . ($odd ? 'odd' : 'even') . '"><td>' . 
               $t['dag'] . '</td><td>' . 
               $t['sted'] . '</td><td>' . 
               $t['tid'] . '</td>';
        if(!$lag_id) $res .= '<td>' . $t['lag'] . '</td>';
        $res .= '</tr>';

        $odd = !$odd;
    }


    $res .= '</tbody></table>';
    return $res;
}



/* Place custom code above this line. */
?>