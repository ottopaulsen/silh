    <?php
/**
 * Description: Kode for SIL Håndball. 
 * Author: Otto Paulsen
 * 
 * Version: 0.1.0
 */

/* Place custom code below this line. */




/*
    Hook for innsending av Formidable Forms.
        Form id 18 - Google Kalender-ID brukes for å legge inn Google Kalender-ID på siden. Verdien lagres i variabel.
        Form id 19 - Google Skjema-ID brukes for å legge inn Google Skjema-ID på siden. Verdien lagres i variabel.
*/
add_action('frm_after_create_entry', 'formidableHookSaveGoogleCalendarId', 10, 2);
function formidableHookSaveGoogleCalendarId($entry_id, $form_id){
    if($form_id == 18){ 
        if(isset($_POST['item_meta'][171])) 
            $kalender_var = $_POST['item_meta'][171];
        if(isset($_POST['item_meta'][169]))
            $kalender_id = $_POST['item_meta'][169];
        if(isset($_POST['item_meta'][173]))
            $side_id = $_POST['item_meta'][173];
        update_post_meta($side_id, $kalender_var, $kalender_id);
    } elseif ($form_id == 19) {
        if(isset($_POST['item_meta'][175])) 
            $skjema_var = $_POST['item_meta'][175];
        if(isset($_POST['item_meta'][174]))
            $skjema_id = $_POST['item_meta'][174];
        if(isset($_POST['item_meta'][179])) 
            $skjemasvar_var = $_POST['item_meta'][179];
        if(isset($_POST['item_meta'][178]))
            $svar_url = $_POST['item_meta'][178];
        if(isset($_POST['item_meta'][177]))
            $side_id = $_POST['item_meta'][177];
        update_post_meta($side_id, $skjema_var, $skjema_id);
        update_post_meta($side_id, $skjemasvar_var, $svar_url);
    }
}


/* Place custom code above this line. */
?>