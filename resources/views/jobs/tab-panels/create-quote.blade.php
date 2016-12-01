{!! Form::open(['route' => ['quotes.store', $job->id]]) !!}
	<div class="form-group {{ !$errors->has('jewelry_type_id') ?: 'has-error' }}">
		{!! Form::label('jewelry_type_id', 'Jewelry Type:') !!}
		{!! Form::select('jewelry_type_id', ['' => 'Select'] + $jewelryTypes, null, ['class' => 'form-control']) !!}
	</div>

	<div class="form-group {{ !$errors->has('description') ?: 'has-error' }}">
		{!! Form::label('description', 'Description:') !!}
		{!! Form::textarea('description', null, ['class' => 'form-control']) !!}
	</div>

	<div class="form-group {{ !$errors->has('stones_description') ?: 'has-error' }}">
		{!! Form::label('stones_description', 'Gemstones:') !!}
		{!! Form::textarea('stones_description', null, ['class' => 'form-control']) !!}
	</div>

	<div class="form-group {{ !$errors->has('metals_description') ?: 'has-error' }}">
		{!! Form::label('metals_description', 'Metals:') !!}
		{!! Form::textarea('metals_description', null, ['class' => 'form-control']) !!}
	</div>

	<label>Details:</label>

	<div class="form-horizontal">
		<div class="form-group {{ !$errors->has('setting_details') ?: 'has-error' }}">
			{!! Form::label('setting_details', 'Setting', ['class' => 'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
				{!! Form::text('setting_details', null, ['class' => 'form-control']) !!}
			</div>
		</div>

		<div class="form-group {{ !$errors->has('size_details') ?: 'has-error' }}">
			{!! Form::label('size_details', 'Size', ['class' => 'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
				{!! Form::text('size_details', null, ['class' => 'form-control']) !!}
			</div>
		</div>
	</div>

	<div class="form-group {{ !$errors->has('other_details') ?: 'has-error' }}">
		{!! Form::label('other_details', 'Other Details:') !!}
		{!! Form::textarea('other_details', null, ['class' => 'form-control']) !!}
	</div>

	<label>Price: <small>(set shipping to $0.00 per our free shipping policy)</small></label>

	<div class="form-horizontal">
		<div class="form-group {{ !$errors->has('price') ?: 'has-error' }}">
			{!! Form::label('price', 'Piece', ['class' => 'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
				{!! Form::text('price', null, ['class' => 'form-control', 'data-target-model' => 'total']) !!}
			</div>
		</div>

		<div class="form-group {{ !$errors->has('shipping') ?: 'has-error' }}">
			{!! Form::label('shipping', 'Shipping', ['class' => 'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
				{!! Form::text('shipping', null, ['class' => 'form-control', 'data-target-model' => 'total']) !!}
			</div>
		</div>

		<div class="form-group {{ !$errors->has('tax_id') ?: 'has-error' }}">
			{!! Form::label('tax_id', 'Tax', ['class' => 'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
				{!! Form::select('tax_id', ['' => 'Select'] + $taxTypes, null, ['class' => 'form-control', 'data-target-model' => 'total']) !!}
			</div>
		</div>
	</div>

	<hr>

	<ul class="list-inline">
		<li><label>Quote:</label></li>
		<li><span class="text-xl" data-model="total">$0.00</span></li>
	</ul>

	<hr>

	<!--
	<div class="form-group {{ !$errors->has('message') ?: 'has-error' }}">
		{!! Form::label('message', 'Attach a message to this quote (Visible to the client)') !!}
		{!! Form::textarea('message', null, ['class' => 'form-control']) !!}
	</div>

	<div class="form-group {{ !$errors->has('message_attachment') ?: 'has-error' }}">
		{!! Form::label('message_attachment', 'Attaching to message:') !!}
		{!! Form::file('message_attachment', ['class' => 'form-control']) !!}
	</div>

	<hr>
	-->

	<div class="form-group {{ !$errors->has('quote_note') ?: 'has-error' }}">
		{!! Form::label('quote_note', 'Internal Notes (Not visible to the client)') !!}
		{!! Form::textarea('quote_note', null, ['class' => 'form-control']) !!}
	</div>

	<hr>

	<div class="form-group">
		{!! Form::reset('Cancel', ['class' => 'btn btn-danger', 'onClick' => 'onQuoteCancel()']) !!}
		{!! Form::submit('Send', ['class' => 'btn btn-primary pull-right']) !!}
	</div>
{!! Form::close() !!}