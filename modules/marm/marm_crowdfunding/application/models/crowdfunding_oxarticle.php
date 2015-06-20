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
class crowdfunding_oxarticle extends crowdfunding_oxarticle_parent
{

    /**
     * Current crowdfunding status in percent (0 - 100)
     * @var number
     */
    private $_crowdfundingStatus = null;

    /**
     * String containing all customers email addresses, one per line
     * @var string
     */
    private $_customerEmails = null;

    /**
     * Number of Customers, who already crowdfunded the article
     * @var number
     */
    private $_customerCount = -1;

    /**
     * Instance of the marm_crowdfunding object
     * @var marm_crowdfunding
     */
    private $_oMarmCrowdfunding = null;

    /**
     * Amount of money which is already crowdfunded
     * @var number
     */
    private $_crowdfundedAmount = null;

    /**
     * Amount of money which should be crowdfunden
     * @var number
     */
    private $_amountToCrowdfund = null;


    /**
     * Get Crowdfunding-Object, initialize it if nessesarry.
     *
     * @param boolean $blReset
     *
     * @return marm_crowdfunding
     */
    public function getMarmCrowdfunding( $blReset = false )
    {
        /** @var oxArticle $this */
        if ( $this->_oMarmCrowdfunding !== null && !$blReset )
        {
            return $this->_oMarmCrowdfunding;
        }

        /** @var oxArticle $oProduct */
        $oProduct = $this->getCrowdfundingArticle();
        $this->_oMarmCrowdfunding = oxNew( 'marm_crowdfunding', $oProduct->getId() );

        return $this->_oMarmCrowdfunding;
    }

    /**
     * Returns always the parent article, if there is no parentArticle returns $this.
     * @return oxArticle
     */
    protected function getCrowdfundingArticle()
    {
        // current article is parent or child, save parent to $cur
        if ( strlen( $this->getProductParentId() ) == 0 )
        {
            return $this;
        }
        else
        {
            return $this->getParentArticle();
        }
    }

    /**
     * Returns whether crowdfunding is activated for this article or not.
     * @return boolean
     */
    public function isCrowdfundedArticle()
    {
        return $this->getMarmCrowdfunding()->crowdFundingIsActivated();
    }


    /**
     * @return float|int|number
     */
    public function displayCrowdfundingStatus()
    {
        /** @var oxArticle $this */

        if ( is_null( $this->_crowdfundingStatus ) )
        {
            // get EKP
            $EKP = $this->getAmountToCrowdfund();

            //get already crowdfounded amount
            $crowdfundedAmount = $this->getCrowdfundedAmount();

            // calculate status in percent
            $percent = round( 100 / $EKP * $crowdfundedAmount, 0 );

            // set status to 100% if bigger than 100%
            if ( $percent > 100 )
            {
                $percent = 100;
            }

            $this->_crowdfundingStatus = $percent;
        }

        return $this->_crowdfundingStatus;
    }

    public function displayCustomerEmails()
    {
        /** @var oxarticle $this */
        if ( is_null( $this->_customerEmails ) )
        {
            // get oxChildren
            $children = $this->_getVariantsIds();

            $sSQL = 'SELECT DISTINCT OXBILLEMAIL, OXBILLFNAME, OXBILLLNAME, OXBILLCOMPANY FROM oxorderarticles b, oxorder a WHERE a.OXID = b.OXORDERID AND (b.OXARTID = "' . $this->getId() . '" OR b.OXARTID = "' . implode( '" OR b.OXARTID = "', $children ) . '") AND a.OXSTORNO = 0 AND a.OXTRANSSTATUS = "OK" ';
            echo $sSQL;
            $rows = oxDb::getDb()->query( $sSQL );


            $result = "";
            $this->_customerCount = 0;

            if ( $rows != false && $rows->recordCount() > 0 )
            {
                while ( !$rows->EOF )
                {
                    if ( $rows->fields[ 3 ] != null )
                    {
                        $company = $rows->fields[ 3 ] . " - ";
                    }

                    $result = $result . "<" . $rows->fields [ 0 ] . "> " . $company . $rows->fields [ 1 ] . " " . $rows->fields [ 2 ] . "; \n";
                    $this->_customerCount++;
                    $rows->moveNext();
                }
            }
            $this->_customerEmails = $result;
        }

        return $this->_customerEmails;
    }

    public function getNumberOfCustomers()
    {
        // displayCustomerEmails was not called before, call it
        if ( $this->_customerCount == -1 )
        {
            $this->displayCustomerEmails();
        }

        return $this->_customerCount;
    }

    /**
     * Return whether an article can be crowdfunded or not. Only articles which are no variants can be crowdfunded.
     * @return boolean
     */
    public function isCrowdfundable()
    {
        /** @var oxarticle $this */
        return ( $this->oxarticles__oxparentid->value == null ? true : false );
    }

    /**
     * Returns the status in percent the shop owner should be informed
     * @return number
     */
    public function getCrowdfundingNotficationLimit()
    {
        return $this->getMarmCrowdfunding()->getConfigValue( 'notificationPercent' );
    }

    /**
     * Returns the email, notifications concerning the crowdfunding progress should be send to
     * @return string
     */
    public function getCrowdfundingNotficationEmail()
    {
        return $this->getMarmCrowdfunding()->getConfigValue( 'email' );
    }

    /**
     * Disable crowdfunding status notification for current article
     * @return void
     */
    public function disableCrowdfundingNotfication()
    {
        $this->getMarmCrowdfunding()->disableNotification();
    }

    /**
     * Get the article name of the crowdfunded article
     * @return string
     */
    public function getCrowdfundingArticleName()
    {
        return $this->getCrowdfundingArticle()->oxarticles__oxtitle->value;
    }

    /**
     * Get the article number of the crowdfunded article.
     * @return string
     */
    public function getCrowdfundingArticleNumber()
    {
        return $this->getCrowdfundingArticle()->oxarticles__oxartnum->value;
    }


    /**
     * Get the amount of money which should be crowdfunded.
     * @return number
     */
    public function getAmountToCrowdfund()
    {
        if ( is_null( $this->_amountToCrowdfund ) )
        {
            $sArticleView = getViewName( 'oxarticles' );
            $oProduct = $this->getCrowdfundingArticle();

            $this->_amountToCrowdfund = oxDb::getDb()->getOne( 'SELECT `OXBPRICE` FROM `' . $sArticleView . '` WHERE `OXID` = "' . $oProduct->getId() . '"' );
        }

        return round( $this->_amountToCrowdfund, 2 );
    }

    /**
     * Get the amount of money which is already crowdfunded.
     * @return number
     */
    public function getCrowdfundedAmount()
    {
        if ( is_null( $this->_crowdfundedAmount ) )
        {
            /** @var oxArticle $oProduct */
            $oProduct = $this->getCrowdfundingArticle();

            // get variants
            $variants = $oProduct->_getVariantsIds();

            // calculate already paid money
            $query = 'SELECT OXAMOUNT, OXNETPRICE FROM oxorderarticles b, oxorder a WHERE a.OXID = b.OXORDERID AND (b.OXARTID = "' . implode( '" OR b.OXARTID = "', $variants ) . '") AND a.OXSTORNO = 0 AND a.OXTRANSSTATUS = "OK"';
            $rows = oxDb::getDb()->Execute( $query );

            // set result zero
            $result = 0;

            if ( $rows != false && $rows->recordCount() > 0 )
            {
                while ( !$rows->EOF )
                {
                    $result += $rows->fields [ 0 ] * $rows->fields [ 1 ];
                    $rows->moveNext();
                }
            }

            $this->_crowdfundedAmount = round( $result, 2 );
        }

        return $this->_crowdfundedAmount;
    }

    /**
     * Returns the difference between the amount which should be crowdfunded and the already crowdfunded amount.
     * If it is smaller than zero, more money was crowdfunded as necessary.
     * @return number
     */
    public function getCrowdfundingDifference()
    {
        return round( $this->getAmountToCrowdfund() - $this->getCrowdfundedAmount(), 2 );
    }

}