
  [{ assign var="template_location" value=""}]
  [{ assign var="blSep" value=""}]
  [{foreach from=$oView->getCatTreePath() item=oCatPath}]
    [{ if $blSep == "y"}]
      [{ assign var="template_location" value=$template_location|cat:" / "}]
    [{/if}]
    [{ assign var="template_location" value=$template_location|cat:"<a href=\""|cat:$oCatPath->getLink()|cat:"\">"|cat:$oCatPath->oxcategories__oxtitle->value|cat:"</a>"}]
    [{ assign var="blSep" value="y"}]
  [{/foreach}]


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html[{if $oView->getActiveLangAbbr()}] lang="[{ $oView->getActiveLangAbbr() }]"[{/if}]>
<head>
    [{assign var="_titlesuffix" value=$_titlesuffix|default:$oView->getTitleSuffix()}]
    [{assign var="_titleprefix" value=$_titleprefix|default:$oView->getTitlePrefix() }]
    [{assign var="title" value=$title|default:$oView->getTitle() }]
    <title>[{ $_titleprefix }][{if $title && $_titleprefix }] | [{/if}][{$title|strip_tags}][{if $_titlesuffix}] | [{$_titlesuffix}][{/if}][{if $titlepagesuffix}] | [{$titlepagesuffix}][{/if}]</title>
    <meta http-equiv="Content-Type" content="text/html; charset=[{$charset}]">
    <meta name="ROBOTS" content="NOINDEX, NOFOLLOW">
    [{if $oView->getMetaDescription()}]<meta name="description" content="[{$oView->getMetaDescription()}]">[{/if}]
    [{if $oView->getMetaKeywords()}]<meta name="keywords" content="[{$oView->getMetaKeywords()}]">[{/if}]
    <link rel="shortcut icon" href="[{ $oViewConf->getBaseDir()}]favicon.ico">
    <link rel="stylesheet" type="text/css" href="[{ $oViewConf->getResourceUrl() }]oxid.css">
    <!--[if IE 8]><link rel="stylesheet" type="text/css" href="[{ $oViewConf->getResourceUrl() }]oxid_ie8.css"><![endif]-->
    <!--[if IE 7]><link rel="stylesheet" type="text/css" href="[{ $oViewConf->getResourceUrl() }]oxid_ie7.css"><![endif]-->
    <!--[if IE 6]><link rel="stylesheet" type="text/css" href="[{ $oViewConf->getResourceUrl() }]oxid_ie6.css"><![endif]-->
    <style type="text/css">
      #body .product.head strong.h4.big { padding-right: 16px; width: 90%; }
      #body .product.big { padding-left: 10px; }
      #product_img{ float: left; margin: 5px; }
      #body .product.details { border-bottom: 1px solid #555555; min-height: 195px; }
    </style>
</head>
<body>
   <div id="body" class="[{$cssclass|default:"plain"}]">


<!-- ox_mod01 details -->
[{assign var="currency" value=$oView->getActCurrency() }]
[{assign var="product" value=$oView->getProduct() }]

<div class="hreview-aggregate">
<div class="product item hproduct details head big">
    <strong id="test_detailsHeader" class="h4 big"><a href="[{ $product->getBaseSeoLink($oLang) }]" target="blank">[{oxmultilang ident="MARM_CROWDFUNDING_STATUS_HEADER" }]</a></strong>

      <a href="[{ $product->getBaseSeoLink($oLang) }]" target="blank" ><img src="[{ $product->getThumbnailUrl() }]" id="product_img" class="photo" alt="[{ $product->oxarticles__oxtitle->value|strip_tags }] [{ $product->oxarticles__oxvarselect->value|default:'' }]"></a>

    <h1 id="test_product_name" class="fn"><a href="[{ $product->getBaseSeoLink($oLang) }]" target="blank">[{$product->oxarticles__oxtitle->value}] [{$product->oxarticles__oxvarselect->value}]</a></h1>
    <tt id="test_product_artnum" class="identifier">
        <span class="type" title="sku">[{ oxmultilang ident="INC_PRODUCTITEM_ARTNOMBER2" }]</span>
        <span class="value">[{ $product->oxarticles__oxartnum->value }]</span>
    </tt>

    <div class="status">

      [{if $product->getStockStatus() == -1}]
      <div class="flag red"></div>
        [{ if $product->oxarticles__oxnostocktext->value  }]
            [{ $product->oxarticles__oxnostocktext->value  }]
        [{elseif $oViewConf->getStockOffDefaultMessage() }]
            [{ oxmultilang ident="DETAILS_NOTONSTOCK" }]
        [{/if}]

        [{ if $product->getDeliveryDate() }]
          <br>[{ oxmultilang ident="DETAILS_AVAILABLEON" }] [{ $product->getDeliveryDate() }]
        [{/if}]

      [{elseif $product->getStockStatus() == 1}]

      <div class="flag orange"></div>
      <b>[{ oxmultilang ident="DETAILS_LOWSTOCK" }]</b>

      [{elseif $product->getStockStatus() == 0}]

      <div class="flag green"></div>

      [{ if $product->oxarticles__oxstocktext->value  }]
        [{ $product->oxarticles__oxstocktext->value  }]
      [{elseif $oViewConf->getStockOnDefaultMessage() }]
        [{ oxmultilang ident="DETAILS_READYFORSHIPPING" }]
      [{/if}]

      [{/if}]

    </div>

    [{oxhasrights ident="SHOWARTICLEPRICE"}]
        <div class="cost">
            [{if $product->getFTPrice() }]
                <b class="old">[{ oxmultilang ident="DETAILS_REDUCEDFROM" }] <del>[{ $product->getFTPrice()}] [{ $currency->sign}]</del></b>
                <span class="desc">[{ oxmultilang ident="DETAILS_REDUCEDTEXT" }]</span><br>
                <sub class="only">[{ oxmultilang ident="DETAILS_NOWONLY" }]</sub>
            [{/if}]
            [{if $product->getFPrice() }]
                <big class="price pricerange" id="test_product_price">[{ $product->getFPrice() }] [{ $currency->sign}]</big>
            [{/if}]
            [{oxifcontent ident="oxdeliveryinfo" object="oCont"}]
            <sup class="dinfo">[{ oxmultilang ident="DETAILS_PLUSSHIPPING" }]<a href="[{ $oCont->getLink() }]" rel="nofollow">[{ oxmultilang ident="DETAILS_PLUSSHIPPING2" }]</a></sup>
            [{/oxifcontent}]
        </div>
    [{/oxhasrights}]



    
    [{if $product->isCrowdfundedArticle()}]
		[{include file="marm-crowdfunding-status.tpl"}]
	[{/if}]


</div>
</div>
