@if($search_count > 0)
    @foreach($search_result as $s)
        <tr >
            <td class="text-center" width="20%" >
                @if(empty($s->image))
                    <img class="img-circle" src="{{ asset('assets/vendor/images/profile_picture/empty.jpg') }}"width="20%" alt="" title="Unavailable">
                @else
                    <img class="img-circle" src="{{ asset('assets/vendor/images/profile_picture/') }}/{{$s->image}}" width="20%" alt="" >
                @endif
            </td>
            <td class="text-center"><b>{{$s->name}}</b></td>
            <td class="text-center"><b>{{$s->email}}</b></td>
            <td class="text-center"><b>{{$s->phone}}</b></td>
            <td class="text-center"><b>{{$s->gender}}</b></td>
            <td class="text-center"><b>{{$s->address}} <mark>{{$s->city}}</mark></b></td>
            <td>
                <a href="{{route('customer_details',Crypt::encrypt($s->id))}}" title="See Details" class="btn btn-primary "><i class="fas fa-arrow-circle-right"></i> </a>
            </td>
        </tr>
    @endforeach
@else
        <tr >
            <td class="text-center" colspan="9"><h1 style="color: red">No data Found</h1></td>
        </tr>
@endif


