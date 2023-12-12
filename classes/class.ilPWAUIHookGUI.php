<?php

/**
 * Class ilPWAUIHookGUI
 * @author            Kalamun <rp@kalamun.net>
 * @version $Id$
 * @ingroup ServicesUIComponent
 * @ilCtrl_isCalledBy ilPWAUIHookGUI: ilUIPluginRouterGUI, ilAdministrationGUI, ilPWAGUI
 */

class ilPWAUIHookGUI extends ilUIHookPluginGUI {

  protected $plugin;

  public function __construct()
  {
    $this->plugin = ilPWAPlugin::getInstance();
  }
  
	function getHTML(string $a_comp, string $a_part, array $a_par = []): array
  {
    if($a_part == "template_get" && strpos($a_par["tpl_id"], "standardpage.html") !== false) {
      $html = $a_par["html"];
      $html = str_replace('</head>', '<link rel="manifest" href="/manifest.json" />' . "\n" . '</head>', $html);
      $html = str_replace('</head>', '<script src="' . preg_replace('/^' . preg_quote($_SERVER['DOCUMENT_ROOT'], '/') . '(.*)\/classes/', '$1', __DIR__) . '/js/pwa_installer.js"></script>' . "\n" .'</head>', $html);
      $html = str_replace('</head>', '<link rel="stylesheet" type="text/css" href="' . preg_replace('/^' . preg_quote($_SERVER['DOCUMENT_ROOT'], '/') . '(.*)\/classes/', '$1', __DIR__) . '/css/pwa_installer.css"/>' . "\n" .'</head>', $html);
      $html = str_replace('</body>', '<div class="pwa_installation_banner"><div class="title">' . $this->plugin->txt("install_title", true) . '</div><div class="ctas"><button class="btn btn-default cancel">' . $this->plugin->txt("not_now", true) . '</button><button class="btn btn-primary install">' . $this->plugin->txt("install", true) . '</button></div></div>' . "\n" .'</body>', $html);

      return ["mode" => ilUIHookPluginGUI::REPLACE, "html" => $html];
    }
    
    return ["mode" => ilUIHookPluginGUI::KEEP, "html" => ""];
  }

  function modifyGUI(string $a_comp, string $a_part, array $a_par = []): void
	{
	}
  
}