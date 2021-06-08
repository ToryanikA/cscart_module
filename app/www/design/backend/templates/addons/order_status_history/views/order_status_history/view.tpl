{capture name="mainbox"}
	<form action="{""|fn_url}" method="post" name="manage_history_form" class="form-horizontal form-edit cm-ajax" id="manage_history_form">
		<div class="table-responsive-wrapper longtap-selection">
			<table width="100%" class="table table-middle table-responsive">
				<thead>
				<tr>
					<th>{__('osh.order_id')}</th>
					<th>{__('osh.status_old')}</th>
					<th>{__('osh.status_new')}</th>
					<th>{__('osh.username')}</th>
					<th>{__('osh.date')}</th>
				</tr>
				</thead>
				<tbody>
				{if empty($data)}
					<tr>
						<td colspan="5" style="text-align: center">{__('osh.not_found')}</td>
					</tr>
				{else}
					{foreach from=$data item=row}
						<tr>
							<td>{$row['order_id']}</td>
							<td>{$statuses[$row['status_old']]['description']}</td>
							<td>{$statuses[$row['status_new']]['description']}</td>
							<td>
								<a href="{"profiles.update?user_id=`$row['user_id']`"|fn_url}">{$row['user_login']}</a>
							</td>
							<td>{$row['created_at']}</td>
						</tr>
					{/foreach}
				{/if}
				</tbody>
			</table>

			{include file="common/pagination.tpl" save_current_page=true save_current_url=true div_id='content_order_status_history'}

		</div>
	</form>
{/capture}

{include file="common/mainbox.tpl" title=__("orders_status_history") content=$smarty.capture.mainbox content_id="order_status_history"}
