<div class="modal fade" role="dialog" id="modalManualRecord">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-yellow">
                <h4 class="modal-title">
                    <i class="fa fa-pencil"></i>
                    {{ trans('calendar::seat.manual_recording') }}
                </h4>
            </div>
            <div class="modal-body">
                <div class="modal-errors alert alert-danger hidden">
                    <ul></ul>
                </div>
                <form class="form-horizontal" id="formManualRecord">
                    <input type="hidden" name="operation_id" id="operation-id">

                    <div>Please copy and paste Fleet composition in the textbox below. </div>

                    <div class="form-group">
                        <div class="col-sm-12">
                            <textarea class="form-control" name="names-list" id="names-list" rows="16"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-yellow">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">
                    {{ trans('calendar::seat.close') }}
                </button>
                <button type="button" class="btn btn-outline" id="manual_record_submit">
                    {{ trans('calendar::seat.update_confirm_button_yes') }}
                </button>
            </div>
        </div>
    </div>
</div>
