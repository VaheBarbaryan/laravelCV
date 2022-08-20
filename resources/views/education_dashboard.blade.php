@extends('layouts.admin')
@section('content')
    <h1 style="text-align: center;">Համալսարանների ցուցակ</h1>
    @if(\Session::has('message'))

        <div class="text-center">
            <div class="alert alert-success" style="display: inline-block;">
                {{ \Session::get('message') }}
            </div>
        </div>

    @endif
    <form action="{{ route('uploadUni') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="customFile">Կցել ֆայլ (xls,xlsx)</label>
            <input class="file input form-control {{ $errors->has('file') ? 'is-invalid' : '' }}" type="file" name="file" id="customFile"  accept="application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" >
            @if($errors->has('file'))
                <p class="invalid-feedback">{{ $errors->first('file') }}</p>
            @endif
        </div>
            <input type="submit" class="btn btn-success" value="Հաստատել" style="max-width: 100px">
    </form>
    @if(count($education))
    <div class="table-responsive" style="display: flex;justify-content: center;">
        <table class="styled-table" style="border-top-left-radius: 15px; border-top-right-radius: 15px;overflow: hidden">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Համալսարան</th>
                <th scope="col">Փոփոխել</th>
                <th scope="col">Ջնջել</th>
            </tr>
            </thead>
            <tbody>

                @foreach($education as $ed)
                    <tr>
                        <input type="hidden" class="delete-education" value="{{ $ed->id }}">
                        <th scope="row">{{ $ed->id }}</th>
                        <td>{{ $ed->institute_name }}</td>
                        <td>
                            <a href="{{ route('edit_edu_form', $ed->id) }}" style="color: orange; font-size: 20px;" onmouseover="this.style.color='#d79400';" onmouseout="this.style.color='orange';"><i class="fa-solid fa-pen"></i></a>
                        </td>
                        <td>
                            <button class="delete-btn-edu" type="button" style="color: red; font-size: 22px;" onmouseover="this.style.color='#D70000';" onmouseout="this.style.color='red';"><i class="fa-solid fa-rectangle-xmark"></i></button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
        <p class="mt-4">Համալսարան դեռ ավելացված չէ</p>
    @endif
@endsection


@push('script')
    <script>
        setTimeout(function(){
            $('.alert').remove();
        }, 5000);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.delete-btn-edu').click(function (e) {
            e.preventDefault();
            var $delete_id = $(this).closest('tr').find('.delete-education').val();
            swal({
                title: "Դուք վստահ ե՞ք",
                icon: "warning",
                buttons: ["Չեղարկել", "Ջնջել"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        var $data = {
                            "id": $delete_id
                        };
                        $.ajax({
                            type: "DELETE",
                            url: '/deleteEducation/'+$delete_id,
                            // data: $data,
                            success: function (response) {
                                swal(response.success, "success")
                                swal(response.success, {
                                    icon: "success",
                                })
                                    .then((result) => {
                                        location.reload();
                                    });
                            },
                        });
                    }
                });
        });
    </script>
@endpush