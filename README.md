# ILIAS PWA
This plug-in will enable ILIAS to be installed as a Progressive Web Application.

Copyright (c) 2023 Roberto Pasini <bonjour@kalamun.net>
GPLv3, see LICENSE

Author: Roberto Pasini <bonjour@kalamun.net>

## Install

```
mkdir -p Customizing/global/plugins/Services/UIComponent/UserInterfaceHook
cd Customizing/global/plugins/Services/UIComponent/UserInterfaceHook
git clone https://github.com/kalamun/ILIAS-PWA-Plugin.git PWA
```

Then go to Administration > Extending ILIAS > Plugins and select “Install” from the PWA plugin actions menu.
![image](https://github.com/kalamun/ILIAS-PWA-Plugin/assets/385026/1cf1da22-e894-4ed0-bd22-faf9868f3909)
Then, from the same menu, select “Activate”.
And finally, still from the same menu, “Configure”.

There you can fill the parameters for your WebApp, choose the icons (in PNG) and “Save”.
![image](https://github.com/kalamun/ILIAS-PWA-Plugin/assets/385026/58243fe5-c03c-4423-a98f-0d3f5b7ff605)




## Requirements
This plugin is compatible with ILIAS v8.x

For ILIAS v7. support, check the ilias_7 branch
