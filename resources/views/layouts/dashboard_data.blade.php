
@foreach($employers as $employ)
    <tr @if($loop->last) style="border-bottom: 2px solid #3490dc;" @endif>
        <input type="hidden" class="delete-employ" value="{{ $employ->id }}">
        <th scope="row">{{ $employ->id }}</th>
        <td>{{ $employ->name_surname }}</td>
        @if(\Illuminate\Support\Facades\Session::get('filter_application_date') )
            <td>{{date('d.m.Y',strtotime($employ->application_date))}} թ.</td>
        @endif
        @if(\Illuminate\Support\Facades\Session::get('filter_date_interview') )
            <td>{{date('d.m.Y',strtotime($employ->date_interview))}} թ.</td>
        @endif
        @if(\Illuminate\Support\Facades\Session::get('filter_phone') )
            <td>
                @foreach($employ->phone as $item)
                    <span>{{$item->phone_code}} {{$item->phone_number}}@if(!$loop->last),@endif</span><br>
                @endforeach
            </td>
        @endif
        @if(\Illuminate\Support\Facades\Session::get('filter_birth_date') )
            <td>{{date('d.m.Y',strtotime( $employ->birth_date ))}} թ.</td>
        @endif
        @if(\Illuminate\Support\Facades\Session::get('filter_expected_salary'))
            <td>{{ (($employ->expected_salary) ? (number_format($employ->expected_salary,0,'.',' ')) : '') }} {{ (($employ->expected_salary) ? 'ՀՀ դրամ' : '') }}</td>
        @endif
        @if(\Illuminate\Support\Facades\Session::get('filter_proffession') )
            <td>{{ $employ->proffession }}</td>
        @endif
        @if(\Illuminate\Support\Facades\Session::get('filter_education') )
            <td>
                @if($employ->education)
                    @foreach($employ->education as $fac)
                        <span>{{(($fac->faculty) ? $fac->faculty->faculty_name : '')}}@if(!$loop->last),@endif</span>
                    @endforeach
                @endif
            </td>
        @endif
        @if(\Illuminate\Support\Facades\Session::get('filter_experience'))
            <td>
                @if($employ->experience)
                    @foreach($employ->experience as $exp)
                        <span>{{(($exp->name_company) ? $exp->name_company: '')}}@if(!$loop->last),@endif</span>
                    @endforeach
                @endif
            </td>
        @endif
        @if(\Illuminate\Support\Facades\Session::get('filter_social_sites') )
            <td>
                @if($employ->social_site)
                    @foreach($employ->social_site as $item)
                        <a href="{{ $item->link }}" target="_blank">{{ $item->link }}</a>@if(!$loop->last), @endif
                    @endforeach
                @endif
            </td>
        @endif
        @if(\Illuminate\Support\Facades\Session::get('filter_files') )
            <td>
                @if($employ->cv)
                    @foreach($employ->cv as $cv)

                        <a href="{{ $cv->path }}"  target="_blank">{{ $cv->name }}</a>{{--@if(!$loop->last),@endif--}}<br>

                    @endforeach
                @endif
            </td>
        @endif
        @if(\Illuminate\Support\Facades\Session::get('filter_comments'))
            <td>{{ ($employ->comments) ? ($employ->comments) : '' }}</td>
        @endif
        <td class="d-flex justify-content-center gap-1">
            <a href="{{ route('view_cv',$employ->id) }}" class="btn btn-primary">Նայել</a>
            <a href="{{ route('editCV', $employ->id) }}" class="btn" style="background-color: orange; color: #ffffff;" onmouseover="this.style.backgroundColor='#d79400';" onmouseout="this.style.backgroundColor='orange';">Փոփոխել</a>
            <button class="btn btn-danger delete-btn " type="button">Ջնջել</button>
        </td>
    </tr>
@endforeach






<tr style="position: absolute; bottom: 0;left: 50%;transform: translateX(-50%); border-bottom: none">
    <td colspan="14" align="center" style="background-color: #ffffff;">
            {!! $employers->links('pagination::bootstrap-4') !!}
    </td>
</tr>