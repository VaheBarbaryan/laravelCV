@extends('layouts.admin')


@section('content')

    <form method="post" class="form-block" enctype="multipart/form-data" style="max-width: 1000px">
        @csrf
        @if(\Illuminate\Support\Facades\Session::has('message'))
            <div class="alert alert-success">{{ \Illuminate\Support\Facades\Session::get('message') }}</div>
        @endif
        <h1 class="form__title"> Ռեզյումեի ստեղծում </h1>
        <div class="employer__form">
            <h3 class="form__title">Ընդհանուր տվյալներ</h3>
            <div class="form-group">
                <label for="application_date">Դիմելու Ամսաթիվ (օր,ամիս,տարի) <span style="color: red; font-size: 16px;">*</span></label>
                <input type="text" name="application_date" id="application_date" data-ajax-input="application_date"
                       class="input date form-control" placeholder="__/__/____" autocomplete="off">
            </div>
            <div class="form-group">
                <label for="date_interview">Հարցազրույցի Ամսաթիվ (օր,ամիս,տարի)<span
                            style="color: red; font-size: 16px;">*</span></label>
                <input type="text" name="date_interview" id="date_interview" data-ajax-input="date_interview"
                       class="input date form-control " placeholder="__/__/____" autocomplete="off">
            </div>
            <div class="form-group">
                <label for="name_surname">Անուն Ազգանուն <span style="color: red; font-size: 16px;">*</span></label>
                <input type="text" name="name_surname" id="name_surname" data-ajax-input="name_surname"
                       class="input form-control">
            </div>
            <div class="form-group">
                <label for="birth_date">Ծննդյան Ամսաթիվ (օր,ամիս,տարի) <span
                            style="color: red; font-size: 16px;">*</span></label>
                <input type="text" name="birth_date" id="birth_date" data-ajax-input="birth_date"
                       class="input date form-control" placeholder="__/__/____" autocomplete="off">
            </div>
            <div class="form-group">
                <label for="proffession">Մասնագիտություն <span style="color: red; font-size: 16px;">*</span></label>
                <input type="text" name="proffession" id="proffession" data-ajax-input="proffession"
                       class="input form-control ">
            </div>
            <div class="form-group">
                <label for="expected_salary">Ակնկալվող աշխատավարձ(դրամ)</label>
                <input type="number" min="20000" step="100" name="expected_salary" id="expected_salary"
                       data-ajax-input="expected_salary" class="input form-control">
            </div>

            <div class="form-group" id="phone-list">
                <div class="d-flex justify-content-between">
                    <label for="phone_numbers">Հեռախոսահամարներ <span
                                style="color: red; font-size: 16px;">*</span></label>
                    <button type="button" class="form__btn btn btn-success addPhoneNumber">Ավելացնել</button>
                </div>

                <div id="list">
                    <div class="row list-item" style="margin-bottom: 20px;">
                        <div class="col-md-3">
                            <select class="form-select phone_code_select" name="phones[0][code]"
                                    id="phone_code_select-0" style="border-color: #ced4da;" data-phonecode="+374">
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}"
                                            @if($country->id == 11) selected @endif>
                                        +{{ $country->phonecode}} {{$country->nicename }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-9">
                            <div class="row no-gutters">
                                <input style="width: 100%;" type="number" min="0" name="phones[0][phone]"
                                       id="phone_numbers" data-ajax-input="phones.0.phone_number"
                                       class="input phone_numbers form-control" onfocus="this.style.boxShadow = 'none'">
                            </div>

                        </div>
                    </div>
                </div>

            </div>

            <div class="form-group">
                <div class="d-flex justify-content-between">
                    <label>Սոցիալական կայքերի հղումները</label>
                    <button type="button" class="form__btn btn btn-success addLinks">Ավելացնել</button>
                </div>
                <div id="socialSites">
{{--                    <div class="row no-gutters mb-3">--}}
                        {{--                        <div class="col" style="height: 35px;">--}}
                        {{--                            <input type="text" id="social_site" data-ajax-input="social_sites.0" name="social_sites[0]"--}}
                        {{--                                   class="input social_sites rounded-0 form-control"--}}
                        {{--                                   style="margin-bottom: 10px; height: 100%;" onfocus="this.style.boxShadow = 'none'">--}}
                        {{--                        </div>--}}
                        {{--                    </div>--}}
{{--                    </div>--}}
                </div>
                <div class="form-group">
                    <label for="customFiles">Ներբեռնել ֆայլեր (pdf,docx) <span
                                style="color: red; font-size: 16px;">*</span></label>
                    <input type="file" name="files[]" id="customFiles" data-ajax-input="files"
                           class="files input form-control" accept="application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document" multiple>
                </div>
                <div class="form-group">
                    <label for="comments">Մեկնաբանություններ</label>
                    <textarea type="text" name="comments" id="comments"
                              class="input form-control form__textarea">{{ old('comments') }}</textarea>
                </div>
            </div>
        </div>

        <div class="education__form">
                <h3 class="form__title">Կրթություն</h3>
                <button type="button" class="form__btn btn btn-success addMoreEducation">Ավելացնել</button>
                <div class="table-responsive" style="overflow: visible;">
                    <table class="table table-bordered " id="educationForm">
                        <thead>
                        <tr style="text-align: center;">
                            <th scope="row">Համալսարան</th>
                            <th scope="row">Ֆակուլտետ</th>
                            <th scope="row">Ջնջել</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="experience__form">
                <h3 class="form__title">Աշխատանքային փորձ</h3>
                <button type="button" class="form__btn btn btn-success addMoreExperience">Ավելացնել</button>
                <div class="table-responsive">
                    <table class="table table-bordered" id="experienceForm">
                        <thead>
                        <th>Ընկերության անվանումը</th>
                        <th>Աշխատանքի սկիզբ (օր,ամիս,տարի)</th>
                        <th>Աշխատանքի ավարտ (օր,ամիս,տարի)</th>
                        <th>Աշխատավարձ(դրամ)</th>
                        <th>Ջնջել</th>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>

            </div>
            <div class="submit">
                <input type="submit" name="submit" value="Հաստատել" class=" btn btn-success font-20">
            </div>

    </form>

@endsection

@push('script')
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var $id = $("#phone_code_select-0").val();
            $.ajax({
                url: "/changePhoneCode/",
                type: 'GET',
                success: function (data) {
                    let code = "+" + data[$id - 1].phonecode;
                    $(this).attr('phonecode', code);
                }
            });
            // new TomSelect("#phone_code_select-0",{
            //     create: false,
            // });

            function phoneNumbers($this) {
                let bool = true;
                if ($this.val().length === 0) {
                    $this.addClass('is-invalid');
                    $this.parent().parent().find('p').remove();
                    $this.parent().parent().append(`
                                <p class="invalid-feedback d-flex justify-content-start px-2" role="alert" style="margin-top: 5px;margin-bottom: 0;">
                                    Այս դաշտը պարտադիր է
                                </p>
                            `);
                    $this.parent().next('div').find('.deleteNumber').css('border-color', '#d43b3b');
                    return false;
                }
                if ($this.val().length > 15) {
                    $this.val($this.val().slice(0, 15 - $this.val().length));
                }
                if (!/^[0-9]+$/.test($this.val())) {
                    $this.addClass('is-invalid');
                    $this.parent().parent().find('p').remove();
                    $this.parent().parent().append(`
                                <p class="invalid-feedback d-flex justify-content-start px-2" role="alert" style="margin-top: 5px;margin-bottom: 0;">
                                    Այս դաշտը պետք է պարունակի միայն թվեր
                                </p>
                            `);
                    $this.parent().next('div').find('.deleteNumber').css('border-color', '#d43b3b');
                    return false;
                }
                $this.removeClass("is-invalid");
                $this.parent().parent().find('p').remove();
                $this.parent().next('div').find('.deleteNumber').css('border-color', ' lightblue');
                return true;
            }

            $("body").on("change keyup", ".phone_numbers", function () {
                phoneNumbers($(this));
            });
            $("body").on("focus", ".phone_numbers", function () {
                if ($(this).val().length > 0) {
                    if (phoneNumbers($(this))) {
                        $(this).css('box-shadow', 'none');
                        $(this).parent().parent().find("button").css('border-color', 'lightblue');
                    } else {
                        $(this).css('box-shadow', 'none');
                        $(this).parent().parent().find("button").css('border-color', '#d43b3b');
                    }
                } else if ($(this).hasClass("is-invalid")) {
                    $(this).css('box-shadow', 'none');
                    $(this).parent().parent().find("button").css('border-color', '#d43b3b');

                } else {
                    $(this).css('box-shadow', 'none');
                    $(this).parent().parent().find("button").css('border-color', 'lightblue');
                }
            });
            $("body").on("focusout", ".phone_numbers", function () {
                if ($(this).val().length > 0) {
                    if (phoneNumbers($(this))) {
                        $(this).parent().parent().find("button").css('border-color', '#ced4da');
                    } else {
                        $(this).parent().parent().find("button").css('border-color', '#d43b3b');
                    }
                } else if ($(this).hasClass("is-invalid")) {
                    $(this).parent().parent().find("button").css('border-color', '#d43b3b');
                } else {
                    $(this).parent().parent().find("button").css('border-color', '#ced4da');
                }
            });

            function socialSites($this) {
                var length = $this.val().length;
                if (length === 0) {
                    $this.addClass('is-invalid');
                    $this.parent().parent().find('p').remove();
                    $this.parent().parent().append(`
                        <p class="invalid-feedback d-flex justify-content-start" role="alert" style="margin-top: 5px;margin-bottom: 0;">
                            Այս դաշտը պարտադիր է
                        </p>
                    `);
                    $this.parent().next('div').find('.deleteLink').css('border-color', '#d43b3b');
                    return false;
                }
                if (!/^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test($this.val())) {
                    $this.addClass('is-invalid');
                    $this.parent().parent().find('p').remove();
                    $this.parent().parent().append(`
                        <p class="invalid-feedback d-flex justify-content-start" role="alert" style="margin-top: 5px;margin-bottom: 0;">
                            Այս դաշտը վավեր չէ
                        </p>
                    `);
                    $this.parent().next('div').find('.deleteLink').css('border-color', '#d43b3b');
                    return false;
                }
                $this.removeClass("is-invalid");
                $this.parent().parent().find('p').remove();
                $this.parent().next('div').find('.deleteLink').css('border-color', 'lightblue');
                return true;
            }

            $("body").on("change keyup", ".social_sites", function () {
                socialSites($(this));
            });
            $("body").on("focus", ".social_sites", function () {
                if ($(this).val().length > 0) {
                    if (socialSites($(this))) {
                        $(this).css('box-shadow', 'none');
                        $(this).parent().parent().find("button").css('border-color', 'lightblue');
                    } else {
                        $(this).css('box-shadow', 'none');
                        $(this).parent().parent().find("button").css('border-color', '#d43b3b');
                    }
                } else if ($(this).hasClass("is-invalid")) {
                    $(this).css('box-shadow', 'none');
                    $(this).parent().parent().find("button").css('border-color', '#d43b3b');

                } else {
                    $(this).css('box-shadow', 'none');
                    $(this).parent().parent().find("button").css('border-color', 'lightblue');
                }
            });
            $("body").on("focusout", ".social_sites", function () {
                if ($(this).val().length > 0) {
                    if (socialSites($(this))) {
                        $(this).parent().parent().find("button").css('border-color', '#ced4da');
                    } else {
                        $(this).parent().parent().find("button").css('border-color', '#d43b3b');
                    }
                } else if ($(this).hasClass("is-invalid")) {
                    $(this).parent().parent().find("button").css('border-color', '#d43b3b');
                } else {
                    $(this).parent().parent().find("button").css('border-color', '#ced4da');
                }
            });

            function date_validation($item, $year, $year2) {
                let $item_arr = $item.val().split("/");
                if ($item.val().length > 0) {
                    if (/_/i.test($item_arr[0]) || /_/i.test($item_arr[1]) || /_/i.test($item_arr[2]) || $item_arr[0] < 1 || $item_arr[0] > 31 || $item_arr[1] < 1 || $item_arr[1] > 31 || $item_arr[2] < (new Date().getFullYear() - $year) || $item_arr[2] > (new Date().getFullYear() + $year2) || $item_arr[1] == '02' && $item_arr[0] > 29 || $item_arr[1] == '04' && $item_arr[0] > 30 || $item_arr[1] == '06' && $item_arr[0] > 30 || $item_arr[1] == '09' && $item_arr[0] > 30 || $item_arr[1] == 11 && $item_arr[0] > 30) {
                        $item.addClass("is-invalid");
                        $item.parent().find('p').remove();
                        $item.parent().append(`
                        <p class="invalid-feedback d-flex justify-content-end" role="alert">
                            Այս դաշտը վավեր չէ
                        </p>
                   `);
                        return false;
                    }
                }
                return true;
            }

            $("#application_date").on("keyup keypress change", function () {
                if ($(this).val().length === 0) {
                    $(this).addClass("is-invalid");
                    $(this).parent().find('p').remove();
                    $(this).parent().append(`
                        <p class="invalid-feedback d-flex justify-content-end" role="alert">
                            Այս դաշտը պարտադիր է
                        </p>
                   `);
                    return
                }
                if (!date_validation($(this), 50, 0)) {
                    return
                }
                let $app_date = $("#application_date");
                let $app_date_arr = $("#application_date").val().split("/");
                if ($("#date_interview").val().length > 0) {
                    let $date_int_arr = $("#date_interview").val().split("/");
                    if ($app_date_arr[2] > $date_int_arr[2]) {
                        $app_date.addClass("is-invalid");
                        $app_date.parent().find('p').remove();
                        $("#date_interview").addClass("is-invalid");
                        $app_date.parent().append(`
                            <p class="invalid-feedback d-flex justify-content-end" role="alert">
                                Այս ամսաթիվը չի կարող լինել հարցազրույցի ամսաթվից հետո
                            </p>
                        `);
                        return
                    }
                    if ($app_date_arr[2] === $date_int_arr[2] && $app_date_arr[1] > $date_int_arr[1]) {
                        $app_date.addClass("is-invalid");
                        $app_date.parent().find('span').remove();
                        $("#date_interview").addClass("is-invalid");
                        $app_date.parent().append(`
                            <span class="invalid-feedback d-flex justify-content-end" role="alert">
                                Այս ամսաթիվը չի կարող լինել հարցազրույցի ամսաթվից հետո
                            </span>
                        `);
                        return
                    }

                    if ($app_date_arr[2] === $date_int_arr[2] && $app_date_arr[1] === $date_int_arr[1] && $app_date_arr[0] > $date_int_arr[0]) {
                        $app_date.addClass("is-invalid");
                        $app_date.parent().find('p').remove();
                        $("#date_interview").addClass("is-invalid");
                        $app_date.parent().append(`
                            <p class="invalid-feedback d-flex justify-content-end" role="alert">
                                Այս ամսաթիվը չի կարող լինել հարցազրույցի ամսաթվից հետո
                            </p>
                        `);
                        return
                    }
                }
                $app_date.removeClass("is-invalid");
                $app_date.parent().find('p').remove();


                $("#date_interview").removeClass("is-invalid");
                $("#date_interview").parent().find('p').remove();
                if ($("#birth_date").val().length > 0) {
                    let $birth_date_arr = $("#birth_date").val().split("/");
                    if ($app_date_arr[2] < $birth_date_arr[2]) {
                        $app_date.addClass("is-invalid");
                        $app_date.parent().find('p').remove();
                        $("#birth_date").addClass("is-invalid");
                        $app_date.parent().append(`
                            <p class="invalid-feedback d-flex justify-content-end" role="alert">
                                Այս ամսաթիվը չի կարող լինել ծննդյան ամսաթվից առաջ
                            </p>
                        `);
                        return
                    }
                    if ($app_date_arr[2] === $birth_date_arr[2] && $app_date_arr[1] < $birth_date_arr[1]) {
                        $app_date.addClass("is-invalid");
                        $app_date.parent().find('span').remove();
                        $("#date_interview").addClass("is-invalid");
                        $app_date.parent().append(`
                            <span class="invalid-feedback d-flex justify-content-end" role="alert">
                                Այս ամսաթիվը չի կարող լինել ծննդյան ամսաթվից առաջ
                            </span>
                        `);
                        return
                    }

                    if ($app_date_arr[2] === $birth_date_arr[2] && $app_date_arr[1] === $birth_date_arr[1] && $app_date_arr[0] < $birth_date_arr[0]) {
                        $app_date.addClass("is-invalid");
                        $app_date.parent().find('p').remove();
                        $("#date_interview").addClass("is-invalid");
                        $app_date.parent().append(`
                            <p class="invalid-feedback d-flex justify-content-end" role="alert">
                                Այս ամսաթիվը չի կարող լինել ծննդյան ամսաթվից առաջ
                            </p>
                        `);
                        return
                    }
                }
                if ($("#birth_date").val().length > 0) {
                    if (!date_validation($("#birth_date"), 50, -16)) {
                        return
                    }
                }
                $("#birth_date").removeClass("is-invalid");
                $("#birth_date").parent().find('p').remove();
            });
            $("#date_interview").on("keyup change", function () {
                if ($(this).val().length === 0) {
                    $(this).addClass("is-invalid");
                    $(this).parent().find('p').remove();
                    $(this).parent().append(`
                        <p class="invalid-feedback d-flex justify-content-end" role="alert">
                            Այս դաշտը պարտադիր է
                        </p>
                   `);
                    return false;
                }
                if (!date_validation($(this), 50, 1)) {
                    return
                }
                var $date_int = $(this);
                var $date_int_arr = $(this).val().split("/");
                if ($("#application_date").val().length > 0) {
                    var $app_date_arr = $("#application_date").val().split("/");
                    if ($app_date_arr[2] > $date_int_arr[2]) {
                        $date_int.addClass("is-invalid");
                        $date_int.parent().find('p').remove();
                        $("#application_date").addClass("is-invalid");
                        $("#application_date").parent().find('p').remove();
                        $("#application_date").parent().append(`
                            <p class="invalid-feedback d-flex justify-content-end" role="alert">
                                Այս ամսաթիվը չի կարող լինել հարցազրույցի ամսաթվից հետո
                            </p>
                        `);
                        return
                    }
                    if ($app_date_arr[2] === $date_int_arr[2] && $app_date_arr[1] > $date_int_arr[1]) {
                        $date_int.addClass("is-invalid");
                        $date_int.parent().find('p').remove();
                        $("#application_date").addClass("is-invalid");
                        $("#application_date").parent().find('p').remove();
                        $("#application_date").parent().append(`
                            <p class="invalid-feedback d-flex justify-content-end" role="alert">
                                Այս ամսաթիվը չի կարող լինել հարցազրույցի ամսաթվից հետո
                            </p>
                        `);
                        return
                    }
                    if ($app_date_arr[2] === $date_int_arr[2] && $app_date_arr[1] === $date_int_arr[1] && $app_date_arr[0] > $date_int_arr[0]) {
                        $date_int.addClass("is-invalid");
                        $date_int.parent().find('p').remove();
                        $("#application_date").addClass("is-invalid");
                        $("#application_date").parent().find('p').remove();
                        $("#application_date").parent().append(`
                            <p class="invalid-feedback d-flex justify-content-end" role="alert">
                                Այս ամսաթիվը չի կարող լինել հարցազրույցի ամսաթվից հետո
                            </p>
                        `);
                        return
                    }
                }
                if ($("#application_date").val().length > 0) {
                    if (!date_validation($("#application_date"), 50, 0)) {
                        return
                    }
                }
                $("#application_date").removeClass("is-invalid");
                $("#application_date").parent().find('p').remove();
                if ($("#birth_date").val().length > 0) {
                    var $birth_date_arr = $("#birth_date").val().split("/");
                    let $date_interview = $("#date_interview");
                    let $date_interview_arr = $("#date_interview").val().split("/");
                    if ($date_interview_arr[2] < $birth_date_arr[2]) {
                        $date_interview.addClass("is-invalid");
                        $date_interview.parent().find('p').remove();
                        $("#birth_date").addClass("is-invalid");
                        $date_interview.parent().append(`
                            <p class="invalid-feedback d-flex justify-content-end" role="alert">
                                Այս ամսաթիվը չի կարող լինել ծննդյան ամսաթվից առաջ
                            </p>
                        `);
                        return
                    }
                    if ($date_interview_arr[2] === $birth_date_arr[2] && $date_interview_arr[1] < $birth_date_arr[1]) {
                        $date_interview.addClass("is-invalid");
                        $date_interview.parent().find('span').remove();
                        $("#date_interview").addClass("is-invalid");
                        $date_interview.parent().append(`
                            <span class="invalid-feedback d-flex justify-content-end" role="alert">
                                Այս ամսաթիվը չի կարող լինել ծննդյան ամսաթվից առաջ
                            </span>
                        `);
                        return
                    }

                    if ($date_interview_arr[2] === $birth_date_arr[2] && $date_interview_arr[1] === $birth_date_arr[1] && $date_interview_arr[0] < $birth_date_arr[0]) {
                        $date_interview.addClass("is-invalid");
                        $date_interview.parent().find('p').remove();
                        $("#date_interview").addClass("is-invalid");
                        $date_interview.parent().append(`
                            <p class="invalid-feedback d-flex justify-content-end" role="alert">
                                Այս ամսաթիվը չի կարող լինել ծննդյան ամսաթվից առաջ
                            </p>
                        `);
                        return
                    }
                }
                $date_int.removeClass("is-invalid");
                $date_int.parent().find('p').remove();
                if ($("#birth_date").val().length > 0) {
                    if (!date_validation($("#birth_date"), 50, -16)) {
                        return
                    }
                }
                $("#birth_date").removeClass("is-invalid");
                $("#birth_date").parent().find("p").remove();
                // if(!date_validation($("#application_date"),50,0)) {
                //     return
                // }
            });
            $("#birth_date").on("keyup keypress change", function () {
                if ($(this).val().length === 0) {
                    $(this).addClass("is-invalid");
                    $(this).parent().find('p').remove();
                    $(this).parent().append(`
                        <p class="invalid-feedback d-flex justify-content-end" role="alert">
                            Այս դաշտը պարտադիր է
                        </p>
                   `);
                    return
                }
                if (!date_validation($(this), 50, -16)) {
                    return
                }
                var $birth_date = $(this);
                var $birth_date_arr = $(this).val().split("/");
                if ($("#application_date").val().length > 0) {
                    let $app_date = $("#application_date");
                    let $app_date_arr = $("#application_date").val().split("/");
                    if ($app_date_arr[2] < $birth_date_arr[2]) {
                        $app_date.addClass("is-invalid");
                        $app_date.parent().find('p').remove();
                        $("#birth_date").addClass("is-invalid");
                        $app_date.parent().append(`
                            <p class="invalid-feedback d-flex justify-content-end" role="alert">
                                Այս ամսաթիվը չի կարող լինել ծննդյան ամսաթվից հետո
                            </p>
                        `);
                        return
                    }
                    if ($app_date_arr[2] === $birth_date_arr[2] && $app_date_arr[1] < $birth_date_arr[1]) {
                        $app_date.addClass("is-invalid");
                        $app_date.parent().find('span').remove();
                        $("#date_interview").addClass("is-invalid");
                        $app_date.parent().append(`
                            <span class="invalid-feedback d-flex justify-content-end" role="alert">
                                Այս ամսաթիվը չի կարող լինել ծննդյան ամսաթվից հետո
                            </span>
                        `);
                        return
                    }

                    if ($app_date_arr[2] === $birth_date_arr[2] && $app_date_arr[1] === $birth_date_arr[1] && $app_date_arr[0] < $birth_date_arr[0]) {
                        $app_date.addClass("is-invalid");
                        $app_date.parent().find('p').remove();
                        $("#date_interview").addClass("is-invalid");
                        $app_date.parent().append(`
                            <p class="invalid-feedback d-flex justify-content-end" role="alert">
                                Այս ամսաթիվը չի կարող լինել ծննդյան ամսաթվից հետո
                            </p>
                        `);
                        return
                    }
                }

                if ($("#application_date").val().length > 0) {
                    if (!date_validation($("#application_date"), 50, 0)) {
                        return
                    }
                }
                $("#application_date").removeClass('is-invalid');
                $("#application_date").parent().find('p').remove();
                if ($("#date_interview").val().length > 0) {
                    let $date_interview = $("#date_interview");
                    let $date_interview_arr = $("#date_interview").val().split("/");
                    if ($date_interview_arr[2] < $birth_date_arr[2]) {
                        $date_interview.addClass("is-invalid");
                        $date_interview.parent().find('p').remove();
                        $("#birth_date").addClass("is-invalid");
                        $date_interview.parent().append(`
                            <p class="invalid-feedback d-flex justify-content-end" role="alert">
                                Այս ամսաթիվը չի կարող լինել ծննդյան ամսաթվից հետո
                            </p>
                        `);
                        return
                    }
                    if ($date_interview_arr[2] === $birth_date_arr[2] && $date_interview_arr[1] < $birth_date_arr[1]) {
                        $date_interview.addClass("is-invalid");
                        $date_interview.parent().find('span').remove();
                        $("#date_interview").addClass("is-invalid");
                        $date_interview.parent().append(`
                            <span class="invalid-feedback d-flex justify-content-end" role="alert">
                                Այս ամսաթիվը չի կարող լինել ծննդյան ամսաթվից հետո
                            </span>
                        `);
                        return
                    }

                    if ($date_interview_arr[2] === $birth_date_arr[2] && $date_interview_arr[1] === $birth_date_arr[1] && $date_interview_arr[0] < $birth_date_arr[0]) {
                        $date_interview.addClass("is-invalid");
                        $date_interview.parent().find('p').remove();
                        $("#date_interview").addClass("is-invalid");
                        $date_interview.parent().append(`
                            <p class="invalid-feedback d-flex justify-content-end" role="alert">
                                Այս ամսաթիվը չի կարող լինել ծննդյան ամսաթվից հետո
                            </p>
                        `);
                        return
                    }
                }
                if ($("#date_interview").val().length > 0) {
                    if (!date_validation($("#date_interview"), 50, 1)) {
                        return
                    }
                }

                $("#date_interview").removeClass('is-invalid');
                $("#date_interview").parent().find('p').remove();

                $birth_date.removeClass("is-invalid");
                $birth_date.parent().find('p').remove();
            });
            $("#name_surname").on("keyup keypress change", function () {
                if ($(this).val().length === 0) {
                    $(this).addClass("is-invalid");
                    $(this).parent().find('p').remove();
                    $(this).parent().append(`
                        <p class="invalid-feedback d-flex justify-content-start" role="alert">
                            Այս դաշտը պարտադիր է
                        </p>
                    `);
                    return
                }
                if ($(this).val().length > 0 && /[~!@#$%^&*()_|+\=?;:..’“'"<>,€£¥•،\{\}\[\]\\\/]+/gi.test($(this).val()) || /[0-9]/.test($(this).val())) {
                    $(this).addClass("is-invalid");
                    $(this).parent().find('p').remove();
                    $(this).parent().append(`
                        <p class="invalid-feedback d-flex justify-content-start" role="alert">
                            Այս դաշտը չպետք է պարունակի անօրինական նիշեր կամ թվեր
                        </p>
                    `);
                    return
                }
                $(this).removeClass("is-invalid");
                $(this).parent().find('p').remove();
            });
            $("#proffession").on("keyup keypress change", function () {
                if ($(this).val().length === 0) {
                    $(this).addClass("is-invalid");
                    $(this).parent().find('p').remove();
                    $(this).parent().append(`
                        <p class="invalid-feedback d-flex justify-content-start" role="alert">
                            Այս դաշտը պարտադիր է
                        </p>
                    `);
                    return
                }
                if ($(this).val().length > 0 && /[~!@#$%^&*()_|+\=?;:..’“'"<>,€£¥•،٫؟»«\{\}\[\]\\\/]+/gi.test($(this).val()) || /[0-9]/.test($(this).val())) {
                    $(this).addClass("is-invalid");
                    $(this).parent().find('p').remove();
                    $(this).parent().append(`
                        <p class="invalid-feedback d-flex justify-content-start" role="alert">
                            Այս դաշտը չպետք է պարունակի անօրինական նիշեր կամ թվեր
                        </p>
                    `);
                    return
                }
                $(this).removeClass("is-invalid");
                $(this).parent().find('p').remove();
            });
            $("#expected_salary").on("keyup keypress change", function () {
                var str = $(this).val().includes("-");
                if ($(this).val().length > 0 && $(this).val() < 0) {
                    $(this).addClass("is-invalid");
                    $(this).parent().find('p').remove();
                    $(this).parent().append(`
                        <p class="invalid-feedback d-flex justify-content-end" role="alert">
                            Այս դաշտը վավեր չէ
                        </p>
                    `);
                    return
                }
                $(this).removeClass("is-invalid");
                $(this).parent().find('p').remove();
            });
            $("#phone_numbers").on("keyup change", function () {
                if ($(this).val().length === 0) {
                    $(this).addClass("is-invalid");
                    $(this).parent().find('p').remove();
                    $(this).parent().append(`
                        <p class="invalid-feedback d-flex justify-content-start mb-0" role="alert">
                            Այս դաշտը պարտադիր է
                        </p>
                    `);
                    return
                }
                if ($(this).val().length > 20) {
                    $(this).val($(this).val().slice(0, 20 - $(this).val().length));
                    return
                }
                if (!/^[0-9]+$/.test($(this).val())) {
                    $(this).addClass("is-invalid");
                    $(this).parent().find('p').remove();
                    $(this).parent().append(`
                        <p class="invalid-feedback d-flex justify-content-start mb-0" role="alert">
                            Այս դաշտը պետք է պարունակի միայն թվեր
                        </p>
                    `);
                    return
                }
                if ($(this).hasClass("is-invalid")) {
                    $(this).removeClass("is-invalid");
                    $(this).parent().find('p').remove();
                }

            });
            $("#phone-list").on('change', ".phone_code_select", function (e) {
                var $id = e.target.value;
                var bla = $(this).parent().parent().find(".col-md-2").find("input");
                var $this = $(this);
                // $(this).closest("input").val(code);
                $.ajax({
                    url: "/changePhoneCode/",
                    type: 'GET',
                    success: function (data) {
                        let code = "+" + data[$id - 1].phonecode;
                        bla.val(code);
                        $this.attr('data-phonecode', code);
                    }
                });
            });
            $(".addPhoneNumber").on('click', function () {
                var rowCount = $('#list .list-item').length;
                if (rowCount < 0) {
                    rowCount = 0;
                }
                $("#list").append(
                    `
                    <div class="row  list-item">
                        <div class="col-sm-3">
                        <select class="form-select phone_code_select" name="phones[${rowCount}][code]" id="phone_code_select-${rowCount}" style="border-color: #ced4da;" data-phonecode="+374">
                            @foreach($countries as $country)
                        <option value="{{ $country->id }}" @if($country->nicename == "Armenia") selected @endif>  +{{ $country->phonecode}} {{$country->nicename }}</option>
                            @endforeach
                        </select>
                        </div>
                        <div class="col-sm-9">
                        <div class="row no-gutters mb-3">
                            <div class="col" style="height: 35px;">
                                <input style="width: 100%;" type="number" min="0" name="phones[${rowCount}][phone]"  id="phone_numbers" data-ajax-input="phones.${rowCount}.phone_number" value="{{ old('phone_numbers') }}" class="phone_numbers form-control border-right-0 rounded-0 {{ $errors->has('phone_numbers') ? ' is-invalid' : '' }}">
                            </div>
                            <div class="col-auto" style="height: 37.05px;">
                                <button class="deleteNumber btn form-control border-left-0 rounded-0  rounded-right" type="button" style="border-color: #ced4da">
                                    <i class="fa fa-close"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
`
                );

                // new TomSelect(`#phone_code_select-${rowCount}`,{
                //     create: false,
                // });
            });
            $("#list").on('click', ".deleteNumber", function () {
                $(this).closest(".list-item").remove();
            });
            $(".addLinks").click(function () {
                var rowCount = $('#socialSites .row').length;
                if (rowCount < 0) {
                    rowCount = 0;
                }
                $("#socialSites").append(
                    `
                    <div class="row no-gutters mb-3">
                        <div class="col" style="height: 36px;">
                            <input type="text" name="social_sites[${rowCount}]" data-ajax-input="social_sites.${rowCount}" value="{{ old('social_sites') }}" class="social_sites border-right-0 rounded-0 form-control {{ $errors->has('social_sites') ? ' is-invalid' : '' }}" style="margin-bottom: 10px; height: 100%;">
                        </div>
                        <div class="col-auto" >
                            <button class="deleteLink btn form-control border-left-0 rounded-0  rounded-right" type="button" style="border-color: #ced4da; height: 36px">
                                <i class="fa fa-close"></i>
                            </button>
                        </div>
                        </div>
`
                );
            });
            $("#socialSites").on('click', '.deleteLink', function () {
                $(this).closest('.row').remove();
            });
            var fileList = [];
            $("#customFiles").on("change click", function () {
                // debugger;
                fileList = [];
                for (var i = 0; i < $(this)[0].files.length; i++) {
                    fileList.push($(this)[0].files[i]);
                }
                if (fileList.length === 0) {
                    $("#customFiles").addClass('is-invalid');
                    $("#customFiles").parent().find("p").remove();
                    $("#customFiles").parent().append(
                        `
                               <p class="invalid-feedback d-flex justify-content-start" role="alert">
                                Այս դաշտը պարտադիր է
                                </p>
                            `
                    );
                    return
                }
                $.each(fileList, function (index, item) {
                    let name = item.name;
                    var ext = name.split('.').pop();
                    if (ext === "pdf" || ext === "docx") {
                        $("#customFiles").removeClass("is-invalid");
                        $("#customFiles").parent().find("p").remove();
                    } else {
                        $("#customFiles").addClass('is-invalid');
                        $("#customFiles").parent().find("p").remove();
                        $("#customFiles").parent().append(
                            `
                               <p class="invalid-feedback d-flex justify-content-start" role="alert">
                                Այս դաշտը պետք է պարունակի միայն pdf, docx տիպերի ֆայլեր
                                </p>
                            `
                        );
                        return false;
                    }
                });
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.addMoreEducation').click(function () {
                var rowCount = $('#educationForm tr').length - 1;
                if (rowCount < 0) {
                    rowCount = 0;
                }
                $('#educationForm tbody').append(
                    `
                <tr style="overflow: visible">
                        <td style="width: 50%;">
                            <select class="form-select education_name w-100" data-ajax-input="faculties.${rowCount}" id="js-education-${rowCount}">
                                <option id="0"></option>
                                @foreach($institute as $ins)

                        <option id="{{ $ins->id }}" value="{{ $ins->id }}">{{ $ins->institute_name }}</option>

                                @endforeach
                        </select>
                    </td>
                    <td style="width: 50%;">

                        <select name="ed[${rowCount}][faculty]" class="faculty form-select faculty_name" id="js-faculty"></select>
                    </td>
                    <td>
                            <button class="btn removeEducationCV" type="button" style="color: red; font-size: 20px" onmouseover="this.style.color='#D70000';" onmouseout="this.style.color='red';"><i class="fa-solid fa-circle-xmark"></i></button>
                    </td>
                </tr>`
                );
                var uni = `#js-education-${rowCount}`;
                // new TomSelect(uni,{
                //     create: false,
                // });
            });
            $(document).on('change', '.education_name', function (e) {
                var $val_id = e.target[e.target.selectedIndex].id;
                if ($val_id == 0) {
                    $(e.target).parent().next('td').find('.faculty_name:first').empty();
                    $(e.target).parent().next('td').find('.faculty_name:first').append(`<option></option>`);
                    $(this).addClass('is-invalid');
                    $(this).parent().find("p").remove();
                    $(this).parent().append(`
                        <p class="invalid-feedback d-flex justify-content-start mb-0" role="alert">Համալսարան ընտրված չէ</p>
                    `
                    );
                } else {
                    var $id = e.target.value;
                    $(this).parent().find("p").remove();
                    $(this).removeClass('is-invalid');
                    $.ajax({
                        url: "/addEducationForEmp/" + $id,
                        type: 'GET',
                        success: function (data) {
                            $(e.target).parent().next('td').find('.faculty_name:first').empty();
                            Object.keys(data).forEach((row) => {
                                $(e.target).parent().next('td').find('.faculty_name:first').append(`<option value="${data[row].id}"> ${data[row].faculty_name} </option>`);
                            });
                        }
                    });
                }

            });
            $("#educationForm").on('click', '.removeEducationCV', function () {
                $(this).closest('tr').remove();
            });
            $('.addMoreExperience').click(function () {
                var rowCount = $('#experienceForm tr').length - 1;
                if (rowCount < 0) {
                    rowCount = 0;
                }
                $('#experienceForm tbody').append(
                    `
            <tr class="exp-list">
                 <td>
                    <div class="form-group">
                        <input class="exp_name_company  form-control" type="text" name="exp[${rowCount}][name_company]" data-ajax-input="exp.${rowCount}.name_company" value="{{ old('exp[${rowCount}][name_company]') }}">
                    </div>
                 </td>
                 <td>
                     <div class="form-group">
                        <input class="exp_work_start date form-control" type="text" name="exp[${rowCount}][work_start]" data-ajax-input="exp.${rowCount}.work_start" placeholder="__/__/____" autocomplete="off" value="{{ old('exp[${rowCount}][work_start]') }}">
                     </div>
                 </td>
                 <td>
                     <div class="form-group">
                        <input class="exp_work_end date form-control" type="text" name="exp[${rowCount}][work_end]" data-ajax-input="exp.${rowCount}.work_end" placeholder="__/__/____" autocomplete="off" value="{{ old('exp[${rowCount}][work_end]') }}">
                     </div>
                 </td>
                 <td>
                    <div class="form-group">
                        <input class="exp_salary form-control" type="number" min="20000" step="100" name="exp[${rowCount}][salary]" data-ajax-input="exp.${rowCount}.salary" value="{{ old('exp[${rowCount}][salary]') }}">
                    </div>
                 </td>
                  <td>
                      <button class="btn removeExperience" type="button" style="color: red; font-size: 20px;" onmouseover="this.style.color='#D70000';" onmouseout="this.style.color='red';"><i class="fa-solid fa-circle-xmark"></i></button>
                  </td>
            </tr>
        `
                );
                $('.date').datepicker({
                    dateFormat: 'dd-mm-yy',
                    firstDay: 1,
                    closeText: 'Փակել',
                    prevText: 'Նախորդ',
                    nextText: 'Հաջորդ',
                    currentText: 'Այսօր',
                    monthNames: ['Հունվար', 'Փետրվար', 'Մարտ', 'Ապրիլ', 'Մայիս', 'Հունիս', 'Հուլիս', 'Օգոստոս', 'Սեպտեմբեր', 'Հոկտեմբեր', 'Նոյեմբեր', 'Դեկտեմբեր'],
                    monthNamesShort: ['Հունվ', 'Փետր', 'Մարտ', 'Ապր', 'Մայիս', 'Հունիս', 'Հուլ', 'Օգս', 'Սեպ', 'Հոկ', 'Նոյ', 'Դեկ'],
                    dayNames: ['կիրակի', 'եկուշաբթի', 'երեքշաբթի', 'չորեքշաբթի', 'հինգշաբթի', 'ուրբաթ', 'շաբաթ'],
                    dayNamesShort: ['կիր', 'երկ', 'երք', 'չրք', 'հնգ', 'ուրբ', 'շբթ'],
                    dayNamesMin: ['կիր', 'երկ', 'երք', 'չրք', 'հնգ', 'ուրբ', 'շբթ'],
                    weekHeader: 'ՇԲՏ',
                    isRTL: false,
                    showMonthAfterYear: false,
                    yearSuffix: ''
                });
                $('.date').inputmask({"mask": "99/99/9999"});
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $("#experienceForm tbody tr:last-child").find(".exp_name_company").on("change keyup", function () {
                    if ($(this).val().length === 0) {
                        $(this).addClass("is-invalid");
                        $(this).parent().find("p").remove();
                        $(this).parent().append(
                            `
                                <p class="invalid-feedback d-flex justify-content-start" role="alert">Այս դաշտը պարտադիր է</p>
                            `
                        );
                        return
                    }
                    $(this).removeClass("is-invalid");
                    $(this).parent().find("p").remove();
                });
                $("#experienceForm tbody tr:last-child").find(".exp_work_start").on("change keyup", function () {
                    if ($(this).val().length === 0) {
                        $(this).addClass("is-invalid");
                        $(this).parent().find("p").remove();
                        $(this).parent().append(
                            `
                                <p class="invalid-feedback d-flex justify-content-start" role="alert">Այս դաշտը պարտադիր է</p>
                            `
                        );
                        return
                    }
                    if (!date_validation($(this), 50, 0)) {
                        return
                    }
                    var $exp_work_end = $(this).parent().parent().next("td").find(".exp_work_end");
                    if ($exp_work_end.val().length !== 0) {
                        var $exp_work_end_arr = $(this).parent().parent().next("td").find(".exp_work_end").val().split('/');
                        var $exp_work_start_arr = $(this).val().split('/');
                        if ($exp_work_start_arr[2] > $exp_work_end_arr[2]) {
                            $(this).addClass("is-invalid");
                            $(this).parent().find('p').remove();
                            $(this).parent().append(`
                                <p class="invalid-feedback d-flex justify-content-end" role="alert">
                                    Այս ամսաթիվը պետք է լինի աշխատանքի ավարտի ամսաթվից առաջ
                                </p>
                            `);
                            $exp_work_end.addClass("is-invalid");
                            $exp_work_end.parent().find('p').remove();
                            $exp_work_end.parent().append(`
                                <p class="invalid-feedback d-flex justify-content-end" role="alert">
                                    Այս ամսաթիվը պետք է լինի աշխատանքի սկզբի ամսաթվից հետո
                                </p>
                            `);
                            return
                        }
                        if ($exp_work_start_arr[2] === $exp_work_end_arr[2] && $exp_work_start_arr[1] > $exp_work_end_arr[1]) {
                            $(this).addClass("is-invalid");
                            $(this).parent().find('p').remove();
                            $(this).parent().append(`
                                <p class="invalid-feedback d-flex justify-content-end" role="alert">
                                    Այս ամսաթիվը պետք է լինի աշխատանքի ավարտի ամսաթվից առաջ
                                </p>
                            `);
                            $exp_work_end.addClass("is-invalid");
                            $exp_work_end.parent().find('p').remove();
                            $exp_work_end.parent().append(`
                                <p class="invalid-feedback d-flex justify-content-end" role="alert">
                                    Այս ամսաթիվը պետք է լինի աշխատանքի սկզբի ամսաթվից հետո
                                </p>
                            `);
                            return
                        }

                        if ($exp_work_start_arr[2] === $exp_work_end_arr[2] && $exp_work_start_arr[1] === $exp_work_end_arr[1] && $exp_work_start_arr[0] > $exp_work_end_arr[0]) {
                            $(this).addClass("is-invalid");
                            $(this).parent().find('p').remove();
                            $(this).parent().append(`
                                <p class="invalid-feedback d-flex justify-content-end" role="alert">
                                    Այս ամսաթիվը պետք է լինի աշխատանքի ավարտի ամսաթվից առաջ
                                </p>
                            `);
                            $exp_work_end.addClass("is-invalid");
                            $exp_work_end.parent().find('p').remove();
                            $exp_work_end.parent().append(`
                                <p class="invalid-feedback d-flex justify-content-end" role="alert">
                                    Այս ամսաթիվը պետք է լինի աշխատանքի սկզբի ամսաթվից հետո
                                </p>
                            `);
                            return
                        }
                    }
                    $(this).removeClass("is-invalid");
                    $(this).parent().find("p").remove();
                    $exp_work_end.removeClass("is-invalid");
                    $exp_work_end.parent().find('p').remove();
                });
                $("#experienceForm tbody tr:last-child").find(".exp_work_end").on("change keyup", function () {
                    if ($(this).val().length === 0) {
                        $(this).addClass("is-invalid");
                        $(this).parent().find("p").remove();
                        $(this).parent().append(
                            `
                                <p class="invalid-feedback d-flex justify-content-start" role="alert">Այս դաշտը պարտադիր է</p>
                            `
                        );
                        return
                    }
                    if (!date_validation($(this), 50, 0)) {
                        return
                    }
                    var $exp_work_start = $(this).parent().parent().prev("td").find(".exp_work_start");
                    if ($exp_work_start.val().length > 0) {
                        var $exp_work_start_arr = $(this).parent().parent().prev("td").find(".exp_work_start").val().split('/');
                        var $exp_work_end_arr = $(this).val().split('/');
                        if ($exp_work_start_arr[2] > $exp_work_end_arr[2]) {
                            $exp_work_start.addClass("is-invalid");
                            $exp_work_start.parent().find('p').remove();
                            $exp_work_start.parent().append(`
                                <p class="invalid-feedback d-flex justify-content-end" role="alert">
                                    Այս ամսաթիվը պետք է լինի աշխատանքի ավարտի ամսաթվից առաջ
                                </p>
                            `);
                            $(this).addClass("is-invalid");
                            $(this).parent().find('p').remove();
                            $(this).parent().append(`
                                <p class="invalid-feedback d-flex justify-content-end" role="alert">
                                    Այս ամսաթիվը պետք է լինի աշխատանքի սկզբի ամսաթվից հետո
                                </p>
                            `);
                            return
                        }
                        if ($exp_work_start_arr[2] === $exp_work_end_arr[2] && $exp_work_start_arr[1] > $exp_work_end_arr[1]) {
                            $exp_work_start.addClass("is-invalid");
                            $exp_work_start.parent().find('p').remove();
                            $exp_work_start.parent().append(`
                                <p class="invalid-feedback d-flex justify-content-end" role="alert">
                                    Այս ամսաթիվը պետք է լինի աշխատանքի ավարտի ամսաթվից առաջ
                                </p>
                            `);
                            $(this).addClass("is-invalid");
                            $(this).parent().find('p').remove();
                            $(this).parent().append(`
                                <p class="invalid-feedback d-flex justify-content-end" role="alert">
                                    Այս ամսաթիվը պետք է լինի աշխատանքի սկզբի ամսաթվից հետո
                                </p>
                            `);
                            return
                        }

                        if ($exp_work_start_arr[2] === $exp_work_end_arr[2] && $exp_work_start_arr[1] === $exp_work_end_arr[1] && $exp_work_start_arr[0] > $exp_work_end_arr[0]) {
                            $exp_work_start.addClass("is-invalid");
                            $exp_work_start.parent().find('p').remove();
                            $exp_work_start.parent().append(`
                                <p class="invalid-feedback d-flex justify-content-end" role="alert">
                                    Այս ամսաթիվը պետք է լինի աշխատանքի ավարտի ամսաթվից առաջ
                                </p>
                            `);
                            $(this).addClass("is-invalid");
                            $(this).parent().find('p').remove();
                            $(this).parent().append(`
                                <p class="invalid-feedback d-flex justify-content-end" role="alert">
                                    Այս ամսաթիվը պետք է լինի աշխատանքի սկզբի ամսաթվից հետո
                                </p>
                            `);
                            return
                        }
                    }
                    $(this).removeClass("is-invalid");
                    $(this).parent().find("p").remove();
                    $exp_work_start.removeClass("is-invalid");
                    $exp_work_start.parent().find("p").remove();
                });
                $("#experienceForm tbody tr:last-child").find(".exp_salary").on("change keyup", function () {
                    if ($(this).val().length === 0) {
                        $(this).addClass("is-invalid");
                        $(this).parent().find("p").remove();
                        $(this).parent().append(
                            `
                                <p class="invalid-feedback d-flex justify-content-start" role="alert">Այս դաշտը պարտադիր է</p>
                            `
                        );
                        return
                    }
                    $(this).removeClass("is-invalid");
                    $(this).parent().find("p").remove();
                });
            });
            $("#experienceForm").on('click', '.removeExperience', function () {
                $(this).closest('tr').remove();
            });
            $(".submit :submit").click(function (e) {
                e.preventDefault();
                var formData = new FormData();
                formData.append('application_date', $("#application_date").val());
                formData.append('date_interview', $("#date_interview").val());
                formData.append('name_surname', $("#name_surname").val());
                formData.append('birth_date', $("#birth_date").val());
                formData.append('proffession', $("#proffession").val());
                formData.append('expected_salary', $("#expected_salary").val());
                formData.append('comments', $("#comments").val());
                var listPhones = $(".list-item");
                var phones_arr = [];
                listPhones.each(function (i) {
                    let phonecode = $(this).find("select").attr('data-phonecode');
                    let phone_number = $(this).find(".phone_numbers").val();
                    let phone = '' + phonecode + phone_number;
                    formData.append(`phones[${i}][country_id]`, $(this).find("select").val());
                    formData.append(`phones[${i}][phone_code]`, phonecode);
                    formData.append(`phones[${i}][phone_number]`, phone_number);
                });
                var $social_sites = $(".social_sites");
                for (let i = 0; i < $social_sites.length; i++) {
                    formData.append('social_sites[]', $social_sites[i].value);
                }
                var $faculties = $(".faculty");
                for (let i = 0; i < $faculties.length; i++) {
                    formData.append('faculties[]', $faculties[i].value);
                }
                var exp_arr = $(".exp-list");
                exp_arr.each(function (i) {
                    var $name_company = $(this).find(".exp_name_company").val();
                    var $work_start = $(this).find(".exp_work_start").val();
                    var $work_end = $(this).find(".exp_work_end").val();
                    var $salary = $(this).find(".exp_salary").val();
                    formData.append(`exp[${i}][name_company]`, $name_company);
                    formData.append(`exp[${i}][work_start]`, $work_start);
                    formData.append(`exp[${i}][work_end]`, $work_end);
                    formData.append(`exp[${i}][salary]`, $salary);
                });
                for (let i = 0; i < fileList.length; i++) {
                    formData.append('files[]', fileList[i]);
                }

                $.ajax({
                    url: "{{ route('add_cv') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    error: function (data) {
                        console.log("error", data);
                    },
                    success: function (response) {
                        console.log(response);
                        if ($.isEmptyObject(response.error)) {
                            $(".alert").remove();
                            $("form").prepend(`
                                <div class="alert alert-success">Ռեզյումեն ստեղծված է</div>
                            `);
                            window.location = '{{ route("dashboard") }}';
                        } else {
                            $(".alert").remove();
                            $.each(response.error, function (key, value) {
                                if (key === "application_date" || key === "date_interview" || key === "birth_date") {
                                    $('[data-ajax-input="' + key + '"]').addClass('is-invalid');
                                    $('[data-ajax-input="' + key + '"]').parent().find('p').remove();
                                    $('[data-ajax-input="' + key + '"]').parent().append(`
                                        <p class="invalid-feedback d-flex justify-content-end" role="alert">
                                            ${value[0]}
                                        </p>
                                    `);
                                    return true;
                                }
                                if (key.startsWith("phones")) {
                                    $('[data-ajax-input="' + key + '"]').addClass('is-invalid');
                                    $('[data-ajax-input="' + key + '"]').parent().parent().find('p').remove();
                                    $('[data-ajax-input="' + key + '"]').parent().parent().append(`
                                        <p class="invalid-feedback d-flex justify-content-start mb-0 px-2" role="alert">
                                            ${value[0]}
                                        </p>
                                    `);
                                    $('[data-ajax-input="' + key + '"]').parent().next('div').find('.deleteNumber').css('border-color', '#d43b3b');
                                    return true;
                                }

                                if (key.startsWith("social_sites")) {
                                    $('[data-ajax-input="' + key + '"]').addClass('is-invalid');
                                    $('[data-ajax-input="' + key + '"]').parent().parent().find('p').remove();
                                    $('[data-ajax-input="' + key + '"]').parent().parent().append(`
                                        <p class="invalid-feedback d-flex justify-content-start mb-0 px-2" role="alert">
                                            ${value[0]}
                                        </p>
                                    `);
                                    $('[data-ajax-input="' + key + '"]').parent().next('div').find('.deleteLink').css('border-color', '#d43b3b');
                                    return true;
                                }


                                $('[data-ajax-input="' + key + '"]').addClass('is-invalid');
                                $('[data-ajax-input="' + key + '"]').parent().find('p').remove();
                                $('[data-ajax-input="' + key + '"]').parent().append(`
                                    <p class="invalid-feedback d-flex justify-content-start mb-0" role="alert">
                                        ${value[0]}
                                    </p>
                                `);
                            });
                            $(window).scrollTop(0);
                        }


                    }
                });
            });


        })
    </script>

@endpush
