{{-- use $btnurl for destination! use $btnclass to style button $msg  for a custom delete message--}}

<!-- Button trigger modal -->
<button type="button" class="{{ $btnclass ?? "btn btn-danger" }}" data-toggle="modal" data-target="#deleteModal">
    Delete
</button>

<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger" id="deleteModalLabel">Warning</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{ $msg ?? "You are about to delete an Object!" }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                <a href="{{ $btnurl }}" class="btn btn-danger">Confirm</a>

            </div>
        </div>
    </div>
</div>
