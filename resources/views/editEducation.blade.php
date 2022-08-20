@extends('layouts.admin')

@section('content')

    <form action="" method="post" class="form-block">
        @csrf
        @if(\Session::has('message'))

            <div class="alert alert-success">
                {{ \Session::get('message') }}
            </div>
        @endif
        <div class="employer__form">
            <input type="hidden" id="institute_id" value="{{ $education->id }}">
            <h3 class="form__title">Կրթություն</h3>
            <div class="d-flex justify-content-between">
                <button type="button" class="form__btn btn btn-success addEducationEdit">Ավելացնել</button>
                <button type="button" class="form__btn btn btn-danger removeEducationEdit">Ջնջել նշվածները</button>
            </div>
            <div class="form-group">
                <input type="text" name="university" value="{{ $education->institute_name  }}" class="form-control text-center">
            </div>
            <div class="table-responsive">
                <table class="table table-bordered " id="edit_education__form">
                    <thead>
                        <tr>
                            <th scope="row"  style="width: 5%;"><input type="checkbox" id="selectAllFac"></th>
                            <th scope="row" style="width: 95%;">Ֆակուլտետ</th>
                        </tr>
                    </thead>
                    <tbody>

                    @if($education)



                        @foreach($education->faculty as $key => $ed)
                            <tr>
                                <td style="width: 5%;">
                                    <input type="checkbox" value="{{ $ed->id }}" class="select_fac" >
                                </td>
                                <td style="width: 95%;">
                                    <div class="form-group mb-0" style="width: 100%;">
                                        <input class="form-control faculties" type="text" data-faculty="faculty.{{$key}}"  value="{{ $ed->faculty_name }}">
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif


                    </tbody>
                </table>
            </div>
        </div>
        <div class="submit">
            <input id="submit" type="submit" name="add" value="Թարմացնել" class="form__btn btn btn-success font-20">
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
        $(".faculties").each(function () {
            $(this).on('keyup', function () {
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
        $("input[name='university']").on("keyup", function () {
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
        $("#selectAllFac").click(function () {
           $(".select_fac").prop('checked', $(this).prop('checked'));
        });
        $('.addEducationEdit').click(function () {
            var rowCount = $('#edit_education__form tbody tr').length;
            if (rowCount < 0) {
                rowCount = 0;
            }
            $('#edit_education__form tbody').append(
                `
                 <tr>
                 <td style="width: 5%;text-align: center;">
                        <button class="deleteFaculty " type="button" style="color: red;font-size: 20px;" onmouseover="this.style.color = '#D70000'" onmouseout="this.style.color = 'red'"><i class="fa-solid fa-rectangle-xmark"></i></button>
                 </td>
                     <td style="width: 95%;">
                        <div class="form-group mb-0" style="width: 100%;">
                            <input class="form-control faculties" type="text" data-faculty="faculty.${rowCount}" name=ed[${rowCount}][faculty]">
                        </div>
                     </td>
                 </tr>
                `
            );
            $(`[data-faculty="faculty.${rowCount}"]`).on('keyup', function () {
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
        $("#edit_education__form").on('click', '.deleteFaculty', function () {
            $(this).closest('tr').remove();
        });
        $(".removeEducationEdit").click(function (e) {
            e.preventDefault();
            swal({
                title: "Դուք վստահ ե՞ք",
                text: "Դուք վստահ ե՞ք, որ ուզում եք ջնջել նշված ֆակուլտետները։",
                icon: "warning",
                buttons: ["Չեղարկել", "Ջնջել"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        var $ins_id = $("#institute_id").val();
                        var select_fac = $(".select_fac:checked");
                        var vals = [];
                        select_fac.each(function (i) {
                            vals.push($(this).val());
                        });
                        $.ajax({
                            type: "DELETE",
                            url: '/editEducation/deleteFac/' + $ins_id,
                            data: {vals: vals},
                            success: function (response) {
                                console.log(response);
                                if(response.success) {
                                    swal(response.success, "success")
                                    swal(response.success, {
                                        icon: "success",
                                    })
                                        .then((result) => {
                                            location.reload();
                                        });
                                }
                                if(response.error) {
                                    swal(response.error, "error")
                                    swal(response.error, {
                                        icon: "error",
                                    })
                                }


                            },
                            error: function (response) {
                                console.log(response);
                            }
                        });
                    }
                });
        });
        $(document).on("click","#submit", function (e) {
            e.preventDefault();
            var $id = $("#institute_id").val();
            var faculty_arr = [];
            $(".faculties").each(function () {
                faculty_arr.push($(this).val());
            });
            var university = $("input[name='university']").val();
            $.ajax({
                type: "POST",
                url: "/editEducation/"+$id,
                data: {
                    faculty: faculty_arr,
                    university: university
                },
                success: function (response) {
                    console.log(response);
                    if($.isEmptyObject(response.errors)) {
                        window.location = '{{ route("education_dash") }}';
                    }else {
                        $.each(response.errors, function (key, value) {
                            $('[data-faculty="' + key + '"]').addClass('is-invalid');
                            $('[data-faculty="' + key + '"]').parent().find('p').remove();
                            $('[data-faculty="' + key + '"]').parent().append(
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
        });
    </script>
@endpush