<?php
    
    osc_add_hook('header','bender_nofollow_construct');

    bender_add_body_class('forgot');
    osc_current_web_theme_path('header.php');
?>
<div class="form-container form-horizontal form-container-box">
    <div class="header">
        <h1><?php _e('Recupera tu contraseña', 'bender'); ?></h1>
    </div>
    <div class="resp-wrapper">
        <form action="<?php echo osc_base_url(true); ?>" method="post" >
            <input type="hidden" name="page" value="login" />
            <input type="hidden" name="action" value="forgot_post" />
            <input type="hidden" name="userId" value="<?php echo osc_esc_html(Params::getParam('userId')); ?>" />
            <input type="hidden" name="code" value="<?php echo osc_esc_html(Params::getParam('code')); ?>" />
            <div class="control-group">
                <label class="control-label" for="new_password"><?php _e('Nueva contraseña', 'bender'); ?></label>
                <div class="controls">
                    <input type="password" name="new_password" value="" autocomplete="off" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="new_password2"><?php _e('Repite nueva contraseña', 'bender'); ?></label>
                <div class="controls">
                    <input type="password" name="new_password2" value="" autocomplete="off" />
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="ui-button ui-button-middle ui-button-main"><?php _e("Cambiar contraseña", 'bender');?></button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php osc_current_web_theme_path('footer.php') ; ?>