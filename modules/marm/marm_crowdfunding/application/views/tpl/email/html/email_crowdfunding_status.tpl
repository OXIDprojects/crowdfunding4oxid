<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=[{$charset}]">
</head>
<body bgcolor="#FFFFFF" link="#355222" alink="#355222" vlink="#355222" style="font-family: Verdana, Geneva, Arial, Helvetica, sans-serif; font-size: 10px;">
<img src="[{$oViewConf->getNoSslImageDir()}]/logo_white.gif" border="0" hspace="0" vspace="0" alt="[{$shop->oxshops__oxname->value}]" align="texttop"><br><br>
[{oxmultilang ident="MARM_CROWDFUNDING_STATUSEMAIL_DESC1"}] [{$article->displayCrowdfundingStatus()}][{oxmultilang ident="MARM_CROWDFUNDING_STATUSEMAIL_DESC2"}]
<br><br>
<table border="0" cellspacing="0" cellpadding="0" width="600">
    <tr>
        <td style="font-family: Verdana, Geneva, Arial, Helvetica, sans-serif; font-size: 10px; background-color: #494949; color: #FFFFFF;" height="15" width="100">
            &nbsp;&nbsp;<b>[{oxmultilang ident="EMAIL_ORDER_CUST_HTML_PRODUCT"}]</b>
        </td>
        <td style="font-family: Verdana, Geneva, Arial, Helvetica, sans-serif; font-size: 10px; background-color: #494949; color: #FFFFFF;" height="15"></td>
        <td style="font-family: Verdana, Geneva, Arial, Helvetica, sans-serif; font-size: 10px; background-color: #494949; color: #FFFFFF;" align="right" width="70">
            <b>[{oxmultilang ident="MARM_CROWDFUNDING_STATUSEMAIL_AMOUNT"}]&nbsp;</b>
        </td>
    </tr>
    <tr>
        <td valign="top" style="font-family: Verdana, Geneva, Arial, Helvetica, sans-serif; font-size: 10px; padding-top: 10px;">
            <img src="[{$article->getThumbnailUrl()}]" border="0" hspace="0" vspace="0" alt="[{$article->oxarticles__oxtitle->value|strip_tags}]" align="texttop">
        </td>
        <td valign="top" style="font-family: Verdana, Geneva, Arial, Helvetica, sans-serif; font-size: 10px; padding-top: 10px;">
            <b>[{$article->getCrowdfundingArticleName()}]</b>
            <br>[{oxmultilang ident="EMAIL_ORDER_CUST_HTML_ARTNOMBER"}] [{$article->getCrowdfundingArticleNumber()}]
        </td>
        <td style="font-family: Verdana, Geneva, Arial, Helvetica, sans-serif; font-size: 10px; padding-top: 10px;" valign="top" align="right">
            <b>[{$lang->formatCurrency($article->getAmountToCrowdfund(), $currency)}] [{$currency->sign}]</b>
        </td>
    </tr>
    <tr>
        <td height="1" bgcolor="#BEBEBE"></td>
        <td height="1" bgcolor="#BEBEBE"></td>
        <td height="1" bgcolor="#BEBEBE"></td>
        <td height="1" bgcolor="#BEBEBE"></td>
        <td height="1" bgcolor="#BEBEBE"></td>
        <td height="1" bgcolor="#BEBEBE"></td>
    </tr>
</table>
<br>

<table border="0" cellspacing="0" cellpadding="2" width="600">
    <tr>
        <td width="50%" valign="top"></td>
        <td width="50%" valign="top">
            <table border="0" cellspacing="0" cellpadding="2" width="300">
                [{* crowdfunding sum (netto) *}]
                <tr>
                    <td style="font-family: Verdana, Geneva, Arial, Helvetica, sans-serif; font-size: 10px;" valign="top" align="right">
                        [{oxmultilang ident="MARM_CROWDFUNDING_STATUSEMAIL_CSUM"}]
                    </td>
                    <td style="font-family: Verdana, Geneva, Arial, Helvetica, sans-serif; font-size: 10px;" valign="top" align="right">
                        [{$lang->formatCurrency($article->getAmountToCrowdfund(), $currency)}] [{$currency->sign}]
                    </td>
                </tr>

                [{* already crowdfunded sum *}]
                <tr>
                    <td style="font-family: Verdana, Geneva, Arial, Helvetica, sans-serif; font-size: 10px;" valign="top" align="right">
                        [{oxmultilang ident="MARM_CROWDFUNDING_STATUSEMAIL_CCSUM"}]
                    </td>
                    <td style="font-family: Verdana, Geneva, Arial, Helvetica, sans-serif; font-size: 10px;" valign="top" align="right">
                        [{$lang->formatCurrency($article->getCrowdfundedAmount(), $currency)}] [{$currency->sign}]
                    </td>
                </tr>

                <tr>
                    <td height="1"></td>
                    <td height="1" bgcolor="#BEBEBE"></td>
                </tr>
                [{* grand total *}]
                <tr>
                    <td style="font-family: Verdana, Geneva, Arial, Helvetica, sans-serif; font-size: 10px;" valign="top" align="right">
                        <b>[{oxmultilang ident="MARM_CROWDFUNDING_STATUSEMAIL_GRANDTOTAL"}]</b>
                    </td>
                    <td style="font-family: Verdana, Geneva, Arial, Helvetica, sans-serif; font-size: 10px;" valign="top" align="right">
                        <b>[{$lang->formatCurrency($article->getCrowdfundingDifference(), $currency)}] [{$currency->sign}]</b>
                    </td>
                </tr>
                [{* *}]
            </table>
        </td>
    </tr>
</table>
<br><br>
[{oxcontent ident="oxemailfooter"}]
</body>
</html>
