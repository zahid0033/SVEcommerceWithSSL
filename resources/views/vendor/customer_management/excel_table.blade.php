<table class="table" >
        <thead >
        <tr>
            <th ><b >  Id</b></th>
            <th ><b >Name</b></th>
            <th ><b >Email</b></th>
            <th ><b >Address</b></th>
            <th ><b >City</b></th>
            <th > <b >Phone</b></th>
            <th ><b > Gender</b></th>
        </tr>
        </thead>
        <tbody >
    @foreach($search_result as $s)
        <tr >
            <td ><b >{{$s->id}}</b></td>
            <td >{{$s->name}}</td>
            <td >{{$s->email}}</td>
            <td >{{$s->address}}</td>
            <td >{{$s->city}}</td>
            <td >{{$s->phone}}</td>
            <td >{{$s->gender}}</td>
        </tr>
    @endforeach
        </tbody>
    </table>


