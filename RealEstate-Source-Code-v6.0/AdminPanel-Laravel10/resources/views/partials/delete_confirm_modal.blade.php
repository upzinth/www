<!-- Modal -->
<div class="modal fade" id="delete_confirm_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <form id="delete_confirm_form" method="POST">
            {{ csrf_field() }}
            @method('DELETE')
            <div class="modal-body">
                <input type="hidden" id="delete_confirm_entity_id" />
                Are you sure?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">CANCEL</button>
                <button type="submit" class="btn btn-danger">DELETE</button>
            </div>
        </form>
    </div>
    </div>
</div>
<!-- EndModal -->

@push('scripts')
<script>
    $(document).ready(function () {
        $(".table").on('click', '.delete-btn', function () {
            const entityId = $(this).data('entity-id');
            $("#delete_confirm_entity_id").val(entityId);
            $("#delete_confirm_form").attr('action', '/{{ $actionName }}/' + entityId);
            $("#delete_confirm_modal").modal('show');
        });
    });
</script>
@endpush
