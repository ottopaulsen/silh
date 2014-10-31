    <?php
/**
 * Description: Kode for SIL Håndball. 
 * Author: Otto Paulsen
 * 
 * Version: 0.1.0
 */

/* Place custom code below this line. */


   
function silhUserCanEdit() {
    $userCanWrite = FALSE; 
    
    global $oUserAccessManager;
    if (isset($oUserAccessManager)) :
        $uamAccessHandler = $oUserAccessManager->getAccessHandler();
	    $oCurrentUser = $uamAccessHandler->getUserAccessManager()->getCurrentUser();
        $aUserGroupsForPage = $uamAccessHandler->getUserGroupsForObject('page', get_the_ID());
        $aUserGroupsForUser = $uamAccessHandler->getUserGroupsForObject('user', $oCurrentUser->ID);

        foreach ($aUserGroupsForPage as $pageGroups) {
        	foreach ($aUserGroupsForUser as $userGroups) {
        		if ($userGroups->getGroupName() == $pageGroups->getGroupName()) {
        			$userCanWrite = TRUE;
        		}
        	}
        }

    endif;

    # Administrators can always edit
    if (is_super_admin()) {
        $userCanWrite = TRUE;
    }

    return $userCanWrite;
}



// [ifusercanedit]
// Vis innhold i shortcoden hvis den innloggede brukeren kan editere siden
// Opptatert 18.8.2014 av Otto Paulsen

add_shortcode( 'ifusercanedit', 'ifusercanedit_func' );
function ifusercanedit_func($atts, $content){

    $res = "" ;

    if ( silhUserCanEdit() ) {
        $res = $res . $content;
    } 

    return $res;
}


// List brukere som kan redigere siden
add_shortcode( 'sideredaktorer', 'sideredaktorer_func' );
function sideredaktorer_func($atts){

    $res = "" ;

    global $oUserAccessManager;
    if (isset($oUserAccessManager)) :
        $uamAccessHandler = $oUserAccessManager->getAccessHandler();
        $aUserGroupsForPage = $uamAccessHandler->getUserGroupsForObject('page', get_the_ID());

        foreach ($aUserGroupsForPage as $pageGroups) {
        	$aUsers = $pageGroups->getFullUsers();
            foreach ($aUsers as $user) {
                $userdata = get_userdata($user->id);
                $res .= $userdata->first_name . ' ' . $userdata->last_name . '<br>';
            }
        }

    endif;

    return $res;
}




/* Place custom code above this line. */
?>