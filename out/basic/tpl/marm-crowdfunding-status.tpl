[{if $product->displayCrowdfundingStatus() <= 33}]
  [{ assign var="cf_color" value="cf-red"}]
[{elseif $product->displayCrowdfundingStatus() <= 66}]
  [{ assign var="cf_color" value="cf-orange"}]
[{else}]
 [{ assign var="cf_color" value="cf-green"}]
[{/if}]
<div style="clear: both;"> </div>
<div id="crowdfunding-status">
  [{oxmultilang ident="MARM_CROWDFUNDING_STATUS_HEADER"}]
	<div id="crowdfunding-progress-bar">
		<span id="crowdfunding-progress" class="[{$cf_color}]" style="width: [{$product->displayCrowdfundingStatus()}]%"></span>
	    <span id="crowdfunding-ltext">[{$product->displayCrowdfundingStatus()}]%</span>
	</div>
</div>