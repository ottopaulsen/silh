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
    extract(shortcode_atts(array('spalte' => '0'), $atts));
<<<<<<< HEAD
=======
    extract(shortcode_atts(array('sider' => ''), $atts));
>>>>>>> 1867f176e3a1eb64f223769f7d7719be39def0b4

    $pages = array();

    if($foreldreside){
        $args1 = array (
                    'hierarchical' => 0,
                    'sort_column' => 'post_title',
                    'sort_order' => 'asc',
                    'parent' => $foreldreside
                );
        $pages = get_pages($args1);
    }

    // Legg til sider angitt spesielt med argument "sider"
    $pages2 = array();
    if($sider){
        $args2 = array (
                'hierarchical' => 0,
                'sort_column' => 'post_title',
                'sort_order' => 'asc',
                'include' => $sider
            );
        $pages2 = get_pages($args2);
    }

    $pages = array_merge($pages, $pages2);


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
        $direktelink = get_post_meta( $page->ID, 'direktelink', true );
        $title = $page->post_title;
        $bilde = get_the_post_thumbnail($page->ID, 'thumbnail');

<<<<<<< HEAD
        if($direktelink)
            $url = $direktelink;
        else
=======
        if($direktelink) 
            $url = $direktelink;
        else 
>>>>>>> 1867f176e3a1eb64f223769f7d7719be39def0b4
            $url = get_permalink($page->ID);

        if (empty($visispalte)){
        	$visispalte = $pagecount % 2 + 1;
        }

<<<<<<< HEAD
        if(!$bilde) $bilde = '<img width="150" height="150" src="/wp-content/uploads/2014/03/Strindheim_Idrettslag_logo.png" class="attachment-thumbnail wp-post-image" alt="Menybilde" />';


        if($visispalte == $spalte || $spalte == 0) {
            $res .= '<div class="klubbsidemeny" onclick="window.location=	\'' . $url . '\';"';
            if($direktelink) $res .= ' formtarget="_blank"'; // Dette funker ikke...
            $res .= '>';
=======
        if(!$bilde){
            $bilde = '<img width="150" height="150" src="/wp-content/uploads/2014/03/Strindheim_Idrettslag_logo.png" class="attachment-thumbnail wp-post-image" alt="Strindheim Håndball">';
        }

        if($visispalte == $spalte || $spalte == 0) {
            $res .= '<div class="klubbsidemeny" onclick="window.location=	\'' . $url . '\';">';
>>>>>>> 1867f176e3a1eb64f223769f7d7719be39def0b4
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