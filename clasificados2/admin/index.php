<?php


    define('ABS_PATH', str_replace('\\', '/', dirname(dirname($_SERVER['SCRIPT_FILENAME'])) . '/'));
    define('OC_ADMIN', true);

    require_once ABS_PATH . 'oc-load.php';

    if( file_exists(ABS_PATH . '.maintenance') ) {
        define('__OSC_MAINTENANCE__', true);
    }

    // register admin scripts
    osc_register_script('admin-osc', osc_current_admin_theme_js_url('osc.js'), 'jquery');
    osc_register_script('admin-ui-osc', osc_current_admin_theme_js_url('ui-osc.js'), 'jquery');
    osc_register_script('admin-location', osc_current_admin_theme_js_url('location.js'), 'jquery');

    // enqueue scripts
    osc_enqueue_script('jquery');
    osc_enqueue_script('jquery-ui');
    osc_enqueue_script('admin-osc');
    osc_enqueue_script('admin-ui-osc');

    osc_add_hook('admin_footer', array('FieldForm', 'i18n_datePicker') );

    // enqueue css styles
    osc_enqueue_style('jquery-ui', osc_assets_url('css/jquery-ui/jquery-ui.css'));
    osc_enqueue_style('admin-css', osc_current_admin_theme_styles_url('main - copia - copia.css'));

    switch( Params::getParam('page') )
    {
        case('items'):      require_once(osc_admin_base_path() . 'items.php');
                            $do = new CAdminItems();
                            $do->doModel();
        break;
        case('comments'):   require_once(osc_admin_base_path() . 'comments.php');
                            $do = new CAdminItemComments();
                            $do->doModel();
        break;
        case('media'):      require_once(osc_admin_base_path() . 'media.php');
                            $do = new CAdminMedia();
                            $do->doModel();
        break;
        case ('login'):     require_once(osc_admin_base_path() . 'login.php');
                            $do = new CAdminLogin();
                            $do->doModel();
        break;
        case('categories'): require_once(osc_admin_base_path() . 'categories.php');
                            $do = new CAdminCategories();
                            $do->doModel();
        break;
        case('emails'):     require_once(osc_admin_base_path() . 'emails.php');
                            $do = new CAdminEmails();
                            $do->doModel();
             
    
        break;
        case('languages'):  require_once(osc_admin_base_path() . 'languages.php');
                            $do = new CAdminLanguages();
                            $do->doModel();
        break;
        case('admins'):     require_once(osc_admin_base_path() . 'admins.php');
                            $do = new CAdminAdmins();
                            $do->doModel();
        break;
        case('users'):      require_once(osc_admin_base_path() . 'users.php');
                            $do = new CAdminUsers();
                            $do->doModel();
        break;
        case('ajax'):       require_once(osc_admin_base_path() . 'ajax/ajax.php');
                            $do = new CAdminAjax();
                            $do->doModel();
       
       
        break;
        case('stats'):      require_once(osc_admin_base_path() . 'stats.php');
                            $do = new CAdminStats();
                            $do->doModel();
        break;
        case('cfields'):    require_once(osc_admin_base_path() . 'custom_fields.php');
                            $do = new CAdminCFields();
                            $do->doModel();
        break;
        case('upgrade'):    require_once(osc_admin_base_path() . 'upgrade.php');
                            $do = new CAdminUpgrade();
                            $do->doModel();
      
        break;
        default:            //login of oc-admin
                            require_once(osc_admin_base_path() . 'main.php');
                            $do = new CAdminMain();
                            $do->doModel();
							
    }

    /* file end: ./oc-admin/index.php */