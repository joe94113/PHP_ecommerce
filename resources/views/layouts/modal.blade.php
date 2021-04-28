<!-- Modal -->
<div class="modal fade" id="notifications" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">通知</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul>
                    @foreach ($notifications as $notification)
                    <li>{{ $notification->data['msg'] }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>