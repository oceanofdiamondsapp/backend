@extends('app')

@section('content')
	<div class="page-header">
		<h1>Dashboard</h1>
	</div>

	<div class="row">
		<div class="col-lg-6">
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>Quote Activity</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>New requests</td>
						<td class="text-right col-md-2">{{ $activity['newRequests'] }}</td>
					</tr>
					<tr>
						<td>New messages</td>
						<td class="text-right col-md-2">{{ $activity['newMessages'] }}</td>
					</tr>
					<tr>
						<td>Idle (longer than 7 days since activity)</td>
						<td class="text-right col-md-2">{{ $activity['idle'] }}</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>Total requests this month</td>
						<td class="text-right col-md-2">{{ $activity['requestsThisMonth'] }}</td>
					</tr>
					<!--
					<tr>
						<td>Total requests by this day last month</td>
						<td></td>
					</tr>
					<tr>
						<td>Average by this day per month</td>
						<td></td>
					</tr>
					-->
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>Total requests to date</td>
						<td class="text-right col-md-2">{{ $activity['requestsToDate'] }}</td>
					</tr>
					<tr>
						<td>Lapsed</td>
						<td class="text-right col-md-2">{{ $activity['lapsedToDate'] }}</td>
					</tr>
					<tr>
						<td>Declined</td>
						<td class="text-right col-md-2">{{ $activity['declinedToDate'] }}</td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="col-lg-6">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Order Activity</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>New orders</td>
						<td class="text-right col-md-2">{{ $activity['newOrders'] }}</td>
					</tr>
					<tr>
						<td>In progress</td>
						<td class="text-right col-md-2">{{ $activity['inProgress'] }}</td>
					</tr>
					<tr>
						<td>Shipping</td>
						<td class="text-right col-md-2">{{ $activity['shipping'] }}</td>
					</tr>
					<tr>
						<td>Completed</td>
						<td class="text-right col-md-2">{{ $activity['completed'] }}</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>Total orders this month</td>
						<td class="text-right col-md-2">{{ $activity['ordersThisMonth'] }}</td>
					</tr>
					<!--
					<tr>
						<td>Total orders by this day last month</td>
						<td></td>
					</tr>
					<tr>
						<td>Average by this day per month</td>
						<td></td>
					</tr>
					-->
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>Total orders to date</td>
						<td class="text-right col-md-2">{{ $activity['ordersToDate'] }}</td>
					</tr>
					<tr>
						<td>Total value</td>
						<td class="text-right col-md-2">${{ $activity['totalValue'] }}</td>
					</tr>
					<tr>
						<td>Average value per order</td>
						<td class="text-right col-md-2">${{ $activity['averageValue'] }}</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
@endsection