<?php
declare(strict_types=1);

require_once __DIR__ . '/src/_all.php';

/**
 * LENA
 *
 * @author Carsten Hellweg <hellweg@qualitus.de>
 * @author Jean-Luc Braun <braun@qualitus.de>
 * @ilCtrl_isCalledBy ilLENAConfigGUI: ilObjComponentSettingsGUI
 */
class ilLENAConfigGUI extends ilPluginConfigGUI {

    /**
     * @var ilCtrl
     */
    protected ilCtrl $ilCtrl;

    /**
     * @var ilLanguage
     */
    protected ilLanguage $lng;

    /**
     * @var ilSetting
     */
    protected ilSetting $ilSetting;

    /**
     * @var ilGlobalPageTemplate
     */
    protected ilGlobalPageTemplate $tpl;

    /**
     * ilMassMaticsConfigGUI constructor.
     */
    public function __construct() {
        global $DIC;

        $this->ilCtrl    = $DIC->ctrl();
        $this->lng 	 = $DIC->language();
        $this->ilSetting = $DIC->settings();
        $this->tpl 	 = $DIC->ui()->mainTemplate();

        // lena-scanner
        global $DIC;
        $db = $DIC->database();        
        $facade = new UseCaseScannerFacade( $db );
        if( ( $this->ilSetting->get("lena_usecase_1_crsid", "" ) ) ) {
            $facade->addScanner( 1, $this->ilSetting->get( "lena_usecase_1_crsid" ) );
        }
        if( ( $this->ilSetting->get("lena_usecase_2_crsid", "" ) ) ) {
            $facade->addScanner( 2, $this->ilSetting->get( "lena_usecase_2_crsid" ) );
        }
        if( ( $this->ilSetting->get("lena_usecase_3_crsid", "" ) ) ) {
            $facade->addScanner( 1, $this->ilSetting->get( "lena_usecase_3_crsid" ) );
        }
        if( ( $this->ilSetting->get("lena_usecase_4_crsid", "" ) ) ) {
            $facade->addScanner( 1, $this->ilSetting->get( "lena_usecase_4_crsid" ) );
        }        
        $facade->execute();
    }

    /**
     * Handles all commmands, default is "configure"
     */
    function performCommand($cmd) {
        switch ($cmd) {
            case "configure":
            case "save":
                $this->$cmd();
                break;
        }
    }

    /**
     * Configure screen
     */
    function configure() {
        $form = $this->initConfigurationForm();
        $this->tpl->setContent($form->getHTML());
    }

    /**
     * Init configuration form.
     *
     * @return ilPropertyFormGUI form object
     */
    public function initConfigurationForm(): ilPropertyFormGUI {                
        $pl = $this->getPluginObject();
        $form = new ilPropertyFormGUI();

        $usecase1_header = new ilFormSectionHeaderGUI();
        $usecase1_header->setTitle($pl->txt("usecase_1"));
        $form->addItem($usecase1_header);
        $usecase_1_crsid = new ilNumberInputGUI($pl->txt("usecase_1_crsid"), "usecase_1_crsid");
        $usecase_1_crsid->setInfo($pl->txt("usecase_1_crsid_info"));
        $usecase_1_crsid->setSize(5);
        $usecase_1_crsid->setSuffix($pl->txt("crs_ref_id"));
        $usecase_1_crsid->setValue($this->ilSetting->get("lena_usecase_1_crsid"));
        $form->addItem($usecase_1_crsid);

        $usecase2_header = new ilFormSectionHeaderGUI();
        $usecase2_header->setTitle($pl->txt("usecase_2"));
        $form->addItem($usecase2_header);
        $usecase_2_crsid = new ilNumberInputGUI($pl->txt("usecase_2_crsid"), "usecase_2_crsid");
        $usecase_2_crsid->setInfo($pl->txt("usecase_2_crsid_info"));
        $usecase_2_crsid->setSize(5);
        $usecase_2_crsid->setSuffix($pl->txt("crs_ref_id"));
        $usecase_2_crsid->setValue($this->ilSetting->get("lena_usecase_2_crsid"));
        $form->addItem($usecase_2_crsid);

        $usecase3_header = new ilFormSectionHeaderGUI();
        $usecase3_header->setTitle($pl->txt("usecase_3"));
        $form->addItem($usecase3_header);
        $usecase_3_crsid = new ilNumberInputGUI($pl->txt("usecase_3_crsid"), "usecase_3_crsid");
        $usecase_3_crsid->setInfo($pl->txt("usecase_3_crsid"));
        $usecase_3_crsid->setSize(5);
        $usecase_3_crsid->setSuffix($pl->txt("crs_ref_id"));
        $usecase_3_crsid->setValue($this->ilSetting->get("lena_usecase_3_crsid"));
        $form->addItem($usecase_3_crsid);

        $usecase4_header = new ilFormSectionHeaderGUI();
        $usecase4_header->setTitle($pl->txt("usecase_4"));
        $form->addItem($usecase4_header);
        $usecase_4_crsid = new ilNumberInputGUI($pl->txt("usecase_4_crsid"), "usecase_4_crsid");
        $usecase_4_crsid->setInfo($pl->txt("usecase_4_crsid_info"));
        $usecase_4_crsid->setSize(5);
        $usecase_4_crsid->setSuffix($pl->txt("crs_ref_id"));
        $usecase_4_crsid->setValue($this->ilSetting->get("lena_usecase_4_crsid"));
        $form->addItem($usecase_4_crsid);

        $form->addCommandButton("save", $this->lng->txt("save"));

        $form->setTitle($pl->txt("plugin_configuration"));
        $form->setFormAction($this->ilCtrl->getFormAction($this));

        return $form;
    }

    /**
     * Save form input (currently does not save anything to db)
     *
     */
    public function save() {
        $pl = $this->getPluginObject();

        $form = $this->initConfigurationForm();
        if ($form->checkInput()) {
            $usecase_1_ref_id	= $form->getInput("usecase_1_crsid");
            /** @todo check if course */
            $this->ilSetting->set('lena_usecase_1_crsid', $usecase_1_ref_id);

            $usecase_2_ref_id	= $form->getInput("usecase_2_crsid");
            /** @todo check if course */
            $this->ilSetting->set('lena_usecase_2_crsid', $usecase_2_ref_id);

            $usecase_3_ref_id	= $form->getInput("usecase_3_crsid");
            /** @todo check if course */
            $this->ilSetting->set('lena_usecase_3_crsid', $usecase_3_ref_id);

            $usecase_4_ref_id	= $form->getInput("usecase_4_crsid");
            /** @todo check if course */
            $this->ilSetting->set('lena_usecase_4_crsid', $usecase_4_ref_id);

            $this->tpl->setOnScreenMessage('success', $pl->txt("saving_invoked"), true);
            $this->ilCtrl->redirect($this, "configure");
        } else {
            $form->setValuesByPost();
            $this->tpl->setContent($form->getHtml());
        }
    }
}