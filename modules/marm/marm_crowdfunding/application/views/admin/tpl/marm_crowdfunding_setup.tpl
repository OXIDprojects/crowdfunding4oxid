[{include file="headitem.tpl" title="GENERAL_ADMIN_TITLE"|oxmultilangassign}]

<style type="text/css">
    /* Crowdfunding */
    #crowdfunding-status{margin: 10px 0px; font-size: 10px;}
    #crowdfunding-progress-bar{width: 100%;	height: 20px; line-height: 20px; border: 1px solid #555555;}
    #crowdfunding-progress{display: block; height: 20px; text-align: center;}
    #crowdfunding-ltext{display: block;	width: 100%; margin-top: -20px; text-align: center;}
    .cf-green{ background-color: #00AB1F; }
    .cf-orange{	background-color: #FFB200; }
    .cf-red{ background-color: #FF0000; }
</style>

[{if $readonly}]
    [{assign var="readonly" value="readonly disabled"}]
[{else}]
    [{assign var="readonly" value=""}]
[{/if}]

<form name="transfer" id="transfer" action="[{$oViewConf->getSelfLink()}]" method="post">
    [{$oViewConf->getHiddenSid()}]
    <input type="hidden" name="cl" value="marm_crowdfunding_setup">
    <input type="hidden" name="oxid" value="[{$oxid}]">
    <input type="hidden" name="editlanguage" value="[{$actlang}]">
</form>

<form name="myedit" id="myedit" action="[{$oViewConf->getSelfLink()}]" method="post">
    [{$oViewConf->getHiddenSid()}]
    <input type="hidden" name="cl" value="marm_crowdfunding_setup">
    <input type="hidden" name="fnc" value="">
    <input type="hidden" name="language" value="[{$actlang}]">
    <input type="hidden" name="oxid" value="[{$oxid}]">
    <input type="hidden" name="voxid" value="[{$oxid}]">
    <input type="hidden" name="oxparentid" value="[{$oxparentid}]">

    <table cellspacing="0" cellpadding="0" border="0" width="98%">
        <tr>
            <td valign="top" class="edittext">
                <table cellspacing="30" cellpadding="0" border="0">
					<tr>
						<td>
							<table cellspacing="0" cellpadding="0" border="0">
                                [{if $product->isCrowdfundable()}]
                                    [{foreach from=$oView->getConfigValues() item='aConfigValueOptions' key='sConfigKey'}]
                                        <tr>
                                            <td class="edittext">
                                                [{oxmultilang ident="MARM_CROWDFUNDING_CONFIG_"|cat:$sConfigKey}]
                                            </td>
                                            <td class="edittext">
                                                [{if $aConfigValueOptions.input_type == 'text'}]
                                                    <input type="text" class="editinput" size="40" maxlength="255" name="editval[[{$sConfigKey}]]" value="[{$aConfigValueOptions.value}]" [{$readonly}]>
                                                [{elseif $aConfigValueOptions.input_type == 'checkbox'}]
                                                    <input type="checkbox" name="editval[[{$sConfigKey}]]" value="[{$aConfigValueOptions.value}]" [{if $aConfigValueOptions.value == 'enabled'}]checked[{/if}] />
                                                [{elseif $aConfigValueOptions.input_type == 'select'}]
                                                    <select name="editval[[{$sConfigKey}]]">
                                                        [{foreach from=$aConfigValueOptions.options item='sConfigOption'}]
                                                            <option value="[{$sConfigOption}]"[{if $aConfigValueOptions.value ==$sConfigOption}] selected="selected"[{/if}]>[{oxmultilang ident="MARM_CROWDFUNDING_CONFIG_"|cat:$sConfigOption}]</option>
                                                        [{/foreach}]
                                                    </select>
                                                [{/if}]
                                            </td>

                                        </tr>
                                    [{/foreach}]
                                    <tr>
                                        <td colspan="2">
                                            [{if $product->isCrowdfundedArticle()}]
                                                [{oxmultilang ident="MARM_CROWDFUNDING_CUSTOMERS"}]<br />
                                                <textarea cols="60" rows="[{$product->getNumberOfCustomers()}]" style="width: 100%">[{$product->displayCustomerEmails()}]</textarea>
                                            [{/if}]
                                        </td>
                                    </tr>
                                [{else}]
                                    <tr>
                                        <td colspan="2">[{oxmultilang ident="MARM_CROWDFUNDING_NOCROWDFUNDING"}]</td>
                                    </tr>
                                [{/if}]
                                <tr>
                                    <td class="edittext"><br><br>
                                        [{assign var="oMarmCrowdfounding" value=$oView->getMarmCrowdfunding()}]
                                        <div>[{oxmultilang ident="MARM_CROWDFUNDING_VERSION"}] [{$oMarmCrowdfounding->getVersion()}]</div>
                                    </td>
                                    <td valign="top" class="edittext"><br><br>
                                    [{if $product->isCrowdfundable()}]
                                        <input type="submit" class="edittext" id="oLockButton" value="[{oxmultilang ident="GENERAL_SAVE"}]" onclick="Javascript:document.myedit.fnc.value='save'"" [{$readonly}]><br>
                                    [{/if}]
                                    </td>
                                </tr>
							</table>	
						</td>
						<td align="center" valign="top">
							<div>
								<strong>[{oxmultilang ident="MARM_CROWDFUNDING_SPONSORING"}]</strong>
								<br /><br />
								<a href="http://www.marmalade.de/" target=_blank" title="marmalade.de :: Webdesign">
								    <img src="[{$oViewConf->getModuleUrl('marm', 'marm_crowdfunding/out/admin/img/marmalade.gif')}]" align="center" />
                                </a>
								<br /><br />
								<a href="http://www.muensmedia.de/" target=_blank" title="M&Uuml;NSMEDIA - webdesign | hosting | multimedia">
								    <img src="[{$oViewConf->getModuleUrl('marm', 'marm_crowdfunding/out/admin/img/muensmedia.jpg')}]" align="center" />
                                </a>
								<br /><br />
								<a href="http://www.digidesk.de/" target=_blank" title="digidesk - media solutions">
								    <img src="[{$oViewConf->getModuleUrl('marm', 'marm_crowdfunding/out/admin/img/digidesk.png')}]" align="center" />
                                </a>
							</div>
						</td>
					</tr>
                </table>
            </td>
        </tr>
    </table>
</form>

[{include file="bottomnaviitem.tpl"}]
[{include file="bottomitem.tpl"}]