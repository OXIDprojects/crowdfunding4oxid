<?php
/**
 * Crowd funding integration in OXID
 *
 * Copyright (c) 2011 Joscha Krug | marmalade.de
 * E-mail: mail@marmalade.de
 * http://www.marmalade.de
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to
 * deal in the Software without restriction, including without limitation the
 * rights to use, copy, modify, merge, publish, distribute, sublicense, and/or
 * sell copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS
 * IN THE SOFTWARE.
 */
class marm_crowdfunding
{
    const VERSION = '0.6';

    protected $_config_entry_name = 'cf';

    protected $_aConfig = array(
        'enable'              => array(
            'value'      => 'no',
            'input_type' => 'select',
            'options'    => array( 'yes', 'no' )
        ),
        'email'               => array(
            'value'      => '',
            'input_type' => 'text'
        ),
        'notificationPercent' => array(
            'value'      => '100',
            'input_type' => 'text'
        )
    );

    public function __construct( $sOXID = null )
    {
        // get oxid of current article
        if ( $sOXID == null )
        {
            $sOXID = oxRegistry::getConfig()->getRequestParameter( 'oxid' );
        }

        // generate unique key from oxID
        $sOXID   = str_replace( array( 'a', 'b', 'c', 'd', 'e', 'f' ), array( 'z', 'x', 'y', 'w', 'l', 'n' ), $sOXID );

        $this->_config_entry_name = $sOXID;

        // load config
        $this->_loadConfig();
    }

    /**
     * returns current version of marm_crowdfunding class
     * @return string
     */
    public function getVersion()
    {
        return self::VERSION;
    }

    /**
     * Loads the settings
     */
    protected function _loadConfig()
    {
        $aSavedConfig = oxRegistry::getConfig()->getShopConfVar( $this->_config_entry_name );

        if ( $aSavedConfig && count( $aSavedConfig ) == count( $this->_aConfig ) )
        {
            $this->_aConfig = $aSavedConfig;
        }
        else
        {
            $this->_saveConfig();
        }

    }

    /**
     * Saves the settings
     */
    protected function _saveConfig()
    {
        oxRegistry::getConfig()->saveShopConfVar( 'arr', $this->_config_entry_name, $this->_aConfig );
    }

    /**
     * Returns the current settings
     * @return array
     */
    public function getConfig()
    {
        return $this->_aConfig;
    }

    /**
     * @param $aNewValues
     *
     * @return bool
     */
    public function changeConfig( $aNewValues )
    {
        $blChanged = false;
        foreach ( $aNewValues as $sKey => $sNewValue )
        {
            if ( isset( $this->_aConfig[ $sKey ] ) )
            {
                $blChanged = true;
                $this->_aConfig[ $sKey ][ 'value' ] = $sNewValue;
            }
        }
        if ( $blChanged )
        {
            $this->_saveConfig();
        }

        return $blChanged;
    }

    /**
     * Returns a single settings value
     * @param $sValue
     *
     * @return mixed
     */
    public function getConfigValue( $sValue )
    {
        if ( isset( $this->_aConfig[ $sValue ] ) && isset( $this->_aConfig[ $sValue ][ 'value' ] ) )
        {
            return $this->_aConfig[ $sValue ][ 'value' ];
        }
    }

    /**
     * returns whether crowdfunding is activated or not
     * @return boolean
     */
    public function crowdFundingIsActivated()
    {
        return ( $this->getConfigValue( 'enable' ) == "yes" ? true : false );
    }

    /**
     * disable status notification for shop owner,
     * setting the notification limit to 101%
     */
    public function disableNotification()
    {
        // to disable notification, we set notification limit to 101%
        $this->changeConfig( array( 'notificationPercent' => 101 ) );
    }
}
