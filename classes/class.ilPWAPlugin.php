<?php
/**
 * Class ilPWAPlugin
 * @author  Kalamun <bonjour@kalamun.net>
 * @version $Id$
 */

class ilPWAPlugin extends ilUserInterfaceHookPlugin
{
    const PLUGIN_NAME = "PWA";
    const CTYPE = "Services";
    const CNAME = "UIComponent";
    const SLOT_ID = "uihk";
    protected static $instance = null;


    public function __construct(
        \ilDBInterface $db,
        \ilComponentRepositoryWrite $component_repository,
        string $id
    )
    {
        $this->db = $db;
        $this->component_repository = $component_repository;
        $this->id = $id;
        parent::__construct($db, $component_repository, $id);
    }

    public static function getInstance(): self
    {
        global $DIC;

        if (self::$instance instanceof self) {
            return self::$instance;
        }

        $component_repository = $DIC['component.repository'];
        $component_factory = $DIC['component.factory'];

        $plugin_info = $component_repository->getComponentByTypeAndName(
            self::CTYPE,
            self::CNAME
        )->getPluginSlotById(self::SLOT_ID)->getPluginByName(self::PLUGIN_NAME);

        self::$instance = $component_factory->getPlugin($plugin_info->getId());

        return self::$instance;
    }

    public function getPluginName() : string
    {
        return self::PLUGIN_NAME;
    }

}
