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
class marm_crowdfunding_setup extends oxAdminDetails
{
    /**
     * Current class template name
     *
     * @var string
     */
    protected $_sThisTemplate = "marm_crowdfunding_setup.tpl";

    /**
     * saves instance of marm_crowdfunding
     * @var marm_crowdfunding
     */
    protected $_oMarmCrowdfunding = null;

    public function render()
    {
        parent::render();

        $oArticle = oxNew( 'oxarticle' );
        $soxId = $this->getConfig()->getRequestParameter( 'oxid' );
        $oArticle->loadInLang( $this->_iEditLang, $soxId );

        // variant handling
        if ( $oArticle->oxarticles__oxparentid->value )
        {
            $oParentArticle = oxNew( 'oxarticle' );
            $oParentArticle->load( $oArticle->oxarticles__oxparentid->value );
            $this->_aViewData[ "parentarticle" ] = $oParentArticle;
            $this->_aViewData[ "oxparentid" ] = $oArticle->oxarticles__oxparentid->value;
        }

        $this->_aViewData[ 'product' ] = $oArticle;
        $this->_aViewData[ 'oxid' ] = $soxId;
        $this->_aViewData[ 'actlang' ] = $this->_iEditLang;

        return $this->_sThisTemplate;
    }

    /**
     * returns marm_crowdfunding object
     *
     * @param bool $blReset force create new object
     *
     * @return marm_crowdfunding
     */
    public function getMarmCrowdfunding( $blReset = false )
    {
        if ( $this->_oMarmCrowdfunding !== null && !$blReset )
        {
            return $this->_oMarmCrowdfunding;
        }
        $this->_oMarmCrowdfunding = oxNew( 'marm_crowdfunding' );

        return $this->_oMarmCrowdfunding;
    }

    /**
     * returns marm_crowdfunding config array
     * @return array
     */
    public function getConfigValues()
    {
        $oMarmCrowdfunding = $this->getMarmCrowdfunding();

        return $oMarmCrowdfunding->getConfig();
    }

    /**
     * passes given parameters from 'editval' to marm_crowdfunding
     * @return void
     */
    public function save()
    {
        $aParams = $this->getConfig()->getRequestParameter( "editval" );
        $oMarmCrowdfunding = $this->getMarmCrowdfunding();
        $oMarmCrowdfunding->changeConfig( $aParams );
    }
}