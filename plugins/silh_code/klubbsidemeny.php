    <?php
/**
 * Description: Kode for SIL Håndball. 
 * Author: Otto Paulsen
 * 
 * Version: 0.1.0
 */

/* Place custom code below this line. */


   

add_shortcode( 'klubbsidemeny', 'klubbsidemeny_func' );
function klubbsidemeny_func($atts){

    extract(shortcode_atts(array('foreldreside' => '0'), $atts));
    extract(shortcode_atts(array('spalte' => '1'), $atts));

    $args = array (
                'hierarchical' => 0,
                'sort_column' => 'post_title',
                'sort_order' => 'asc',
                'parent' => $foreldreside
            );
    $pages = get_pages($args);

    // Sorter basert på custom field sortering
    $sort_arr = array();
    foreach ( $pages as $page ) {
    	$sortering = get_post_meta( $page->ID, 'sortering', true );
    	if (empty($sortering)){
    		$sortering = 50;
    	}
    	array_push($sort_arr, $sortering);
    }
    array_multisort($sort_arr, SORT_NATURAL, $pages);    


    $res = '';
    $pagecount = 0;
    foreach ( $pages as $page ) {
    	$pagecount += 1;
        $beskrivelse = get_post_meta( $page->ID, 'beskrivelse', true );
        $visispalte = get_post_meta( $page->ID, 'spalte', true );
        $title = $page->post_title;
        $bilde = get_the_post_thumbnail($page->ID, 'thumbnail');
        $url = get_permalink($page->ID);

        if (empty($visispalte)){
        	$visispalte = $pagecount % 2 + 1;
        }

        if($visispalte == $spalte) {
            $res .= '<div class="klubbsidemeny" onclick="window.location=	\'' . $url . '\';">';
            $res .= '<table><tr>';
            $res .= '<td width="30%">' . $bilde . '</td>';
            $res .= '<td><h3>' . $title . '</h3>';
            $res .= '<p>' . $beskrivelse . '</p></td>';
            //$res .= '<a class="klubbsidemenya" href="' . $url . '"><span class="klubbsidemeny">' . $title . '</span></a>';
            $res .= '</tr></table>';
            $res .= '</div>';
        }
    }
    $res .= '';

    return $res;
}

/* Place custom code above this line. */
?>