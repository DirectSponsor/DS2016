@if(!$project->isFullySubscribedWithRecipients())
    @include('invitations.create')
@endif

<table class="table data table-striped table-bordered">
    <thead><tr>
        <th>Date</th>
        <th>Sent To</th>
    </tr></thead>
    <tbody>
        @if(!count($invitations))
        <tr>
            <td colspan="4"><p>There are no invitations yet !</p></td>
        </tr>
        @endif
        @foreach($invitations as $invitation)
        <tr>
            <td>{!! $invitation->created_at !!}</td>
            <td>{!! $invitation->sent_to !!}</td>
            <td>{!! $invitation->role->descriptor !!}</td>
        </tr>
        @endforeach
    </tbody>
</table>