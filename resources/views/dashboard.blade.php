@extends('layouts.admin')
{{--@section('title') Վահանակ @endsection--}}
@section('content')
    @if(\Illuminate\Support\Facades\Session::has('create'))
        <div class="alert alert-success text-center">{{ \Illuminate\Support\Facades\Session::get('create') }}</div>
    @endif
    <h1 class="text-center mb-5">Ռեզյումեների ցուցակ</h1>
    <form action="{{ route('search') }}" method="GET">
        @csrf
        <div class="d-flex gap-3 flex-wrap">
            <div>
                <div class="input-group mb-3 float-right searchInput">
                    <div class="input-group-append  ">
                        <div class="d-flex flex-column">
                            <label for="">Որոնում ըստ անուն ազգանունի</label>
                            <div class="input-group-append ">
                                <input  type="text" class="searchInput form-control" aria-describedby="basic-addon2"
                                        value="{{((\Illuminate\Support\Facades\Session::get('searchName')) ? \Illuminate\Support\Facades\Session::get('searchName') : '')}}" name="searchName">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="input-group mb-3 float-right searchInput">
                    <div class="input-group-append  ">
                        <div class="d-flex flex-column">
                            <label for="">Որոնում ըստ մասնագիտության</label>
                            <div class="input-group-append ">
                                <input  type="text" class="searchInput form-control" aria-describedby="basic-addon2"
                                        value="{{((\Illuminate\Support\Facades\Session::get('searchProffession')) ? \Illuminate\Support\Facades\Session::get('searchProffession') : '')}}" name="searchProffession">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="input-group mb-3 float-right searchInput">
                    <div class="input-group-append  ">
                        <div class="d-flex flex-column">
                            <label for="">Որոնում ըստ կրթության</label>
                            <div class="input-group-append ">
                                <input  type="text" class="searchInput form-control" aria-describedby="basic-addon2"
                                        value="{{((\Illuminate\Support\Facades\Session::get('searchEducation')) ? \Illuminate\Support\Facades\Session::get('searchEducation') : '')}}" name="searchEducation">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="input-group mb-3 float-right searchInput">
                    <div class="input-group-append">
                        <div class="d-flex flex-column">
                            <label for="">Որոնում ըստ հեռախոսահամարի</label>
                            <div class="input-group-append ">
                                <input  type="number" class="searchInput form-control" aria-describedby="basic-addon2"
                                        value="{{((\Illuminate\Support\Facades\Session::get('searchPhone')) ? \Illuminate\Support\Facades\Session::get('searchPhone') : '')}}" name="searchPhone">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="input-group mb-3 float-right searchInput">
                    <div class="input-group-append">
                        <div class="d-flex flex-column">
                            <label for="">Որոնում ըստ աշխատանքային փորձի</label>
                            <div class="input-group-append ">
                                <input  type="text" class="searchInput form-control" aria-describedby="basic-addon2"
                                        value="{{((\Illuminate\Support\Facades\Session::get('searchExperience')) ? \Illuminate\Support\Facades\Session::get('searchExperience') : '')}}" name="searchExperience">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <label for="">Որոնում ըստ ծննդյան ամսաթվի</label>
                <section class="range-slider">
                    <span class="rangeValues mb-3"></span><span>  թթ․</span>
                    <input class="searchInput" style="margin-top: 10px;" name="searchBirthStart" id="searchBirthStart" value="{{((\Illuminate\Support\Facades\Session::get('searchBirthStart')) ? \Illuminate\Support\Facades\Session::get('searchBirthStart') : now()->year - 50 )}}" min="{{ now()->year - 50 }}" max="{{ now()->year - 16 }}"    step="1" type="range">
                    <input class="searchInput" style="margin-top: 10px;" name="searchBirthEnd" id="searchBirthEnd" value="{{((\Illuminate\Support\Facades\Session::get('searchBirthEnd')) ? \Illuminate\Support\Facades\Session::get('searchBirthEnd') : now()->year - 16)}}" min="{{ now()->year - 50 }}" max="{{ now()->year - 16 }}"  step="1" type="range">
                </section>
            </div>
            <div>
                <label for="">Որոնում ըստ դիմելու ամսաթվի</label>
                <section class="range-slider">
                    <span class="rangeValues mb-3"></span><span>  թթ․</span>
                    <input class="searchInput" style="margin-top: 10px;" name="searchApplicationStart" id="searchApplicationStart" value="{{((\Illuminate\Support\Facades\Session::get('searchApplicationStart')) ? \Illuminate\Support\Facades\Session::get('searchApplicationStart') : now()->year - 50 )}}" min="{{ now()->year - 50 }}" max="{{ now()->year}}"    step="1" type="range">
                    <input class="searchInput" style="margin-top: 10px;" name="searchApplicationEnd" id="searchApplicationEnd" value="{{((\Illuminate\Support\Facades\Session::get('searchApplicationEnd')) ? \Illuminate\Support\Facades\Session::get('searchApplicationEnd') : now()->year)}}" min="{{ now()->year - 50 }}" max="{{ now()->year}}"  step="1" type="range">
                </section>
            </div>
            <div>
                <label for="">Որոնում ըստ հարցազրույցի ամսաթվի</label>
                <section class="range-slider">
                    <span class="rangeValues mb-3"></span><span>  թթ․</span>
                    <input class="searchInput" style="margin-top: 10px;" name="searchDateInterviewStart" id="searchDateInterviewStart" value="{{((\Illuminate\Support\Facades\Session::get('searchDateInterviewStart')) ? \Illuminate\Support\Facades\Session::get('searchDateInterviewStart') : now()->year - 50 )}}" min="{{ now()->year - 50 }}" max="{{ now()->year}}"    step="1" type="range">
                    <input class="searchInput" style="margin-top: 10px;" name="searchDateInterviewEnd" id="searchDateInterviewEnd" value="{{((\Illuminate\Support\Facades\Session::get('searchDateInterviewEnd')) ? \Illuminate\Support\Facades\Session::get('searchDateInterviewEnd') : now()->year)}}" min="{{ now()->year - 50 }}" max="{{ now()->year}}"  step="1" type="range">
                </section>
            </div>

        </div>
        <div class="checkboxes px-4 mt-4 d-flex gap-5 flex-wrap">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="filter_application_date" id="application_date" @if(\Illuminate\Support\Facades\Session::get('filter_application_date')) checked @endif>
                <label class="form-check-label" for="application_date">Դիմելու ամսաթիվ</label>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="filter_date_interview" id="date_interview" @if(\Illuminate\Support\Facades\Session::get('filter_date_interview')) checked @endif>
                <label class="form-check-label" for="date_interview">Հարցազրույցի ամսաթիվ</label>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="filter_phone" id="phone" @if(\Illuminate\Support\Facades\Session::get('filter_phone')) checked @endif>
                <label class="form-check-label"  for="phone">Հեռախոսահամարներ</label>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="filter_birth_date" id="birth_date" @if(\Illuminate\Support\Facades\Session::get('filter_birth_date')) checked @endif>
                <label class="form-check-label"  for="birth_date">Ծննդյան ամսաթիվ</label>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="filter_expected_salary" id="expected_salary" @if(\Illuminate\Support\Facades\Session::get('filter_expected_salary')) checked @endif>
                <label class="form-check-label" for="expected_salary">Ակնկալվող աշխատավարձ</label>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="filter_proffession"  id="proffession" @if(\Illuminate\Support\Facades\Session::get('filter_proffession') ) checked @endif>
                <label class="form-check-label" for="proffession">Մասնագիտություն</label>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="filter_education" id="education" @if(\Illuminate\Support\Facades\Session::get('filter_education')) checked @endif>
                <label class="form-check-label"  for="education">Կրթություն</label>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="filter_experience" id="experience" @if(\Illuminate\Support\Facades\Session::get('filter_experience')) checked @endif>
                <label class="form-check-label"  for="experience">Աշխատանքային փորձ</label>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="filter_social_sites" id="social_sites" @if(\Illuminate\Support\Facades\Session::get('filter_social_sites') ) checked @endif>
                <label class="form-check-label" for="social_sites">Սոցիալական կայքեր</label>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="filter_files" id="files" @if(\Illuminate\Support\Facades\Session::get('filter_files')) checked @endif>
                <label class="form-check-label"  for="files">ֆայլեր</label>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="filter_comments" id="comments" @if(\Illuminate\Support\Facades\Session::get('filter_comments')) checked @endif>
                <label class="form-check-label"  for="comments">Մեկնաբանություններ</label>
            </div>
        </div>
        <input type="submit" name="submit_btn" class="btn btn-secondary " value="Կիրառել ֆիլտրերը" style="max-width: 200px; margin-top: 10px;">
    </form>

    <div class="table-responsive mb-3">
        @if($employers_count)
            @if(count($employers))
                <table class="styled-table" style="border-top-left-radius: 15px; border-top-right-radius: 15px;overflow: hidden; width: 100%;">
                    <thead>
                    <tr>
                        <th scope="col"># <i class="fa-solid fa-up-down arrow" data-row-name="id" data-sort="0"></i></th>
                        <th scope="col">Անուն Ազգանուն</th>
                        @if(\Illuminate\Support\Facades\Session::get('filter_application_date'))
                            <th scope="col" style="position: relative">Դիմելու ամսաթիվ <i class="fa-solid fa-up-down arrow" data-row-name="application_date" data-sort="0"></i></th>
                        @endif
                        @if(\Illuminate\Support\Facades\Session::get('filter_date_interview'))
                            <th scope="col" style="position: relative">Հարցազրույցի ամսաթիվ <i class="fa-solid fa-up-down arrow" data-row-name="date_interview" data-sort="0"></i></th>
                        @endif
                        @if(\Illuminate\Support\Facades\Session::get('filter_phone'))
                            <th scope="col">Հեռախոսահամարներ</th>
                        @endif
                        @if(\Illuminate\Support\Facades\Session::get('filter_birth_date'))
                            <th scope="col" style="position: relative">Ծննդյան ամսաթիվ <i class="fa-solid fa-up-down arrow" data-row-name="birth_date" data-sort="0"></i></th>
                        @endif
                        @if(\Illuminate\Support\Facades\Session::get('filter_expected_salary'))
                            <th scope="col" style="position: relative">Ակնկալվող աշխատավարձ <i class="fa-solid fa-up-down arrow" data-row-name="expected_salary" data-sort="0"></i></th>
                        @endif
                        @if(\Illuminate\Support\Facades\Session::get('filter_proffession'))
                            <th scope="col">Մասնագիտություն</th>
                        @endif
                        @if(\Illuminate\Support\Facades\Session::get('filter_education'))
                            <th scope="col">Կրթություն</th>
                        @endif
                        @if(\Illuminate\Support\Facades\Session::get('filter_experience'))
                            <th scope="col">Աշխատանքային փորձ</th>
                        @endif
                        @if(\Illuminate\Support\Facades\Session::get('filter_social_sites'))
                            <th scope="col">Սոցիալական կայքեր</th>
                        @endif
                        @if(\Illuminate\Support\Facades\Session::get('filter_files'))
                            <th scope="col">ֆայլեր</th>
                        @endif
                        @if(\Illuminate\Support\Facades\Session::get('filter_comments'))
                            <th scope="col">Մեկնաբանություններ</th>
                        @endif
                        <th scope="col">Գործողություններ</th>
                    </tr>
                    </thead>
                    <tbody>
                        @include('layouts.dashboard_data')
                    </tbody>
                </table>
            @else
                <p class="mt-4">Ինֆորմացիա չի գտնվել</p>
            @endif
        @else
            <p class="mt-4">Դեռ ռեզյումեներ չկան</p>
        @endif
    </div>



    <input type="hidden" name="hidden_page" id="hidden_page" value="1">
<input type="hidden" name="hidden_column_name" id="hidden_column_name" value="id">
<input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="ASC">
@endsection

@push('style')
    <style>
        .arrow {
            position: absolute;
            right: 0;
            bottom: 10px;
            cursor: pointer;
        }
        section.range-slider {
            position: relative;
            width: 200px;
            height: 35px;
            text-align: center;
        }

        section.range-slider input {
            pointer-events: none;
            position: absolute;
            overflow: hidden;
            left: 0;
            top: 15px;
            width: 200px;
            outline: none;
            height: 18px;
            margin: 0;
            padding: 0;
        }

        section.range-slider input::-webkit-slider-thumb {
            pointer-events: all;
            position: relative;
            z-index: 1;
            outline: 0;
        }

        section.range-slider input::-moz-range-thumb {
            pointer-events: all;
            position: relative;
            z-index: 10;
            -moz-appearance: none;
            width: 9px;
        }
    </style>
@endpush

@push('script')
    <script>
        function getVals(){
            // Get slider values
            var parent = this.parentNode;
            var slides = parent.getElementsByTagName("input");
            var slide1 = slides[0].value;
            var slide2 = slides[1].value;
            // Neither slider will clip the other, so make sure we determine which is larger
            if( slide1 > slide2 ){ var tmp = slide2; slide2 = slide1; slide1 = tmp; }

            var displayElement = parent.getElementsByClassName("rangeValues")[0];
            displayElement.innerHTML = slide1 + " - " + slide2;
        }

        window.onload = function(){
            // Initialize Sliders
            var sliderSections = document.getElementsByClassName("range-slider");
            for( var x = 0; x < sliderSections.length; x++ ){
                var sliders = sliderSections[x].getElementsByTagName("input");
                for( var y = 0; y < sliders.length; y++ ){
                    if( sliders[y].type ==="range" ){
                        sliders[y].oninput = getVals;
                        // Manually trigger event first time to display values
                        sliders[y].oninput();
                    }
                }
            }
        }
    </script>
@endpush
@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js" integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            function fetch_data(page,sort_type,sort_by)
            {
                $.ajax({
                    type: "GET",
                    url: "/dashboard/filter/sort?page="+page+"&sortby="+sort_by+"&sorttype="+sort_type,
                    success: function (response) {
                        $("tbody").empty().html(response);
                        window.scrollTo(0, document.querySelector("body").scrollHeight);
                    },
                    error: function (response) {
                        console.log(response);
                    }
                });
            }
            $(".arrow").parent().css("position", 'relative');
            $("body").on('click','.arrow', function () {
                    var arrow = $(this);
                    var arrowClass = $(this).attr('class');
                    $(".arrow").each(function () {
                        if($(this).attr('data-row-name') !== arrow.attr('data-row-name')) {
                            if($(this).hasClass('fa-up-long')) {
                                $(this).removeClass('fa-up-long');
                            }
                            if($(this).hasClass('fa-down-long')) {
                                $(this).removeClass('fa-down-long');
                            }
                            $(this).removeClass('fa-up-down');
                            $(this).addClass('fa-up-down');
                            $(this).attr('data-sort','0');
                        }
                    });
                    if(arrowClass.indexOf("fa-up-down") >= 0) {
                        arrow.removeClass('fa-up-down');
                        arrow.addClass('fa-up-long');
                        arrow.attr('data-sort','ASC');
                    }
                    else if(arrowClass.indexOf("fa-up-long") >= 0) {
                        arrow.removeClass('fa-up-long');
                        arrow.addClass('fa-down-long');
                        arrow.attr('data-sort','DESC');
                    }
                    else if(arrowClass.indexOf("fa-down-long") >= 0){
                        arrow.removeClass('fa-down-long');
                        arrow.addClass('fa-up-down');
                        arrow.attr('data-sort','0');
                    }
                    var page = $("#hidden_page").val();
                    var column_name = arrow.attr('data-row-name');
                    $("#hidden_column_name").val(column_name);
                    var sort_type = arrow.attr('data-sort');
                    $("#hidden_sort_type").val(sort_type);
                    fetch_data(page,sort_type,column_name);
                });
            $(document).on('click', '.pagination a', function(event){
                event.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                $('#hidden_page').val(page);
                var column_name = $('#hidden_column_name').val();
                var sort_type = $('#hidden_sort_type').val();
                $('li').removeClass('active');
                $(this).parent().addClass('active');
                fetch_data(page, sort_type, column_name);
            });
            $(document).on('click','.delete-btn',function (e) {
                e.preventDefault();
                var $delete_id = $(this).closest('tr').find('.delete-employ').val();
                swal({
                    title: "Դուք վստահ ե՞ք",
                    text: "Ջնջվելուց հետո դուք չեք կարող վերականգնել այս ռեզյումեն:",
                    icon: "warning",
                    buttons: ["Չեղարկել", "Ջնջել"],
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            // var $data = {
                            //     "_token": $("meta[name='csrf-token']").attr("content"),
                            //     "id": $delete_id
                            // };
                            $.ajax({
                                type: "DELETE",
                                url: '/deleteCV/' + $delete_id,
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
        });

    </script>
@endpush