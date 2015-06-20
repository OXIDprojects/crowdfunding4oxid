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
class crowdfunding_oxemail extends crowdfunding_oxemail_parent
{

    /**
     * Crowdfunding status notification for shop owner HTML template
     *
     * @var string
     */
    protected $_sMarmCrowdfundingStatusTemplate = "email/html/email_crowdfunding_status.tpl";

    /**
     * Crowdfunding status notification for shop owner plain text template
     *
     * @var string
     */
    protected $_sMarmCrowdfundingStatusPlainTemplate = "email/plain/email_crowdfunding_status.tpl";


    /**
     * Sets mailer additional settings and sends ordering mail to user.
     * If a crowdfunding notification is needed, a status email is send to the shop owner.
     * Returns true on success.
     *
     * @param oxOrder $oOrder   Order object
     * @param string  $sSubject user defined subject [optional]
     *
     * @return bool
     */
    public function sendOrderEmailToUser( $oOrder, $sSubject = null )
    {
        /* @var oxEmail $this */

        $result = parent::sendOrderEmailToUser( $oOrder, $sSubject );

        // Check whether one article was crowdfundable
        $this->sendCrowdfundingStatusEmailToShopOwner( $oOrder, $sSubject );

        return $result;
    }

    private function sendCrowdfundingStatusEmailToShopOwner( $oOrder, $sSubject = null )
    {
        /** @var oxEmail $this */
        $this->_clearMailer();

        /** @var oxOrder $oOrder */
        /** @var oxBasket $oBasket */
        $oBasket = $oOrder->getBasket();
        $oBasketArticles = $oBasket->getBasketArticles();

        foreach ( $oBasketArticles as $oProduct )
        {
            /** @var oxArticle $oProduct */
            if ( $oProduct->isCrowdfundedArticle() )
            {
                if ( $oProduct->displayCrowdfundingStatus() >= $oProduct->getCrowdfundingNotficationLimit() )
                {
                    //email senden
                    $oConfig    = $this->getConfig();
                    $oShop      = $this->getShop();
                    $oLang      = oxRegistry::getLang();
                    $iOrderLang = $oLang->getObjectTplLanguage();

                    // if running shop language is different from admin lang. set in config
                    // we have to load shop in config language
                    if ( $oShop->getLanguage() != $iOrderLang )
                    {
                        /** @var oxShop $oShop */
                        $oShop = $oShop->loadInLang( $iOrderLang, $oShop->getId() );
                    }

                    //set mail params (from, fromName, smtp)
                    $this->_setMailParams( $oShop );

                    // create messages
                    $oSmarty = $this->_getSmarty();
                    $oSmarty->assign( "charset", $oLang->translateString( "charset" ) );
                    $oSmarty->assign( "article", $oProduct );
                    $oSmarty->assign( "lang", $oLang );
                    $oSmarty->assign( "shop", $oShop );
                    $oSmarty->assign( "oViewConf", $oShop );
                    $oSmarty->assign( "currency", $oConfig->getActShopCurrencyObject() );

                    $oOutputProcessor = oxNew( "oxoutput" );
                    $aNewSmartyArray = $oOutputProcessor->processViewArray( $oSmarty->get_template_vars(), "oxemail" );
                    foreach ( $aNewSmartyArray as $key => $val )
                    {
                        $oSmarty->assign( $key, $val );
                    }

                    $this->setBody( $oSmarty->fetch( $oConfig->getTemplatePath( $this->_sMarmCrowdfundingStatusTemplate, false ) ) );
                    $this->setAltBody( $oSmarty->fetch( $oConfig->getTemplatePath( $this->_sMarmCrowdfundingStatusPlainTemplate, false ) ) );

                    //Sets subject to email
                    // #586A
                    if ( $sSubject === null )
                    {
                        $sSubject = $oLang->translateString( 'MARM_CROWDFUNDING_STATUSEMAIL_HEADER' ) . " " . $oProduct->getCrowdfundingArticleName();
                    }

                    $this->setSubject( $sSubject );
                    $this->setRecipient( $oProduct->getCrowdfundingNotficationEmail(), $oProduct->getCrowdfundingNotficationEmail() );

                    $blSuccess = $this->send();

                    if ( $blSuccess )
                    {
                        // disable further crowdfunding notification
                        $oProduct->disableCrowdfundingNotfication();
                    }
                }
            }
        }
    }
}
