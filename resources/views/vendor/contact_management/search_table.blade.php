<table class="table table-hover">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Name</th>
        <th scope="col">Email</th>
        <th scope="col">Phone</th>
        <th scope="col">Address</th>
        <th scope="col">Type</th>
        <th scope="col">Message</th>
        <th scope="col">Note</th>
        <th scope="col">Status</th>
        <th scope="col">Date</th>
        <th scope="col">Actions</th>
    </tr>
    </thead>
    <tbody>
    @php $i=1 @endphp
    @foreach($search_contacts as $s)
        <tr>
            <th>{{ $i }}</th>
            <td>{{$s->name}}</td>
            <td>{{ $s->email }}</td>
            <td>{{ $s->phone }}</td>
            <td>{{ $s->address }}</td>
            <td><span class="label label-info">{{ $s->type }}</span></td>
            <td>{{ Str::limit($s->message, 50) }}</td>
            <td> <span style="color: red">{{ Str::limit($s->note, 20) }}</span></td>
            <td>
                @if($s->status == "Pending")
                    <span class="label label-info">{{ $s->status }}</span>
                @elseif($s->status == "Solved")
                    <span class="label label-success">{{ $s->status }}</span>
                @elseif($s->status == "Cancelled")
                    <span class="label label-danger">{{ $s->status }}</span>
                @elseif($s->status == "Processing")
                    <span class="label label-primary">{{ $s->status }}</span>
                @endif
            </td>
            <td>{{ $s->created_at }}</td>
            <td class="text-left">
                <a href="{{ route('contact_details',Crypt::encrypt($s->id) ) }}" title="Details" class="btn btn-primary"> <i class="fas fa-arrow-circle-right"></i></a>
                <a href="{{ route('contact_delete',Crypt::encrypt($s->id) ) }}" title="Delete" onclick="return confirm('Are you sure ?')" class="btn btn-danger"> <i class="fa fa-trash"></i></a>
            </td>
        </tr>
        @php $i++ @endphp
    @endforeach
    </tbody>
</table>
