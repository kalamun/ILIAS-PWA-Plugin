<?php

/**
 * Class ilPWAUIHookGUI
 * @author            Kalamun <rp@kalamun.net>
 * @version $Id$
 * @ingroup ServicesUIComponent
 * @ilCtrl_isCalledBy ilPWAUIHookGUI: ilUIPluginRouterGUI, ilAdministrationGUI, ilPWAGUI
 */

class ilPWAUIHookGUI extends ilUIHookPluginGUI {

  public function __construct()
  {
  }
  
	function getHTML($a_comp = false, $a_part = false, $a_par = array()) {
    if($a_part == "template_get" && strpos($a_par["tpl_id"], "standardpage.html") !== false) {
      $html = $a_par["html"];
      $html = str_replace('<body', '<link rel="manifest" href="/manifest.json" />' . "\n" .'<body', $html);
      return ["mode" => ilUIHookPluginGUI::REPLACE, "html" => $html];
    }
    
    return ["mode" => ilUIHookPluginGUI::KEEP, "html" => ""];
  }

  function modifyGUI($a_comp, $a_part, $a_par = array())
	{
	}
  
}