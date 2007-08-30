
<img src="images/icon-advertiser-new.gif" border="0" align="absmiddle">&nbsp;
<a href="advertiser-edit.php" accesskey="{t key=AddNew}">{t str=AddClient_Key}</a>&nbsp;&nbsp;

{phpAds_ShowBreak}

<br /><br />
<table border="0" width="100%" cellpadding="0" cellspacing="0">
    <tr height="25">
        <td height="25" width="40%">
            <b>&nbsp;&nbsp;{oa_title_sort str=Name item=name order=down default=1 url=advertiser-index.php}</b>
        </td>
        <td height="25">
            <b>{oa_title_sort str=ID item=id order=down url=advertiser-index.php}</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </td>
        <td height='25'>&nbsp;</td>
        <td height='25'>&nbsp;</td>
        <td height='25'>&nbsp;</td>
    </tr>
    <tr height='1'>
        <td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td>
    </tr>
{if !$clients|@count}
    <tr height='25' bgcolor='#F6F6F6'>
        <td height='25' colspan='5'>&nbsp;&nbsp;{t str=NoClients}</td>
    </tr>

    <tr>
        <td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td>
    <tr>
{else}
{foreach key=clientId item=client from=$clients}
    {cycle values="#F6F6F6,#FFFFFF" assign=bgColor}
    <tr height='25' bgcolor="{$bgColor}">

        <td height='25'>
    {if $client.campaigns}
        {if $client.expand}
            <a href='advertiser-index.php?collapse=client:{$clientId}'><img src='images/triangle-d.gif' align='absmiddle' border='0'></a>
        {else}
            <a href='advertiser-index.php?expand=client:{$clientId}'><img src='images/{$phpAds_TextDirection}/triangle-l.gif' align='absmiddle' border='0'></a>
        {/if}
    {else}
            <img src='images/spacer.gif' height='16' width='16' align='absmiddle'>
    {/if}

            <img src='images/icon-advertiser.gif' align='absmiddle'>
            <a href='advertiser-edit.php?clientid={$clientId}'>{$client.clientname|escape:html}</a>
        </td>

        <td height='25'>{$clientId}</td>

        <td height='25'>
    {if $client.expand && !$client.campaigns}
            <a href='campaign-edit.php?clientid={$clientId}'><img src='images/icon-campaign-new.gif' border='0' align='absmiddle' alt='{t str=Create}'>&nbsp;{t str=Create}</a>&nbsp;&nbsp;&nbsp;&nbsp;
    {else}
            &nbsp;
    {/if}
        </td>

        <td height='25'>
            <a href='advertiser-campaigns.php?clientid={$clientId}'><img src='images/icon-overview.gif' border='0' align='absmiddle' alt='{t str=Overview}'>&nbsp;{t str=Overview}</a>&nbsp;&nbsp;
        </td>

        <td height='25'>
            <a href='advertiser-delete.php?clientid={$clientId}&returnurl=advertiser-index.php'{phpAds_DelConfirm str=ConfirmDeleteClient}><img src='images/icon-recycle.gif' border='0' align='absmiddle' alt='{t str=Delete}'>&nbsp;{t str=Delete}</a>&nbsp;&nbsp;&nbsp;&nbsp;
        </td>

        </tr>

    {if $client.campaigns && $client.expand}
        {foreach key=campaignId item=campaign from=$client.campaigns}

        <tr height='1'>
            <td bgcolor="{$bgColor}"><img src='images/spacer.gif' width='1' height='1'></td>
            <td colspan='5' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td>
        </tr>

        <tr height='25' bgcolor="{$bgColor}">
        <td height='25'>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            {if $campaign.banners}
                {if $campaign.expand}
            <a href='advertiser-index.php?collapse=campaign:{$clientId}-{$campaignId}'><img src='images/triangle-d.gif' align='absmiddle' border='0'></a>
                {else}
            <a href='advertiser-index.php?expand=campaign:{$clientId}-{$campaignId}'><img src='images/{$phpAds_TextDirection}/triangle-l.gif' align='absmiddle' border='0'></a>
                {/if}
            {else}
            <img src='images/spacer.gif' height='16' width='16' align='absmiddle'>&nbsp;
            {/if}

            {if $campaign.active == 't'}
            <img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;
                {else}
            <img src='images/icon-campaign-d.gif' align='absmiddle'>&nbsp;
            {/if}

            <a href='campaign-edit.php?clientid={$clientId}&campaignid={$campaignId}'>{$campaign.campaignname|escape:html}</td>
        </td>

        <td height='25'>{$campaignId}</td>

        <td height='25'>
            {if !$campaign.banners}
            <a href='banner-edit.php?clientid={$clientId}&campaignid={$campaignId}'><img src='images/icon-banner-new.gif' border='0' align='absmiddle' alt='{t str=Create}'>&nbsp;{t str=Create}</a>&nbsp;&nbsp;&nbsp;&nbsp;
            {else}
            &nbsp;
            {/if}
        </td>

        <td height='25'>
            <a href='campaign-banners.php?clientid={$clientId}&campaignid={$campaignId}'><img src='images/icon-overview.gif' border='0' align='absmiddle' alt='{t str=Overview}'>&nbsp;{t str=Overview}</a>&nbsp;&nbsp;
        </td>

        <td height='25'>
            <a href='campaign-delete.php?clientid={$clientId}&campaignid={$campaignId}&returnurl=advertiser-index.php'{phpAds_DelConfirm str=ConfirmDeleteCampaign}><img src='images/icon-recycle.gif' border='0' align='absmiddle' alt='{t str=Delete}'>&nbsp;{t str=Delete}</a>&nbsp;&nbsp;&nbsp;&nbsp;
        </td>
    </tr>

            {if $campaign.expand && $campaign.banners}
                {foreach key=bannerId item=banner from=$campaign.banners}
    <tr height='1'>
        <td bgcolor="{$bgColor}"><img src='images/spacer.gif' width='1' height='1'></td>
        <td colspan='4' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td>
    </tr>

    <tr height='25' bgcolor="{$bgColor}">
        <td height='25'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            <img src='{oa_icon banner=$banner campaign=$campaign}' align='absmiddle'>
            &nbsp;<a href='banner-edit.php?clientid={$clientId}&campaignid={$campaignId}&bannerid={$bannerId}'>{$banner.name}</a>
         </td>
        <td height='25'>{$bannerId}</td>
        <td>&nbsp;</td>
        <td height='25'>
            <a href='banner-acl.php?clientid={$clientId}&campaignid={$campaignId}&bannerid={$bannerId}'><img src='images/icon-acl.gif' border='0' align='absmiddle' alt='{t str=ACL}'>&nbsp;{t str=ACL}</a>&nbsp;&nbsp;&nbsp;&nbsp;
        </td>
        <td height='25'>
            <a href='banner-delete.php?clientid={$clientId}&campaignid={$campaignId}&bannerid={$bannerId}&returnurl=advertiser-index.php' {phpAds_DelConfirm str=ConfirmDeleteBanner}><img src='images/icon-recycle.gif' border='0' align='absmiddle' alt='{t str=Delete}'>&nbsp;{t str=Delete}</a>&nbsp;&nbsp;&nbsp;&nbsp;
        </td>
    </tr>
                {/foreach}
            {/if}
        {/foreach}
    {/if}
    <tr height='1'>
        <td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td>
    </tr>

{/foreach}
{/if}

    <tr>
        <td height='25' colspan='3' align='{$phpAds_TextAlignLeft}' nowrap>

{if $hideinactive}
            &nbsp;&nbsp;<img src='images/icon-activate.gif' align='absmiddle' border='0'>
            &nbsp;<a href='advertiser-index.php?hideinactive=0'>{t str=ShowAll}</a>
            &nbsp;&nbsp;|&nbsp;&nbsp;{$clientshidden} {t str=InactiveAdvertisersHidden};
{else}
            &nbsp;&nbsp;<img src='images/icon-hideinactivate.gif' align='absmiddle' border='0'>
            &nbsp;<a href='advertiser-index.php?hideinactive=1'>{t str=HideInactiveAdvertisers}</a>
{/if}

        </td>
        <td height='25' colspan='2' align='{$phpAds_TextAlignRight}' nowrap>
            <img src='images/triangle-d.gif' align='absmiddle' border='0'>
            &nbsp;<a href='advertiser-index.php?expand=all' accesskey='{t key=ExpandAll}'>{t str=ExpandAll}</a>
            &nbsp;&nbsp;|&nbsp;&nbsp;
            <img src='images/{$phpAds_TextDirection}/triangle-l.gif' align='absmiddle' border='0'>
            &nbsp;<a href='advertiser-index.php?expand=none' accesskey='{t key=CollapseAll}'>{t str=CollapseAll}</a>&nbsp;&nbsp;
        </td>
    </tr>
</table>

<br /><br /><br /><br />

<table width='100%' border='0' align='center' cellspacing='0' cellpadding='0'>
<tr>
<td height='25' colspan='3'>&nbsp;&nbsp;<b>{t str=Overall}</b></td>
</tr>
<tr height='1'>
<td colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td>
</tr>

<tr>
<td height='25'>&nbsp;&nbsp;{t str=TotalBanners}: <b>{$number_of_banners}</b></td>
<td height='25'>{t str=TotalCampaigns}: <b>{$number_of_campaigns}</b></td>
<td height='25'>{t str=TotalClients}: <b>{$number_of_clients}</b></td>
</tr>

<tr height='1'>
<td colspan='4' bgcolor='#888888'><img src='images/break-el.gif' height='1' width='100%'></td>
</tr>

<tr>
<td height='25'>&nbsp;&nbsp;{t str=ActiveBanners}: <b>{$number_of_active_banners}</b></td>
<td height='25'>{t str=ActiveCampaigns}: <b>{$number_of_active_campaigns}</b></td>
<td height='25'>&nbsp;</td>
</tr>

<tr height='1'>
<td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td>

</tr>
</table>
<br /><br />
