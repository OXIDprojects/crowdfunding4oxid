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
class crowdfunding_oxorder extends crowdfunding_oxorder_parent
{
    public function getOneCrowdfundedArticleOfBasket()
    {
        $result = null;

        /* @var oxOrderArticle $oxOrderArticles */
        $oxOrderArticles = $this->getOrderArticles();

        foreach ( $oxOrderArticles as $oxOrderArticle )
        {
            /** @var oxOrderArticle $oxOrderArticle */
            $sArticleId = $oxOrderArticle->getProductId();
            $oArticle = oxNew( "oxArticle" );
            $oArticle->load( $sArticleId );

            if ( $oArticle->isCrowdfundedArticle() )
            {
                $result[ ] = $oArticle;
            }
        }

        if ( $result != null )
        {
            $rand_keys = array_rand( $result, 1 );

            return $result[ $rand_keys ];
        }
        else
        {
            return null;
        }
    }
}
