<?php if ( ! defined('ABS_PATH')) exit('ABS_PATH is not loaded. Direct access is not allowed.');



    class CAdminSettingsLatestSearches extends AdminSecBaseModel
    {
        //Business Layer...
        function doModel()
        {
            switch($this->action) {
                case('latestsearches'):
                    //calling the comments settings view
                    $this->doView('settings/searches.php');
                break;
                case('latestsearches_post'):
                    // updating comment
                    osc_csrf_check();
                    if( Params::getParam('save_latest_searches') == 'on' ) {
                        osc_set_preference('save_latest_searches', 1);
                    } else {
                        osc_set_preference('save_latest_searches', 0);
                    }

                    if(Params::getParam('customPurge')=='') {
                        osc_add_flash_error_message(_m('Custom number could not be left empty'), 'admin');
                        $this->redirectTo(osc_admin_base_url(true) . '?page=settings&action=latestsearches');
                    } else {
                        osc_set_preference('purge_latest_searches', Params::getParam('customPurge'));

                        osc_add_flash_ok_message( _m('Last search settings have been updated'), 'admin');
                        $this->redirectTo(osc_admin_base_url(true) . '?page=settings&action=latestsearches');
                    }
                break;
            }
        }
    }

    // EOF: ./oc-admin/controller/settings/latestsearches.php