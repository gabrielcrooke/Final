<?php



    /**
     * Gets database name
     *
     * @return string
     */
    function osc_db_name() {
        return getSiteInfo('s_db_name', DB_NAME);
    }

    /**
     * Gets database host
     *
     * @return string
     */
    function osc_db_host() {
        return getSiteInfo('s_db_host', DB_HOST);
    }

    /**
     * Gets database user
     *
     * @return string
     */
    function osc_db_user() {
        return getSiteInfo('s_db_user', DB_USER);
    }

    /**
     * Gets database password
     *
     * @return string
     */
    function osc_db_password() {
        return getSiteInfo('s_db_password', DB_PASSWORD);
    }

    /**
     * Gets multisite url
     *
     * @return string
     */
    function osc_multisite_url() {
        if( getSiteInfo('s_site_mapping', '') !== '' ) {
            return getSiteInfo('s_site_mapping', '');
        }
        return getSiteInfo('s_site', '');
    }

    /**
     * Gets multisite url
     *
     * @return string
     */
    function osc_multisite_upload_path() {
        return getSiteInfo('s_upload_path', '');
    }

    //PRIVATE FUNCTION FOR GETTING NO BOOLEAN INFORMATION (if there was a class :P)
    /**
     * Gets site info
     *
     * @param string $key
     * @param string $default_value
     * @return string
     */
    function getSiteInfo($key, $default_value) {
        if (MULTISITE) {
            $_P = SiteInfo::newInstance();
            return($_P->get($key));
        }

        return $default_value;
    }
?>
