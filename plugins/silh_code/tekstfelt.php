    <?php
/**
 * Description: Kode for SIL Håndball. (http://justintadlock.com/archives/2011/02/02/creating-a-custom-functions-plugin-for-end-users)
 * Author: Otto Paulsen
 * Author URI: http://yoursite.com
 * Version: 0.1.0
 */

/* Place custom code below this line. */



/* [tekstfelt tekstnavn="navn"]
   Brukes for å legge inn tekst som kan redigeres fra siden.
   Lagres i sidevariabel.
   Kan ha flere på en side, bare gi dem forskjllig tekstnavn.
*/
add_shortcode( 'tekstfelt', 'tekstfelt_func' );
function tekstfelt_func($atts, $tag){
    $res = "";

    extract(shortcode_atts(array('tekstnavn' => ''), $atts));

    $tekst = get_post_meta( get_the_ID(), 'tekst_' . $tekstnavn, true );


    if (empty($tekst)){
        if(silhUserCanEdit()) {
            $res .= '<a href="/rediger-tekstfelt?side_id=' . get_the_ID() . '&tekstnavn=' . $tekstnavn . '">Legg inn tekst</a>';
        }
    } else {
        // Tekst funnet
        $res .= $tekst;
        if(silhUserCanEdit()) {
            $res .= '<a href="/rediger-tekstfelt?side_id=' . get_the_ID() . '&tekstnavn=' . $tekstnavn . '">Rediger tekst</a>';
        }
    }

    //update_post_meta(2751, 'otto test', 'Test: kal_id = ' . $kal_id );

    return $res;
}


/* Place custom code above this line. */
?>