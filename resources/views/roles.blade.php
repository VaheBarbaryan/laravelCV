@extends('layouts.admin')


@section('content')
<div class="wrapper" style="display: flex;justify-content: center;align-items: center; flex-direction: column; text-align: center;">
    <h2>Դերերի ցուցակ</h2>
    <div class="table-responsive"  style="display: flex;justify-content: center;">
        <table class="styled-table" style="border-top-left-radius: 15px; border-top-right-radius: 15px;overflow: hidden">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Դերի անուն</th>
            </tr>
            </thead>
            <tbody>
            @if($roles)
                @foreach($roles as $role)

                    <tr>
                        <th>{{ $role->id }}</th>
                        <th>{{ $role->name }}</th>
                    </tr>

                @endforeach
            @endif
            </tbody>
        </table>
    </div>
    <h2 class="mb-3">Օգտատերերի դերերի ցուցակ</h2>
    <form action="{{ route('find_roles') }}" method="post">
        @csrf
        <div class="form-group">
            <input type="number" name="role_id" id="role_number" placeholder="Փնտրել ըստ դերի id-ի" class="form-control" min="1">
            <input type="submit" value="Գտնել" class="role_btn btn btn-success mt-4">
        </div>
    </form>
    <div class="table-responsive" style="display: flex;justify-content: center;">
        <table class="styled-table" style="border-top-left-radius: 15px; border-top-right-radius: 15px;overflow: hidden">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Անուն</th>
                <th scope="col">Դեր</th>
            </tr>
            </thead>
            <tbody>
            @if($user_role)
                @foreach($user_role as $item)
                    <tr>
                        <th>{{ $item->id }}</th>
                        <th>{{ $item->name }}</th>
                        <th>@foreach($item->role as $role){{$role->name}}@if(!$loop->last),@endif @endforeach</th>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
</div>



@endsection

@push('script')
    <script>
        $(document).ready(function () {
            $('.role_btn').click(function () {
                console.log(123);
                $('table tbody').empty();
            });
        })
    </script>
@endpush