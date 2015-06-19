# crowdfunding4oxid
Turn your OXID eShop into a crowdfunding platform

Originally coded for OXID eShop v < 4.5 & basic theme. Needs to be updated for present versions.

#########################
## Installation / Config #
#########################


1) backup shop and database

#####
2) copy all files to your shop

#####	
3) Add the following module-entries in your configuration

	oxorder => marm/crowdfunding/crowdfunding_oxorder
	oxarticle => marm/crowdfunding/crowdfunding_oxarticle
	oxemail => marm/crowdfunding/crowdfunding_oxemail
	details => marm/crowdfunding/crowdfunding_details

#####	
4) To show the crowdfunding progress on detail pages, paste the following code into /out/basic/tpl/details.tpl:
 
	     [{if $product->isCrowdfundedArticle()}]
			[{include file="mm-crowdfunding-status.tpl"}]
		 [{/if}]
	 
   To display the explanation, what crowd funding is, paste the following code into /out/basic/tpl/details.tpl:
	 
		 [{if $product->isCrowdfundedArticle()}]
				[{include file="mm-crowdfunding-explanation.tpl"}]
		 [{/if}]
		 
   To display the crowdfunding widget: "Support Crowdfunding" paste the following code into 
   /out/basic/tpl/details.tpl:
   
	    [{if $product->isCrowdfundedArticle()}]
			[{include file="marm-crowdfunding-support.tpl"}]
		[{/if}]
		
	To display the the crowdfunding widget: "Support Crowdfunding" after the checkout, paste the following 
	code into /out/basic/tpl/thankyou.tpl:
	
	  [{assign var="product" value=$order->getOneCrowdfundedArticleOfBasket()}]
	  [{if $product!= null}]
		[{include file="marm-crowdfunding-support.tpl"}]
	  [{/if}]

#####
5) Insert CSS in your stylesheet.
   The default frontend stylesheet can be found at out/basic/src/oxid.css.
    
		/* Crowdfunding */
		#crowdfunding-status{margin: 10px 0px; font-size: 10px;}
		#crowdfunding-progress-bar{width: 100%;	height: 20px; line-height: 20px; border: 1px solid #555555;}
		#crowdfunding-progress{display: block; height: 20px; text-align: center;}
		#crowdfunding-ltext{display: block;	width: 100%; margin-top: -20px; text-align: center;}
		.cf-green{ background-color: #00AB1F; }
		.cf-orange{	background-color: #FFB200; }
		.cf-red{ background-color: #FF0000; }

#####
6) Clean your language cache (cleanup eShop tmp directory)


#########################
## USAGE                 #
#########################

1) Select article in the admin backend / Create new one
   Use an article-name that points-out that this article is going to be croudfunded. e.g Crowdfunding: Modul xyz 
   
#####
2) Change to tab "Extended" and save the amount which should be crowdfunded to "Purchase Price", please be aware it's a netto price.

#####
3) Change to tab "Variants" and create Variants, you may name the selection "Crowdfund it".
   Each variant represents the amount of money a customer is able to crowdfund.

#####
4) Change to tab "Crowdfunding" and activate crowdfunding for this artcile.
   Please enter an eMail, where a notification should be send to, when the article is financed more than x %.
   Save it.
     
