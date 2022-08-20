@extends('layouts.admin')

@section('content')
    <div class="wrapper">
        <form action="{{ route('payTerminal') }}" method="post" class="form-block">
            @csrf
            <h1 class="mb-4">Տերմինալ</h1>
            @if(\Illuminate\Support\Facades\Session::has('message'))
                <div class="alert alert-danger">{{ \Illuminate\Support\Facades\Session::get('message') }}</div>
            @endif
            @if(\Illuminate\Support\Facades\Session::has('success'))
                <div class="alert alert-success">{{ \Illuminate\Support\Facades\Session::get('success') }}</div>
            @endif
            @if(count($Values) > 0)
                @foreach($Values as $Value)
                        <span>{{ $Value }}</span>
                @endforeach
            @endif
            <div class="employer__form">
                <div class="form-group">
                    <input type="number" class="form-control {{ ($errors->has('paymentAmount')) ? ' is-invalid' : '' }}" name="paymentAmount" placeholder="Վճարվող գումար" value="{{ old('paymentAmount') }}" step="100" min="100" oninvalid="this.setCustomValidity('Խնդրում ենք մուտքագրել վավեր արժեք:')" oninput="this.setCustomValidity('')">
                    @if($errors->has('paymentAmount'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('paymentAmount') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <input type="number" class="form-control {{ ($errors->has('incomingAmount')) ? ' is-invalid' : '' }}" name="incomingAmount" placeholder="Մուտքագրվող գումար" value="{{ old('incomingAmount') }}" step="100" min="100" oninvalid="this.setCustomValidity('Խնդրում ենք մուտքագրել վավեր արժեք:')" oninput="this.setCustomValidity('')">
                    @if($errors->has('incomingAmount'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('incomingAmount') }}</strong>
                        </span>
                    @endif
                </div>


            </div>
            <div class="submit">
                <input type="submit" class="form__btn btn btn-success" value="Վճարել">
            </div>

        </form>
    </div>
@endsection
