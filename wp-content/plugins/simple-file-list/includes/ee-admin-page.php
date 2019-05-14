<?php // Simple File List List List - Mitchell Bennis | Element Engage, LLC | mitch@elementengage.com
	
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if ( ! wp_verify_nonce( $eeSFL_Nonce, 'ee_include_page' )) exit('That is Noncense!'); // Exit if nonce fails

$eeSFL_Log[] = 'Loaded: ee-admin-page';

function eeSFL_ManageLists() {
	
	global $eeSFL, $eeSFLF, $eeSFLU, $eeSFL_Log, $eeSFL_DevMode, $eeSFL_Admin, $eeSFL_AddOnsURL, 
		$eeSFL_Config, $eeSFL_Version, $eeSFL_ListNumber;
	
	$eeSFL_Admin = TRUE;
	
	$eeSFL_Nonce = wp_create_nonce('ee_include_page'); // Security
	
	// Process the Config Array
	if(@is_array($eeSFL_Config)) {
		
		$eeSFL_Log['Config'] = $eeSFL_Config;
		
		// Loop through and build variable names from the associative array
		foreach($eeSFL_Config as $eeKey => $eeValue) {
			
			${$eeKey} = $eeValue;
			
			if(is_array($eeValue)) {
				
				$eeValue = implode(' = ', $eeValue);
			}
		}
		
	} else {
		
		$eeSFL_Log[] = 'No SFL Configuration';
		
		return FALSE;
	}
	
	$eeSFL_Log[] = '$eeSFL_UploadDirName = ' . $eeSFL_UploadDirName;
	
	// Begin Output
	$eeOutput = '<div class="eeSFL_Admin wrap"><div id="eeSFL">'; 
	
	if($eeSFL_DevMode) { $eeOutput .= '<p class="eeAlert">' . __('DEVELOPMENT MODE ON', 'ee-simple-file-list') . '</p>'; }
	
	$eeSFL_Page = 'ee-simple-file-list'; // This admin page slug
	
	// Reads the new tab's query string value
	if( isset( $_GET[ 'tab' ] ) ) { $active_tab = $_GET[ 'tab' ]; } else { $active_tab = 'file_list'; }
	
	$eeOutput .= '<h2 class="nav-tab-wrapper">';
	
	// Tabs -------
	
	// File List
	$eeOutput .= '<a href="?page=' . $eeSFL_Page . '&tab=file_list" class="nav-tab tabList ';  
	if($active_tab == 'file_list') {$eeOutput .= '  eeActiveTab ';}    
    $active_tab == 'file_list' ? 'nav-tab-active' : '';    
    $eeOutput .= $active_tab . '">' . __('File List', 'ee-simple-file-list') . '</a>';
    
    // User Support (Optional)
    if($eeSFLU) {
	    $eeOutput .= '<a href="?page=ee-simple-file-list-users" class="nav-tab tabList ';   
	    $eeOutput .= $active_tab . '">' . __('User Manager', 'ee-simple-file-list') . '</a>';
    }
    
	// The Help / Email Form Page
    $eeOutput .= '<a href="?page=' . $eeSFL_Page . '&tab=help" class="nav-tab tabSupport ';   
	if($active_tab == 'help') {$eeOutput .= '  eeActiveTab '; }  
    $active_tab == 'help' ? 'nav-tab-active' : ''; 
    $eeOutput .= $active_tab . '">' . __('Help', 'ee-simple-file-list') . '</a>';
    
    // Author
    $eeOutput .= '<a href="?page=' . $eeSFL_Page . '&tab=author" class="nav-tab tabSupport ';   
	if($active_tab == 'author') {$eeOutput .= '  eeActiveTab '; }  
    $active_tab == 'author' ? 'nav-tab-active' : ''; 
    $eeOutput .= $active_tab . '">' . __('Author', 'ee-simple-file-list') . '</a>';
    
    // Plugin Instructions
    $eeOutput .= '<a href="?page=' . $eeSFL_Page . '&tab=instructions" class="nav-tab tabSupport ';  
	if($active_tab == 'instructions') {$eeOutput .= '  eeActiveTab '; }   
    $active_tab == 'support' ? 'nav-tab-active' : ''; 
    $eeOutput .= $active_tab . '">' . __('Instructions', 'ee-simple-file-list') . '</a>';
    
    // Folder Support
    if(!$eeSFLF) {
	    $eeOutput .= '<a href="?page=' . $eeSFL_Page . '&tab=folders" class="nav-tab tabSupport ';   
		if($active_tab == 'folders') {$eeOutput .= '  eeActiveTab '; }  
	    $active_tab == 'folders' ? 'nav-tab-active' : ''; 
	    $eeOutput .= $active_tab . '">' . __('Folders', 'ee-simple-file-list') . '</a>';
    }
    
    $eeOutput .= '</h2>'; // END Tabs	
	
	$eeSFL_PluginPath = $eeSFL_Config['eeSFL_PluginPath']; //-->   /wp-content/plugins/simple-file-list-4/includes/
	
	$eeSFL_Nonce = wp_create_nonce('ee_include_page'); // Checked on the included page
    
    
    
    // Tab Content =============================================================
    
	if($active_tab == 'file_list') {
	
		$eeOutput .= '<div id="uploadFilesDiv">';
		
		include($eeSFL_PluginPath . 'includes/ee-uploader.php'); // The Uploader
		
		$eeOutput .= '</div>';
		
		include($eeSFL_PluginPath . 'includes/ee-list-display.php'); // The File List		
	
	} elseif($active_tab == 'list_settings') {
	
		// Sub Tabs
		if( isset( $_GET[ 'subtab' ] ) ) { $active_subtab = $_GET[ 'subtab' ]; } else { $active_subtab = 'list_settings'; }
		
		$eeOutput .= '<h2 class="nav-tab-wrapper">';
		
		// List Settings
		$eeOutput .= '<a href="?page=' . $eeSFL_Page . '&tab=list_settings&subtab=list_settings" class="nav-tab ';  
		if($active_subtab == 'list_settings') {$eeOutput .= '  eeActiveTab ';}    
	    $active_subtab == 'list_settings' ? 'nav-tab-active' : '';    
	    $eeOutput .= $active_subtab . '">' . __('File List Settings', 'ee-simple-file-list') . '</a>';
	    
	    // Uploader Settings
		$eeOutput .= '<a href="?page=' . $eeSFL_Page . '&tab=list_settings&subtab=uploader_settings" class="nav-tab ';  
		if($active_subtab == 'uploader_settings') {$eeOutput .= '  eeActiveTab ';}    
	    $active_subtab == 'uploader_settings' ? 'nav-tab-active' : '';    
	    $eeOutput .= $active_subtab . '">' . __('Uploader Settings', 'ee-simple-file-list') . '</a>';
	    
	    $eeOutput .= '</h2>'; // END Subtabs
	    
		if($active_subtab != 'list_settings') {
			
			include($eeSFL_PluginPath . 'includes/ee-upload-settings.php'); // The Uploader Settings
		
		} else {
			
			include($eeSFL_PluginPath . 'includes/ee-list-settings.php'); // The File Settings
		}
		
	} elseif($active_tab == 'folders') { // Instructions Tab Display...
			
		// Get the sales page
		include($eeSFL_PluginPath . 'support/ee-get-simple-file-list-folders.php');
	
	
	} elseif($active_tab == 'instructions') { // Instructions Tab Display...
			
		// Get the instructions page
		include($eeSFL_PluginPath . 'support/ee-plugin-instructions.php');
	
	
	} elseif($active_tab == 'help') { // Email Support Tab Display...
		
		$eePlugin = $eeSFL_PluginName;
			
		// Get the support page
		include($eeSFL_PluginPath . 'support/ee-plugin-support.php');
	
	
	} else { // Author
					
		// Get the support page
		include($eeSFL_PluginPath . 'support/ee-plugin-author.php');
		
	} // END Tab Content
	
	
	
	$eeOutput .= '<div id="eeAdminFooter">
	
			<fieldset><p id="eeFooterImportant" class="eeHide">' . __('IMPORTANT: Allowing the public to upload files to your web server comes with risk. Please go to Upload Settings and ensure that you only use the file types that you absolutely need. Open each file submitted carefully.', 'ee-simple-file-list') . '</p>';
				
				if(!$eeSFLF) {
					$eeOutput .= '<p class="eeRight"><strong><a target="_blank" class="button" href="' . $eeSFL_AddOnsURL . '?eeExtension=ee-simple-file-list-folders&eeDomain=' . urlencode( site_url() ) . '">' . __('Add Folder Support', 'ee-simple-file-list') . '</a></strong></p>';
				}
				
				$eeOutput .= '<a href="https://simplefilelist.com" target="_blank">' . __('Website', 'ee-simple-file-list') . '</a> | 
					<a href="https://simplefilelist.com/simple-file-list-news/" target="_blank">' . __('News', 'ee-simple-file-list') . '</a> | 
						<a href="https://simplefilelist.com/give-feedback/" target="_blank">' . __('Feedback', 'ee-simple-file-list') . '</a> | 
							<a href="https://wordpress.org/support/plugin/simple-file-list/reviews/" target="_blank">' . __('Review', 'ee-simple-file-list') . '</a> | 
								<a href="#" id="eeFooterImportantLink">Caution</a>';
								
				if(!$eeSFLF) {
					$eeOutput .= ' | <a href="https://simplefilelist.com/donations/simple-file-list-project/" target="_blank">' . __('Buy Me a Cup of Coffee', 'ee-simple-file-list') . '</a>';
				}
				
				$eeOutput .= '</p>
				
				<p><a href="' . $eeSFL_WebPage . '">' . $eeSFL_PluginName . '</a> &mdash; ' . __('Version', 'ee-simple-file-list') . ': ' . $eeSFL_Version . '</p>
				
			</fieldset>
		</div>
	</div>
</div>'; // END #eeSFL
	
	$eeSFL_Log[] = 'Outputting the page...';
	
	// Logging
	if($eeSFL_DevMode) { // Display the log at the bottom of the page.
		$eeOutput .= '<pre id="eeSFL_DevMode">Log File ' . print_r($eeSFL_Log, TRUE) . '</pre>';
		$eeOutput .= $eeSFL->eeSFL_WriteLogFile($eeSFL_Log); // Write to the log file
	} else {
		$eeSFL->eeSFL_WriteLogFile($eeSFL_Log); // Write to the log file, but don't display it.
	}
	
	
	// Output the page
	echo $eeOutput;
}


?>