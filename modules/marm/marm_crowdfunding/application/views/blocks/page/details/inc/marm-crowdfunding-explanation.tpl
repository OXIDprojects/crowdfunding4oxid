[{$smarty.block.parent}]

[{assign var="oConfig" value=$oView->getConfig()}]

[{if $oConfig->getShopConfVar('blShowCrowdfundingExplanationDet',null,'module:marm_crowdfunding')}]
    [{oxstyle include=$oViewConf->getModuleUrl('marm','marm_crowdfunding/out/src/css/style.css')}]

    <div id="crowdfunding-explanation">
        <h2>[{oxmultilang ident="MARM_CROWDFUNDING_EXPLANATION_HEADER"}]</h2>
        [{oxmultilang ident="MARM_CROWDFUNDING_EXPLANATION_TEXT"}]
    </div>
[{/if}]