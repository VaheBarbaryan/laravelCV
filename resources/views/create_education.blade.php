@extends('layouts.admin')

@section('content')

    <form action="" method="post" class="form-block">
        @csrf
        <div class="employer__form">
            <h3 class="form__title">Կրթություն</h3>
            <button type="button" class="form__btn btn btn-success addEducation">Ավելացնել</button>
            <div class="table-responsive">
                <table class="table table-bordered " id="create_education__form">
                    <thead>
                    <tr style="text-align: center;">
                        <th scope="row" style="width: 95%;">Համալսարան</th>
                        <th scope="row">Ջնջել</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td style="width: 50%;">
                            <div class="form-group" style="width: 100%; margin-bottom: 0;">
                                <input class="form-control institute" type="text" data-institute="institute.0">
                            </div>
                        </td>
                        <td>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="submit ">
            <input id="submit" type="submit" name="add" value="Հաստատել" class="form__btn btn btn-success font-20">
        </div>

    </form>



@endsection
@push('script')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('[data-institute="institute.0"]').on('keyup', function () {
            if($(this).val().length === 0) {
                $(this).addClass('is-invalid');
                $(this).parent().find('p').remove();
                $(this).parent().append(
                    `
                        <p class="invalid-feedback d-flex justify-content-start mb-0" role="alert">
                            Այս դաշտը պարտադիր է
                        </p>
                    `
                );
                return
            }
            $(this).removeClass('is-invalid');
            $(this).parent().find('p').remove();
        });
        $('.addEducation').click(function () {
            var rowCount = $('#create_education__form tr').length - 1;
            if (rowCount < 0) {
                rowCount = 0;
            }
            $('#create_education__form tbody').append(
                `
                 <tr>
                        <td style="width: 50%;">
                            <div class="form-group" style="width: 100%; margin-bottom: 0;">
                                <input class="form-control institute" type="text" data-institute="institute.${rowCount}">
                            </div>
                        </td>
                        <td style="text-align: center;">
                            <button class="btn removeEducation" type="button" style="color: red; font-size: 22px;" onmouseover="this.style.color='#D70000';" onmouseout="this.style.color='red';"><i class="fa-solid fa-circle-xmark"></i></button>
                        </td>
                    </tr>
                `
            );
            $(`[data-institute="institute.${rowCount}"]`).on('keyup', function () {
                if($(this).val().length === 0) {
                    $(this).addClass('is-invalid');
                    $(this).parent().find('p').remove();
                    $(this).parent().append(
                        `
                        <p class="invalid-feedback d-flex justify-content-start mb-0" role="alert">
                            Այս դաշտը պարտադիր է
                        </p>
                    `
                    );
                    return
                }
                $(this).removeClass('is-invalid');
                $(this).parent().find('p').remove();
            });
        });
        $("#create_education__form").on('click', '.removeEducation', function () {
            $(this).closest('tr').remove();
        });
        $(document).on('click', '#submit', function (e) {
            e.preventDefault();
            var institute_arr = [];
            $(".institute").each(function () {
               institute_arr.push($(this).val());
            });
            console.log(institute_arr);
            $.ajax({
                url: "{{ route('add_edcuation') }}",
                type: "POST",
                data: {
                    'institute': institute_arr
                },
                success: function (response) {
                    if($.isEmptyObject(response.errors)) {
                        window.location = '{{ route("education_dash") }}';
                    }else {
                        $.each(response.errors, function (key, value) {
                            $('[data-institute="' + key + '"]').addClass('is-invalid');
                            $('[data-institute="' + key + '"]').parent().find('p').remove();
                            $('[data-institute="' + key + '"]').parent().append(
                                `
                                    <p class="invalid-feedback d-flex justify-content-start mb-0" role="alert">
                                        ${value[0]}
                                    </p>
                                `
                            );
                        });
                    }
                }
            })
        })
    </script>
@endpush
