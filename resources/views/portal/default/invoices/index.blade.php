@extends('portal.default.layouts.master')

@section('header')
	@parent
	<link href="//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css"/>
@stop

@section('body')
    <main class="main">
        <div class="container-fluid">

			<div class="row" style="padding-top: 30px;">
			
				<div class="col-lg-12">
					
					<!-- Filters / Buttons in here.-->
					<div id="top_right_buttons" class="pull-right">
						<input id="tableFilter_invoice" type="text" style="width:180px;margin-right:17px;background-color: white !important"
					        class="form-control pull-left" placeholder="Filter" value=""/>
					</div>

					<div class="animated fadeIn">
	                    <div class="col-md-12 card">

    					{!! $html->table(['class' => 'table table-hover table-striped', 'id' => 'invoice-table'], true) !!}

	                    </div>
	                </div>
				</div>
			</div>

        </div>
    </main>
</body>
@endsection

@push('scripts')
	<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="//cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
@endpush

@section('footer')
<script>
$(function() {
    $('#invoice-table').DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        bLengthChange: false,
        language: {
	        processing:     " {{ trans('texts.processing_request') }}",
	        search:         "{{ trans('texts.search') }}:",
	       // info:           "{{ trans('texts.info') }}",
	        infoPostFix:    "",
	        loadingRecords: "{{ trans('texts.loading') }}",
	        zeroRecords:    "{{ trans('texts.no_records_found') }}"
    	},
        ajax: '{!! route('client.invoices.index') !!}',
        columns: [

            {data: 'checkbox', name: 'checkbox', title: '', searchable: false, orderable: false},
            {data: 'invoice_number', name: 'invoice_number', title: '{{trans('texts.invoice_number')}}', visible: true},
            {data: 'invoice_date', name: 'invoice_date', title: '{{trans('texts.invoice_date')}}', visible: true},
            {data: 'amount', name: 'amount', title: '{{trans('texts.total')}}', visible: true},
            {data: 'balance', name: 'balance', title: '{{trans('texts.balance')}}', visible: true},
            {data: 'due_date', name: 'due_date', title: '{{trans('texts.due_date')}}', visible: true},
            {data: 'status_id', name: 'status_id', title: '{{trans('texts.status')}}', visible: true},
            {data: 'action', name: 'action', title: '', searchable: false, orderable: false},
        ]
    });
});

$(".dataTables_filter").hide();

</script>
@endsection
