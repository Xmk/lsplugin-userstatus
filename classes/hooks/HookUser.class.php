<?php
/*-------------------------------------------------------
*
*   Plugin name:    Userstatus
*   Author:         Chiffa
*   Web:            http://goweb.pro
*
---------------------------------------------------------
*/

/**
 * Регистрация хуков
 *
 */
class PluginUserstatus_HookUser extends Hook
{

    public function RegisterHook()
    {
        $this->AddHook('template_user_header_end', 'UserHeaderEnd');
        $this->AddHook('template_activity_event_update_status', 'ActivityEventUpdateStatus');
    }

    public function UserHeaderEnd($aParams = [])
    {
        $oUserProfile = isset($aParams['user']) ? $aParams['user'] : null;
        $oUserCurrent = $this->User_GetUserCurrent();
        if ($oUserProfile) {
            $oUserStatus = $this->PluginUserstatus_User_GetStatusByUserId($oUserProfile->getId());
            $this->Viewer_Assign('user', $oUserProfile, true);
            $this->Viewer_Assign('status', $oUserStatus, true);
            return $this->Viewer_Fetch("Component@userstatus:user.status");
        }
    }

    public function ActivityEventUpdateStatus($aParams = [])
    {
        if (isset($aParams['event'])) {
            $this->Viewer_Assign('event', $aParams['event'], true);
            return $this->Viewer_Fetch("Component@userstatus:activity.event_status");
        }
    }

}
