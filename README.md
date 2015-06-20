# crowdfunding4oxid
Turn your OXID eShop into a crowdfunding platform

## Installation / Config

1. backup shop and database
2. copy all files to your shop
3. Activate the module
4. Configure module in settings tab

	To display the the crowdfunding widget: "Support Crowdfunding" after the checkout, paste the following code into /out/azure/tpl/page/checkout/thankyou.tpl:

    ``[{assign var="product" value=$order->getOneCrowdfundedArticleOfBasket()}]``
    
    ``[{if $product!= null}]``
    
    ``    [{include file="marm-crowdfunding-support.tpl"}]``
    
    ``[{/if}]``

## Usage

1. Select article in the admin backend / Create new one. Use an article-name that points-out that this article is going to be croudfunded. e.g Crowdfunding: Modul xyz
2. Change to tab "Extended" and save the amount which should be crowdfunded to "Purchase Price", please be aware it's a netto price.
3. Change to tab "Variants" and create Variants, you may name the selection "Crowdfund it". Each variant represents the amount of money a customer is able to crowdfund.
4. Change to tab "Crowdfunding" and activate crowdfunding for this artcile. Please enter an eMail, where a notification should be send to, when the article is financed more than x %.
5. Save it.
     
