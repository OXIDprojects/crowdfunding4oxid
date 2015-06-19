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
	protected $_sMarmCrowdfundingStatusTemplate          = "email_crowdfunding_status_html.tpl";

	/**
	 * Crowdfunding status notification for shop owner plain text template
	 *
	 * @var string
	 */
	protected $_sMarmCrowdfundingStatusPlainTemplate     = "email_crowdfunding_status_plain.tpl";



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
		/* @var $this oxEmail */
			
		$result = parent::sendOrderEmailToUser( $oOrder, $sSubject = null);
			
		// Check whether one article was crowdfundable
		$this->sendCrowdfundingStatusEmailToShopOwner($oOrder, $sSubject = null);
			
		return $result;
	}

	private function sendCrowdfundingStatusEmailToShopOwner($oOrder, $sSubject = null)
	{
		// cleanup
		$this->_clearMailer();
			
		/* @var $oOrder oxOrder */
		/* @var $basket oxBasket */
		$basket = $oOrder->getBasket();
		$articles = $basket->getBasketArticles();		

		foreach($articles as $oArticle){
			/* @var $oArticle oxArticle */
			
			if($oArticle->isCrowdfundedArticle()){
				if($oArticle->displayCrowdfundingStatus() >= $oArticle->getCrowdfundingNotficationLimit()){
					//email senden

					$myConfig = $this->getConfig();

					$oShop = $this->_getShop();

					$oLang = oxLang::getInstance();
					$iOrderLang = $oLang->getObjectTplLanguage();

					// if running shop language is different from admin lang. set in config
					// we have to load shop in config language
					if ( $oShop->getLanguage() != $iOrderLang ) {
						/* @var $oShop oxshop */
						$oShop = $this->_getShop( $iOrderLang );
					}
					
					//set mail params (from, fromName, smtp)
			        $this->_setMailParams( $oShop );

					// create messages
					$oSmarty = $this->_getSmarty();
					$oSmarty->assign( "charset", $oLang->translateString("charset"));
					$oSmarty->assign( "article", $oArticle );
					$oSmarty->assign( "lang", $oLang ); 
					$oSmarty->assign( "shop", $oShop );
					$oSmarty->assign( "oViewConf", $oShop );
					$oSmarty->assign( "currency", $myConfig->getActShopCurrencyObject() );
					
					$oOutputProcessor = oxNew( "oxoutput" );
					$aNewSmartyArray = $oOutputProcessor->processViewArray($oSmarty->get_template_vars(), "oxemail");
					foreach ($aNewSmartyArray as $key => $val)
						$oSmarty->assign( $key, $val );

					$this->setBody( $oSmarty->fetch( $myConfig->getTemplatePath( $this->_sMarmCrowdfundingStatusTemplate, false ) ) );
					$this->setAltBody( $oSmarty->fetch( $myConfig->getTemplatePath( $this->_sMarmCrowdfundingStatusPlainTemplate, false ) ) );

					//Sets subject to email
					// #586A
					if ( $sSubject === null ) {
						$sSubject = $oLang->translateString('MARM_CROWDFUNDING_STATUSEMAIL_HEADER')." ".$oArticle->getCrowdfundingArticleName();
					}

					$this->setSubject( $sSubject );
					$this->setRecipient( $oArticle->getCrowdfundingNotficationEmail(), $oArticle->getCrowdfundingNotficationEmail() );


					$blSuccess = $this->send();

					if($blSuccess){
						// disable further crowdfunding notification
						$oArticle->disableCrowdfundingNotfication();
					}
				}
			}
		}
	}
}
