[{assign var="template_location" value=""}]
[{assign var="blSep" value=""}]
[{foreach from=$oView->getCatTreePath() item=oCatPath}]
    [{if $blSep == "y"}]
        [{assign var="template_location" value=$template_location|cat:" / "}]
    [{/if}]
    [{assign var="template_location" value=$template_location|cat:"<a href=\""|cat:$oCatPath->getLink()|cat:"\">"|cat:$oCatPath->oxcategories__oxtitle->value|cat:"</a>"}]
    [{assign var="blSep" value="y"}]
[{/foreach}]
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html[{if $oView->getActiveLangAbbr()}] lang="[{$oView->getActiveLangAbbr()}]"[{/if}]>
    <head>
        [{assign var="_titlesuffix" value=$_titlesuffix|default:$oView->getTitleSuffix()}]
        [{assign var="_titleprefix" value=$_titleprefix|default:$oView->getTitlePrefix()}]
        [{assign var="title" value=$title|default:$oView->getTitle()}]
        <title>[{$_titleprefix}][{if $title && $_titleprefix}] | [{/if}][{$title|strip_tags}][{if $_titlesuffix}] | [{$_titlesuffix}][{/if}][{if $titlepagesuffix}] | [{$titlepagesuffix}][{/if}]</title>
        <meta http-equiv="Content-Type" content="text/html; charset=[{$charset}]">
        <meta name="ROBOTS" content="NOINDEX, NOFOLLOW">
        [{if $oView->getMetaDescription()}]
            <meta name="description" content="[{$oView->getMetaDescription()}]">
        [{/if}]
        [{if $oView->getMetaKeywords()}]
            <meta name="keywords" content="[{$oView->getMetaKeywords()}]">
        [{/if}]
        <link rel="shortcut icon" href="[{$oViewConf->getBaseDir()}]favicon.ico">
        <link rel="stylesheet" type="text/css" href="[{$oViewConf->getResourceUrl()}]css/oxid.css">
        <link rel="stylesheet" type="text/css" href="[{$oViewConf->getModuleUrl('marm','marm_crowdfunding/out/src/css/style.css')}]">
        <style type="text/css">
            #body .product.head strong.h4.big {
                padding-right: 16px;
                width: 90%;
            }

            #body .product.big {
                padding-left: 10px;
            }

            #product_img {
                float: left;
                margin: 5px;
            }

            #body .product.details {
                min-height: 195px;
            }

            .stockFlag { padding-left:20px; }
        </style>
    </head>
    <body>
        <div id="body" class="[{$cssclass|default:"plain"}]">
            <!-- ox_mod01 details -->
            [{assign var="currency" value=$oView->getActCurrency()}]
            [{assign var="product" value=$oView->getProduct()}]

            <div class="hreview-aggregate">
                <div class="product item hproduct details head big">
                    [{if $product->displayCrowdfundingStatus() <= 33}]
                        [{assign var="cf_color" value="cf-red"}]
                    [{elseif $product->displayCrowdfundingStatus() <= 66}]
                        [{assign var="cf_color" value="cf-orange"}]
                    [{else}]
                        [{assign var="cf_color" value="cf-green"}]
                    [{/if}]

                    <div id="crowdfunding-status">
                        <strong id="test_detailsHeader" class="h4 big"><a href="[{$product->getBaseSeoLink($oLang)}]" target="_blank">[{oxmultilang ident="MARM_CROWDFUNDING_STATUS_HEADER"}]</a></strong>

                        <div id="crowdfunding-progress-bar">
                            <span id="crowdfunding-progress" class="[{$cf_color}]" style="width: [{$product->displayCrowdfundingStatus()}]%"></span>
                            <span id="crowdfunding-ltext">[{$product->displayCrowdfundingStatus()}]%</span>
                        </div>
                    </div>

                    <a href="[{$product->getBaseSeoLink($oLang)}]" target="_blank">
                        <img src="[{$product->getThumbnailUrl()}]" id="product_img" class="photo" alt="[{$product->oxarticles__oxtitle->value|strip_tags}] [{$product->oxarticles__oxvarselect->value|default:''}]">
                    </a>

                    <h1 id="test_product_name" class="fn">
                        <a href="[{$product->getBaseSeoLink($oLang)}]" target="_blank">[{$product->oxarticles__oxtitle->value}] [{$product->oxarticles__oxvarselect->value}]</a>
                    </h1>

                    <span class="type" title="sku">[{oxmultilang ident="ARTNUM"}]</span>
                    <span class="value">[{$product->oxarticles__oxartnum->value}]</span>

                    <div class="status">

                        [{if $product->getStockStatus() == -1}]
                            <span class="stockFlag notOnStock">
                                [{if $product->oxarticles__oxnostocktext->value}]
                                    [{$product->oxarticles__oxnostocktext->value}]
                                [{elseif $oViewConf->getStockOffDefaultMessage()}]
                                    [{oxmultilang ident="MESSAGE_NOT_ON_STOCK"}]
                                [{/if}]
                                [{if $product->getDeliveryDate()}]
                                    [{oxmultilang ident="AVAILABLE_ON"}] [{$product->getDeliveryDate()}]
                                [{/if}]
                            </span>
                        [{elseif $product->getStockStatus() == 1}]
                            <span class="stockFlag lowStock">
                                [{oxmultilang ident="LOW_STOCK"}]
                            </span>
                        [{elseif $product->getStockStatus() == 0}]
                            <span class="stockFlag">
                                [{if $product->oxarticles__oxstocktext->value}]
                                    [{$product->oxarticles__oxstocktext->value}]
                                [{elseif $oViewConf->getStockOnDefaultMessage()}]
                                    [{oxmultilang ident="READY_FOR_SHIPPING"}]
                                [{/if}]
                            </span>
                        [{/if}]

                    </div>

                    [{oxhasrights ident="SHOWARTICLEPRICE"}]
                        <div class="cost">
                            [{if $product->getFTPrice()}]
                                <b class="old">[{oxmultilang ident="DETAILS_REDUCEDFROM"}]
                                    <del>[{$product->getFTPrice()}] [{$currency->sign}]</del>
                                </b>
                                <span class="desc">[{oxmultilang ident="DETAILS_REDUCEDTEXT"}]</span><br>
                                <sub class="only">[{oxmultilang ident="DETAILS_NOWONLY"}]</sub>
                            [{/if}]
                            [{if $product->getFPrice()}]
                                <big class="price pricerange" id="test_product_price">[{$product->getFPrice()}] [{$currency->sign}]</big>
                            [{/if}]
                            [{oxifcontent ident="oxdeliveryinfo" object="oCont"}]
                                <sup class="dinfo">[{oxmultilang ident="PLUS"}]<a href="[{$oCont->getLink()}]" rel="nofollow">[{oxmultilang ident="PLUS_SHIPPING2"}]</a></sup>
                            [{/oxifcontent}]
                        </div>
                    [{/oxhasrights}]


                    [{if $product->isCrowdfundedArticle()}]

                        [{include file="page/details/inc/marm-crowdfunding-status.tpl"}]
                    [{/if}]
                </div>
            </div>
        </div>
    </body>
</html>