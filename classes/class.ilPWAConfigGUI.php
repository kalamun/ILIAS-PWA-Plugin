<?php
/**
 * Config screen
 */
class ilPWAConfigGUI extends ilPluginConfigGUI {

    const PLUGIN_CLASS_NAME = ilPWAPlugin::class;
    const CMD_CONFIGURE = "configure";
    const CMD_UPDATE_CONFIGURE = "updateConfigure";
    const LANG_MODULE = "config";

    protected $dic;
    protected $plugin;
    protected $lng;
    protected $request;
    protected $user;
    protected $ctrl;
  
    public function __construct()
    {
      global $DIC;
      $this->dic = $DIC;
      $this->plugin = ilPWAPlugin::getInstance();
      $this->lng = $this->dic->language();
      // $this->lng->loadLanguageModule("assessment");
      $this->request = $this->dic->http()->request();
      $this->user = $this->dic->user();
      $this->ctrl = $this->dic->ctrl();
    }
    
    public function performCommand(/*string*/ $cmd)/*:void*/
    {
        $this->plugin = $this->getPluginObject();

        switch ($cmd)
		{
			case self::CMD_CONFIGURE:
            case self::CMD_UPDATE_CONFIGURE:
                $this->{$cmd}();
                break;

            default:
                break;
		}
    }

    protected function configure()/*: void*/
    {
        global $tpl, $ilCtrl, $lng;

        $title_long = "";
        $title_short = "";

        $manifest_url = './manifest.json';
        if (file_exists($manifest_url)) {
            $manifest = file_get_contents($manifest_url);
            if (!empty($manifest)) {
                $manifest = json_decode($manifest);
                $title_long = $manifest->name;
                $title_short = $manifest->short_name;
            }
        }
        
		require_once("./Services/Form/classes/class.ilPropertyFormGUI.php");
		$form = new ilPropertyFormGUI();
		$form->setFormAction($ilCtrl->getFormAction($this));
        $form->setTitle($this->plugin->txt("settings"));
        
        $title_long_input = new ilTextInputGUI($this->plugin->txt("title_long", true), 'title_long');
        $title_long_input->setValue($title_long);
        $form->addItem($title_long_input);
        
        $title_short_input = new ilTextInputGUI($this->plugin->txt("title_short", true), 'title_short');
        $title_short_input->setValue($title_short);
        $form->addItem($title_short_input);
        
        $icon_192 = new ilImageFileInputGUI($this->plugin->txt("icon_192", true), 'icon_192');
        $icon_192->setAllowDeletion(false);
        $image_url = './manifest_logo192.png';
        if (file_exists($image_url)) {
            $icon_192->setImage($image_url);
        }
        $form->addItem($icon_192);
        
        $icon_512 = new ilImageFileInputGUI($this->plugin->txt("icon_512"), 'icon_512');
        $icon_512->setAllowDeletion(false);
        $image_url = './manifest_logo512.png';
        if (file_exists($image_url)) {
            $icon_512->setImage($image_url);
        }
        $form->addItem($icon_512);
        
        $form->addCommandButton("updateConfigure", $lng->txt("save"));

		$tpl->setContent($form->getHTML());
    }

    protected function updateConfigure()/*: void*/
    {
        global $lng;

        $manifest = file_get_contents(__DIR__ .'/../manifest.json');

        $manifest = str_replace('{NAME}', $_POST['title_long'], $manifest);
        $manifest = str_replace('{SHORT_NAME}', $_POST['title_short'], $manifest);

        $manifest_status = @file_put_contents('manifest.json', $manifest);

        if (!empty($_FILES['icon_192']['name'])) {
            $icon192_status = @move_uploaded_file($_FILES["icon_192"]["tmp_name"], 'manifest_logo192.png');
        }
        if (!empty($_FILES['icon_512']['name'])) {
            $icon512_status = @move_uploaded_file($_FILES["icon_512"]["tmp_name"], 'manifest_logo512.png');
        }

        self::configure();

        if ($manifest_status === false) {
            ilUtil::sendFailure($this->plugin->txt("error_manifest"), true);
        } elseif ($icon192_status === false) {
            ilUtil::sendFailure($this->plugin->txt("error_icon192"), true);
        } elseif ($icon512_status === false) {
            ilUtil::sendFailure($this->plugin->txt("error_icon512"), true);
        } else {
            ilUtil::sendSuccess($this->plugin->txt("configuration_saved"), true);
        }
    }
}
