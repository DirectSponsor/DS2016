@if(count($coords)) <table class="table data table-striped table-bordered"> @else <table> @endif
    <thead><tr>
        <th>Project Name</th>
        <th>Username</th>
        <th>Recipients</th>
        <th>Sponsors</th>
    </tr></thead>
    <tbody>
    @if(!count($coords))
    <tr>
        <td colspan="4"><p>There are no coordinators yet ! </p></td>
    </tr>
    @endif
    @foreach($coords as $coord)
    <tr>
        <td>{!! $coord->project->name !!}</td>
        <td>{!! $coord->user->username !!}</td>
        <td>{!! $coord->project->recipients()->count() !!}</td>
        <td>{!! $coord->project->sponsors()->count() !!}</td>
    </tr>
    @endforeach
</tbody></table>