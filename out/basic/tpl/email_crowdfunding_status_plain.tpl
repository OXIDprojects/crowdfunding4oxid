[{ oxmultilang ident="MARM_CROWDFUNDING_STATUSEMAIL_DESC1" }] [{ $article->displayCrowdfundingStatus() }][{ oxmultilang ident="MARM_CROWDFUNDING_STATUSEMAIL_DESC2" }]

[{ oxmultilang ident="EMAIL_ORDER_CUST_HTML_PRODUCT" }] [{ $article->getCrowdfundingArticleName() }] - [{ oxmultilang ident="EMAIL_ORDER_CUST_HTML_ARTNOMBER" }] [{ $article->getCrowdfundingArticleNumber() }]
[{ oxmultilang ident="MARM_CROWDFUNDING_STATUSEMAIL_AMOUNT" }] [{$lang->formatCurrency($article->getAmountToCrowdfund(), $currency)}] [{ $currency->name}]
------------------------------------------------------------------
[{* crowdfunding sum (netto) *}]
[{ oxmultilang ident="MARM_CROWDFUNDING_STATUSEMAIL_CSUM" }]: [{$lang->formatCurrency($article->getAmountToCrowdfund(), $currency)}] [{ $currency->name}]
[{* already crowdfunded sum *}]
[{ oxmultilang ident="MARM_CROWDFUNDING_STATUSEMAIL_CCSUM" }]: [{ $lang->formatCurrency($article->getCrowdfundedAmount(), $currency) }] [{ $currency->name}]
[{* grand total *}]
[{ oxmultilang ident="MARM_CROWDFUNDING_STATUSEMAIL_GRANDTOTAL" }]: [{ $lang->formatCurrency($article->getCrowdfundingDifference(), $currency) }] [{ $currency->sign}]</b>
[{* *}]

[{ oxcontent ident="oxemailfooterplain" }]
