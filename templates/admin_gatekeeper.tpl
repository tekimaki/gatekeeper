{strip}
{if $gatekeeperList}
	{form legend="Assign Gatekeeper to Groups"}
		<input type="hidden" name="page" value="{$page}" />

		{formfeedback error=`$errors.group`}

		{foreach item=grp key=groupId from=$systemGroups}
			<div class="row">
				{formlabel label=$grp.group_name for=""}
				{forminput}
					{$groupGatekeeper.$groupId}
				{/forminput}
			</div>
		{/foreach}

		<div class="buttonHolder row submit">
			<input type="submit" name="assigngatekeeper" value="{tr}Assign gatekeeper{/tr}" />
		</div>
	{/form}

	<a href="{$smarty.server.PHP_SELF}?page=gatekeeper&newgatekeeper=1">{tr}Create New Gatekeeper{/tr}</a>
	<table class="data">
		<caption>{tr}Defined Gatekeepers{/tr}</caption>
		<tr>
			<th>{tr}Gatekeeper{/tr}</th>
			<th>{tr}Disk Usage{/tr}</th>
			<th>{tr}Monthly Transfer{/tr}</th>
		</tr>
		{foreach key=gatekeeperId item=gatekeeper from=$gatekeeperList}
			<tr class="{cycle values=odd,even}">
				<td><a href="{$smarty.server.PHP_SELF}?page=gatekeeper&gatekeeper_id={$gatekeeperId}">{$gatekeeper.title|escape}</a></td>
	    		<td align="right">{$gatekeeper.disk_usage/1000000} MB</td>
    			<td align="right">{$gatekeeper.monthly_transfer/1000000} MB</td>
			</tr>
		{/foreach}
	</table>
{else}
	{assign var=editLabel value=$gGatekeeper->mInfo.title|escape|default:"New Gatekeeper"}
	{form legend="Edit `$editLabel`"}
		<input type="hidden" name="page" value="{$page}" />
		<input type="hidden" name="gatekeeper_id" value="{$gGatekeeper->mGatekeeperId}" />
		<div class="row">
			{formfeedback error=`$errors.title`}
			{formlabel label="Gatekeeper Title" for="title"}
			{forminput}
				<input size="40" type="text" name="title" id="title" value="{$gGatekeeper->mInfo.title|escape}" />
				{formhelp note="This title is used to identify the gatekeeper limitations when you assign them to users and groups."}
			{/forminput}
		</div>
		<div class="row">
			{formfeedback error=`$errors.disk_usage`}
			{formlabel label="Disk Usage" for="disk_usage"}
			{forminput}
				<input size="10" type="text" name="disk_usage" id="disk_usage" value="{$gGatekeeper->mInfo.disk_usage/1000000}" />
				{formhelp note="Please enter the desired value in MegaBytes."}
			{/forminput}
		</div>
		<div class="row">
			{formfeedback error=`$errors.monthly_transfer`}
			{formlabel label="Monthly Transfer" for="monthly_transfer"}
			{forminput}
				<input size="10" type="text" name="monthly_transfer" id="monthly_transfer" value="{$gGatekeeper->mInfo.monthly_transfer/1000000}" />
				{formhelp note="Please enter the desired value in MegaBytes."}
			{/forminput}
		</div>

		<div class="buttonHolder row submit">
			<input type="submit" name="cancel" value="{tr}Cancel{/tr}" />&nbsp;
			<input type="submit" name="savegatekeeper" value="{tr}Save gatekeeper{/tr}" />
		</div>
	{/form}
{/if}
{/strip}
