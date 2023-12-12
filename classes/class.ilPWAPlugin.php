<?php
/**
 * Class ilPWAPlugin
 * @author  Kalamun <rp@kalamun.net>
 * @version $Id$
 */

class ilPWAPlugin extends ilUserInterfaceHookPlugin
{
    const PLUGIN_NAME = "PWA";
    protected static $instance = null;

    public static function getInstance() : self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function __construct(
        \ilDBInterface $db,
        \ilComponentRepositoryWrite $component_repository,
        string $id
    )
    {
        parent::__construct($db, $component_repository, $id);
    }

    public function getPluginName() : string
    {
        return self::PLUGIN_NAME;
    }

}
