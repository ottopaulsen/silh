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
    extract(shortcode_atts(array('sider' => ''), $atts));
    extract(shortcode_atts(array('beskrivelse' => 'ja'), $atts));
    extract(shortcode_atts(array('bilde' => 'ja'), $atts));
    extract(shortcode_atts(array('picsize' => '100'), $atts));
    extract(shortcode_atts(array('picwidth' => '25'), $atts));
    extract(shortcode_atts(array('visurlmeny' => 'ja'), $atts));
    extract(shortcode_atts(array('h' => '3'), $atts));

    $meny = $_GET['meny'];


    $visBilde = ($bilde === 'ja');

    $auto = ($foreldreside == 'auto');

    $pageId = get_the_ID();
       

    $undersidemeny = get_post_meta( $pageId, 'undersidemeny', true );

    if ($auto && $undersidemeny == 'ja')
        $foreldreside = $pageId;
    elseif($meny && $visurlmeny == 'ja') {
        // Meny gitt som query-parameter
        $foreldreside = $meny;
    } elseif ($auto){
        // Finn sidens foreldreside
        $parents = get_post_ancestors($pageId);
        if($parents){
            $parentId = $parents[0];
            $foreldreside = $parentId;
        } else {
            $foreldreside = '';
        }
    }



    $pages = array();

    $args = array (
        'hierarchical' => 0,
        'sort_column' => 'post_title',
        'sort_order' => 'asc',
    );

    if($foreldreside){
        $ekstra_menysider = get_post_meta($foreldreside, 'ekstra_menysider', true);

        if($auto){
            // Legg til foreldreside
            $args['include'] = '' . $foreldreside;
            $pages = array_merge($pages, get_pages($args));
            unset($args['include']);  
        }
        // Legg til alle barn av foreldreside
        $args['parent'] = $foreldreside;
        $pages = array_merge($pages, get_pages($args));
        unset($args['parent']);  
    }

    // Legg til sider angitt spesielt med argument "sider"
    if($sider){
        $args['include'] = $sider;
        $pages = array_merge($pages, get_pages($args));
        unset($args['include']);  
    }

    // Legg til sider angitt spesielt med foreldresidens sidevariabel ekstra_menysider
    if($ekstra_menysider){
        $args['include'] = $ekstra_menysider;
        $pages = array_merge($pages, get_pages($args));
        unset($args['include']);  
    }


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
        $visispalte = get_post_meta( $page->ID, 'spalte', true );
        $direktelink = get_post_meta( $page->ID, 'direktelink', true );
        $menytekst = get_post_meta( $page->ID, 'menytekst', true );
        $title = $menytekst ? $menytekst : $page->post_title;

        $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($page->ID), 'thumbnail' );
        $bildeUrl = $thumb['0'];

        if(!$bildeUrl){
            $bildeUrl = "/wp-content/uploads/2014/03/Strindheim_Idrettslag_logo.png";
        }

        $bilde = $visBilde ? '<img width="' . $picsize . '" height="' . $picsize . '" src="' . $bildeUrl . '" alt="Strindheim Håndball">' : '';

        if(strtolower($beskrivelse) == 'ja') {
            $beskrivelse_tekst = get_post_meta( $page->ID, 'beskrivelse', true );
            $extraPadding = ' style="padding-left:20px" ';
        }

        if($direktelink) 
            $url = $direktelink;
        else 
            $url = get_permalink($page->ID);

        if($foreldreside) $url .= '?meny=' . $foreldreside;

        if (empty($visispalte)){
            $visispalte = $pagecount % 2 + 1;
        }

        $currentClass = ($page->ID == $pageId) ? ' klubbmeny_current' : '';
        

        if($visispalte == $spalte || $spalte == 0) {
            $res .= '<div class="klubbsidemeny' . $currentClass . '" onclick="window.location=   \'' . $url . '\';">';
            $res .= '<table><tr>';
            $res .= $visBilde ? '<td width="' . $picwidth . '%"  align="center">' . $bilde . '</td>' : '';
            $res .= '<td class="klubbmenytitle"' . $extraPadding . '><h' . $h . '>' . ($visBilde ? '' : '&nbsp;') . $title . '</h' . $h . '>';
            //$res .= '<td class="klubbmenytitle"><h' . $h . '>' . ($visBilde ? '' : '&nbsp;') . $title . '</h' . $h . '>';
            $res .= '<p>' . $beskrivelse_tekst . '</p>';
            $res .= '</td>';
            $res .= '</tr></table>';
            $res .= '</div>';
        }
    }
    $res .= '';

    return $res;
}





/* Place custom code above this line. */
?>