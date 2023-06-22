<?php

declare(strict_types=1);

/**
 *  LENA
 *
 *
 * @version $Id$
 * @ilCtrl_isCalledBy ilLENAPluginGUI: ilPCPluggedGUI
 */
class ilLENAPluginGUI extends ilPageComponentPluginGUI
{
	/**
	 * Execute command
	 *
	 * @param
	 * @return
	 */
	function executeCommand()
	{
		global $ilCtrl;

		$next_class = $ilCtrl->getNextClass();

		switch ($next_class) {
			default:
				$cmd = $ilCtrl->getCmd();
				if (in_array($cmd, array("create", "insert", "save", "edit", "update", "cancel"))) {
					$this->$cmd();
				}
				break;
		}
	}

	/**
	 * Create
	 *
	 * @param
	 * @return
	 */
	function insert()
	{
		global $tpl;
		$form = $this->initForm(true);
		$tpl->setContent($form->getHTML());
	}

    /**
     * Init editing form
     *
     * @param bool $a_create
     * @return ilPropertyFormGUI
     */
	public function initForm($a_create = false): ilPropertyFormGUI
    {
		global $lng, $ilCtrl;

		include_once("Services/Form/classes/class.ilPropertyFormGUI.php");
		$form = new ilPropertyFormGUI();

		$ne = new ilNonEditableValueGUI("", "");
		$warning_text = $this->getPlugin()->txt("currently_no_settings");

		$ne->setValue($warning_text);
		$form->addItem($ne);

		// save and cancel commands

        $this->addCreationButton($form);
        $form->addCommandButton("cancel", $lng->txt("cancel"));
        $form->setTitle($this->getPlugin()->txt("cmd_insert"));

		$form->setFormAction($ilCtrl->getFormAction($this));
		return $form;
	}

	/**
	 * Save element
	 */
	public function create()
	{
		global $tpl, $lng;

		$form = $this->initForm(true);
		if ($form->checkInput()) {
			$properties = array();
			if ($this->createElement($properties)) {
                $tpl->setOnScreenMessage('success', $lng->txt("msg_obj_modified"), true);
				$this->returnToParent();
			}
		}
		$form->setValuesByPost();
		$tpl->setContent($form->getHtml());
	}

	/**
	 * Edit
	 *
	 * @param
	 * @return
	 */
	function edit()
	{
		global $tpl;

		$form = $this->initForm();
		$tpl->setContent($form->getHTML());
	}

	/**
	 * Update
	 *
	 * @param
	 * @return
	 */
	function update()
	{
		global $tpl, $lng;

		$form = $this->initForm(true);
		if ($form->checkInput()) {
			$properties = array();
			if ($this->updateElement($properties)) {
                $tpl->setOnScreenMessage('success', $lng->txt("msg_obj_modified"), true);
				$this->returnToParent();
			}
		}
		$form->setValuesByPost();
		$tpl->setContent($form->getHtml());
	}

	/**
	 * Cancel
	 */
	function cancel()
	{
		$this->returnToParent();
	}

	/**
	 * Get HTML for element
	 *
	 * @param string $a_mode (edit, presentation, preview, offline)s
	 * @return string $html
	 */
        function getElementHTML($a_mode, array $a_properties, $plugin_version): string {
            global $DIC;
            $tree = $DIC->repositoryTree();
            $ilSetting 	= $DIC->settings();

            $pl = $this->getPlugin();
            $tpl = $pl->getTemplate("tpl.content.html");

            $ref_id = (int)$_GET["ref_id"];
            if (ilObject::_lookupType($ref_id, true) == "crs") {
                $crs_ref_id = $ref_id;
            } else {
                $crs_ref_id = $tree->checkForParentType($ref_id, 'crs');
                //return false if item is not in tree or 0 if no crs found
            }
            
            /*
            $usecase = $this->determineUseCase( $crs_ref_id );
            $message = '';
            $content = '';
            $editMode = false;
            if( $a_mode == "edit" ) {
                $editMode = true;
            }
            if( $usecase == -1 ) { // no course
                if( $editMode ) {
                    $message = $pl->txt( 'edit_mode_warning_no_course' );
                    $tpl->setVariable( 'EDIT_MODE_TXT', $message );                    
                }                
                return $tpl->get();
            }
            if( $usecase == 0 ) { // a course, but not in usecases
                if( $editMode ) {
                    $message = $pl->txt( 'usecase_none' );                                
                    $tpl->setVariable( 'EDIT_MODE_TXT', $message );                    
                }
                return $tpl->get();
            }
            
            // ---------------------------------------------------------------------------------------------
            // all use-cases
                        
            // all use-cases, edit
            if( $editMode ) {
                $message = $pl->txt( "usecase_" . $usecase );
                $tpl->setVariable( "EDIT_MODE_TXT", $message );                
                return $tpl->get();
            }
                        
            // enable kiosk-mode 
            if( 
                ( $usecase == 1 )
                || ( $usecase == 2 ) 
            ) {
                $tpl->touchBlock( "kiosk_mode" );
            }
            
            // all use-cases, content
//            $renderer = new MyRenderer();
            if( $usecase == 1 ) {
//                $renderer->add();
            }
            if( $usecase == 2 ) {
//                $renderer->add();
            }
            if( $usecase == 3 ) {
//                $renderer->add();
            }
            
//            renderer->setBaseUrl(); // etc
            
            $content = 'Hi, I am LENA ... usecase:' . $usecase;
//            $content = $renderer->render();            
            $tpl->setVariable("RUN_MODE_TXT", $content );
            
            return $tpl->get();
            // */
            
            
            if ($crs_ref_id) {//course found
                $usecase1 = $ilSetting->get("lena_usecase_1_crsid");
                $usecase2 = $ilSetting->get("lena_usecase_2_crsid");
                $usecase3 = $ilSetting->get("lena_usecase_3_crsid");
                $usecase4 = $ilSetting->get("lena_usecase_4_crsid");
                if ($crs_ref_id == $usecase1) {
                    $message = $pl->txt("usecase_1");
                    if ($a_mode == "edit") {
                        $tpl->setVariable("EDIT_MODE_TXT", $message);
                    } else {
                        $tpl->setVariable("RUN_MODE_TXT", "Hi Lena usecase 1");
                    }
                    $tpl->touchBlock("kiosk_mode");
                } else if ($crs_ref_id == $usecase2) {
                    $message = $pl->txt("usecase_2");
                    if ($a_mode == "edit") {
                        $tpl->setVariable("EDIT_MODE_TXT", $message);
                    } else {
                        $tpl->setVariable("RUN_MODE_TXT", "Hi Lena usecase 2");
                    }
                    $tpl->touchBlock("kiosk_mode");
                } else if ($crs_ref_id == $usecase3) {
                    $message = $pl->txt("usecase_3");
                    if ($a_mode == "edit") {
                        $tpl->setVariable("EDIT_MODE_TXT", $message);
                    } else {
                        $tpl->setVariable("RUN_MODE_TXT", "Hi Lena usecase 3");
                    }
                } else if ($crs_ref_id == $usecase4) {
                    $message = $pl->txt("usecase_4");
                    if ($a_mode == "edit") {
                        $tpl->setVariable("EDIT_MODE_TXT", $message);
                    }
                } else {
                    $message = $pl->txt("usecase_none");
                    if ($a_mode == "edit") {
                        $tpl->setVariable("EDIT_MODE_TXT", $message);
                    }
                }
            } else {//no course found
                if ($a_mode == "edit") {//warning by edit only
                    $message = $pl->txt('edit_mode_warning_no_course');
                    $tpl->setVariable("EDIT_MODE_TXT", $message);
                }
            }

            return $tpl->get();
        }
        
        protected function determineUseCase( $crs_ref_id ) {                                    
            if( 
                ( $crs_ref_id === false )
                || ( $crs_ref_id == 0 )
            ) {
                return -1; // no course
            }
            global $DIC;
            $ilSetting 	= $DIC->settings();
            if( $crs_ref_id == $ilSetting->get( "lena_usecase_1_crsid" ) ) {
                return 1;
            }
            if( $crs_ref_id == $ilSetting->get( "lena_usecase_2_crsid" ) ) {
                return 2;
            }
            if( $crs_ref_id == $ilSetting->get( "lena_usecase_3_crsid" ) ) {
                return 3;
            }
            if( $crs_ref_id == $ilSetting->get( "lena_usecase_4_crsid" ) ) {
                return 4;
            }
            
            return 0;
        }
}