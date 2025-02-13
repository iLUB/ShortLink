<?php

declare(strict_types=1);

use ILIAS\HTTP\Wrapper\ArrayBasedRequestWrapper;
use ILIAS\Refinery\Factory;

require_once './Services/UIComponent/classes/class.ilUIHookPluginGUI.php';
require_once './Customizing/global/plugins/Services/UIComponent/UserInterfaceHook/ShortLink/classes/class.ilShortLinkPlugin.php';
require_once './Customizing/global/plugins/Services/UIComponent/UserInterfaceHook/ShortLink/classes/class.ilObjShortLink.php';
include_once 'Customizing/global/plugins/Services/UIComponent/UserInterfaceHook/ShortLink/classes/class.ilShortLinkTableGUI.php';

/**
 * Class ilShortLinkUIHookGUI
 *
 * @author  Thomas Kolonko <thomas.kolonko@ilub.unibe.ch>
 * @version 0.0.1
 *
 *
 */
class ilShortLinkUIHookGUI extends ilUIHookPluginGUI
{
    protected ilCtrl $ctrl;
   // protected ilTabsGUI $tabs;
    protected ilAccessHandler $access;
    protected ilShortLinkPlugin $pl;
    protected ilObjShortLink $objShortLink;
    protected ArrayBasedRequestWrapper $http_query;
    protected Factory $http_trans;


    /**
     * ilShortLinkUIHookGUI constructor
     *
     */
    public function __construct()
    {
        global $DIC;

        $this->ctrl = $DIC->ctrl();
        $this->access = $DIC->access();
        $this->http_query = $DIC->http()->wrapper()->query();
        $this->http_trans = $DIC->refinery();

        $this->pl = ilShortLinkPlugin::getInstance();

        $this->objShortLink = new ilObjShortLink();

    }
    public function getHTML(string $a_comp, string $a_part, array $a_par = []): array
    {

        return ['mode' => ilUIHookPluginGUI::KEEP, 'html' => ''];
    }

    /**
     * Redirects the user to the ShortLink Plugin if cmdNode is found. Otherwise
     * the user is redirected to ilPersonalDesktopGUI and an error message is shown.
     * @throws ilCtrlException
     */
    public function gotoHook(): void
    {
        if (preg_match('/^ShortLink(.*)/', $this->http_query->has('target')? $this->http_query->retrieve('target', $this->http_trans->kindlyTo()->string()):'' )) {
            $this->ctrl->initBaseClass('ilUIPluginRouterGUI');
            $this->ctrl->setTargetScript('ilias.php');
            $this->ctrl->redirectByClass(['ilUIPluginRouterGUI', 'ilShortLinkGUI'], 'listShortLinks');
        }

    }
}
