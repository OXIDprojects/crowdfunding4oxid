[{$smarty.block.parent}]

[{assign var="oConfig" value=$oView->getConfig()}]

[{if ( $oViewConf->getTopActiveClassName() == 'details' && $oConfig->getShopConfVar('blShowCrowdfundingSupportDetails',null,'module:marm_crowdfunding') ) ||
     ( $oViewConf->getTopActiveClassName() == 'thankyou' && $oConfig->getShopConfVar('blShowCrowdfundingThankyou',null,'module:marm_crowdfunding') )}]

    [{if $oViewConf->getTopActiveClassName() == 'thankyou'}]
        [{assign var="oDetailsProduct" value=$order->getOneCrowdfundedArticleOfBasket()}]
    [{/if}]

    [{if $oDetailsProduct}]
        [{oxstyle include=$oViewConf->getModuleUrl('marm','marm_crowdfunding/out/src/css/style.css')}]
        <strong class="clear">[{oxmultilang ident="MARM_CROWDFUNDING_SUPPORT"}]</strong>

        <div class="info">
            <div>
                [{oxmultilang ident="MARM_CROWDFUNDING_SUPPORTTEXT" }]
                <pre style="white-space: pre-wrap; word-wrap: break-word;">&lt;iframe src=&quot;[{$oDetailsProduct->getBaseSeoLink($oLang)}]?&amp;out=widget&quot; style=&quot;width: 310px; height:245px&quot; scrolling=&quot;no&quot; frameborder=&quot;0&quot;&gt;&lt;/iframe&gt;</pre>
            </div>
        </div>
    [{/if}]
[{/if}]