[{$smarty.block.parent}]

[{assign var="oConfig" value=$oView->getConfig()}]

[{if $oConfig->getShopConfVar('blShowCrowdfundingStatusDetails',null,'module:marm_crowdfunding')}]
    [{oxstyle include=$oViewConf->getModuleUrl('marm','marm_crowdfunding/out/src/css/style.css')}]

    [{if $oDetailsProduct->displayCrowdfundingStatus() <= 33}]
        [{assign var="cf_color" value="cf-red"}]
    [{elseif $oDetailsProduct->displayCrowdfundingStatus() <= 66}]
        [{assign var="cf_color" value="cf-orange"}]
    [{else}]
        [{assign var="cf_color" value="cf-green"}]
    [{/if}]

    <div style="clear: both;"></div>

    <hr/>

    <div id="crowdfunding-status">
        [{oxmultilang ident="MARM_CROWDFUNDING_STATUS_HEADER"}]
        <div id="crowdfunding-progress-bar">
            <span id="crowdfunding-progress" class="[{$cf_color}]" style="width: [{$oDetailsProduct->displayCrowdfundingStatus()}]%"></span>
            <span id="crowdfunding-ltext">[{$oDetailsProduct->displayCrowdfundingStatus()}]%</span>
        </div>
    </div>
[{/if}]