@extends('layouts.admin')


@section('content')
  <div class="page-content">
    <div class="container">
      <div class="resume-container">
        <div class="shadow-1-strong bg-white my-5 p-5" id="about">
          <div class="about-section">
            <div style="width: 100%; max-width: 600px; margin: 0 auto;">
                <div class="row mt-2">
                  <h2 class="h2 fw-light mb-4 text-center">Ընդհանուր տվյալներ</h2>
                  <div class="col-sm-5">
                    <div class="pb-3 fw-bolder"><i class="fa-solid fa-user"></i> Անուն Ազգանուն</div>
                  </div>
                  <div class="col-sm-7">
                    <div class="pb-2">{{ $employ->name_surname }}</div>
                  </div>
                  <div class="col-sm-5">
                    <div class="pb-3 fw-bolder"><i class="fa-solid fa-cake-candles"></i> Ծննդյան ամսաթիվ</div>
                  </div>
                  <div class="col-sm-7">
                    <div class="pb-3">{{ date('d.m.Y',strtotime($employ->birth_date)) }} թ.</div>
                  </div>
                  <div class="col-sm-5">
                    <div class="pb-3 fw-bolder"><i class="fa-solid fa-calendar-days"></i> Դիմելու ամսաթիվ </div>
                  </div>
                  <div class="col-sm-7">
                    <div class="pb-3">{{ date('d.m.Y',strtotime($employ->application_date)) }} թ.</div>
                  </div>
                  <div class="col-sm-5">
                    <div class="pb-3 fw-bolder"><i class="fa-solid fa-calendar-days"></i> Հարցաղրույցի ամսաթիվ </div>
                  </div>
                  <div class="col-sm-7">
                    <div class="pb-3">{{ date('d.m.Y',strtotime($employ->date_interview)) }} թ.</div>
                  </div>
                  <div class="col-sm-5">
                    <div class="pb-3 fw-bolder"><i class="fa-solid fa-phone"></i> Հեռախոսահամարներ</div>
                  </div>
                  <div class="col-sm-7">
                    <div class="pb-3">
                      @foreach($employ->phone as $item)
                        <p class="mb-0">{{ $item->phone_code }} {{$item->phone_number}}</p>
                      @endforeach
                    </div>
                  </div>
                  <div class="col-sm-5">
                    <div class="pb-2 fw-bolder"><i class="fa-solid fa-hashtag"></i> Սոցիալական կայքեր</div>
                  </div>
                  <div class="col-sm-7" style="word-wrap: break-word;">
                    <div class="pb-2">
                      @foreach($employ->social_site as $item)
                        <a class="mb-0" href="{{ $item->link }}" target="_blank">{{ $item->link }}</a><br>
                      @endforeach
                    </div>
                  </div>
                  <div class="col-sm-5">
                    <div class="pb-2 fw-bolder"><i class="fa-solid fa-user-tie"></i> Մասնագիտություն </div>
                  </div>
                  <div class="col-sm-7">
                    <div class="pb-2">{{ $employ->proffession }}</div>
                  </div>
                  <div class="col-sm-5">
                    <div class="pb-2 fw-bolder"><i class="fa-solid fa-sack-dollar"></i> Ակնկալվող աշխատավարձ </div>
                  </div>
                  <div class="col-sm-7">
                    <div class="pb-2">@if($employ->expected_salary) {{number_format($employ->expected_salary,0,'.',' ') }} ՀՀ դրամ@else - @endif</div>
                  </div>
                  <div class="col-sm-5">
                    <div class="pb-2 fw-bolder"><i class="fa-solid fa-file"></i> Կցած ֆայլեր</div>
                  </div>
                  <div class="col-sm-7" style="word-wrap: break-word;">
                    <div class="pb-2">
                      @foreach($employ->cv as $cv)
                        <a class="mb-0" href="{{ $cv->path }}" target="_blank">{{ $cv->name }}</a><br>
                      @endforeach
                    </div>
                  </div>
                  <div class="col-sm-5">
                    <div class="pb-2 fw-bolder"><i class="fa-solid fa-comment"></i> Մեկնաբանություններ </div>
                  </div>
                  <div class="col-sm-7" style="word-wrap: break-word;">
                    <div class="pb-2">@if($employ->comments){{$employ->comments }}@else - @endif</div>
                  </div>
                </div>
            </div>
          </div>
        </div>
        <div class="shadow-1-strong bg-white my-5 p-5" id="experience">
          <div class="work-experience-section">
            <h2 class="h2 fw-light mb-4">Աշխատանքային փորձ</h2>
            <div class="timeline">
              @if(count($employ->experience))
                @php $delay = 0 @endphp
                @foreach($employ->experience as $item)
                  <div class="timeline-card timeline-card-info" data-aos="fade-in" data-aos-delay="{{ $delay }}">
                    <div class="timeline-head px-4 pt-3">
                      <div class="h5">{{ $item->name_company }}</div>
                    </div>
                    <div class="timeline-body px-4 pb-4">
                      <div class="text-muted text-small mb-3">{{ date('d.m.Y',strtotime($item->work_start))}} - {{ date('d.m.Y',strtotime($item->work_end)) }} թթ․</div>
                      <div>Աշխատավարձ։ {{ number_format($item->salary,0,'.',' ') }} ՀՀ դրամ</div>
                    </div>
                  </div>
                  @php $delay += 200 @endphp
                @endforeach
              @else
                <div style="font-size: 30px;">-</div>
              @endif
            </div>
          </div>
        </div>
        <div class="shadow-1-strong bg-white my-5 p-5" id="education">
          <div class="education-section">
            <h2 class="h2 fw-light mb-4">Կրթություն</h2>
            <div class="timeline">
              @if(count($employ->education) > 0)
                @php $delay = 0 @endphp
                @foreach($employ->education as $item)
                  @if($item->faculty)
                    <div class="timeline-card timeline-card-success" data-aos="fade-in" data-aos-delay="{{ $delay }}">
                      <div class="timeline-head px-4 pt-3">
                        <div class="h5">{{ $item->faculty->institute ? $item->faculty->institute->institute_name  : ''}}</div>
                      </div>
                      <div class="timeline-body px-4 pb-4">
                        <div class="text-muted text-small mb-3">{{ $item->faculty->faculty_name }}</div>
                      </div>
                    </div>
                    @php $delay += 200 @endphp
                  @endif
                @endforeach
              @else
                <div style="font-size: 30px;">-</div>
              @endif
            </div>
          </div>
        </div>
      </div></div>
  </div>
@endsection
@push('style')
  <link href="{{ asset('cv_view_css/font-awesome/css/all.min.css?ver=1.2.1') }}" rel="stylesheet">
{{--  <link href="{{ asset('cv_view_css/mdb.min.css?ver=1.2.1') }}" rel="stylesheet">--}}
  <link href="{{ asset('cv_view_css/aos.css?ver=1.2.1') }}" rel="stylesheet">
  <link href="{{ asset('cv_view_css/main.css?ver=1.2.1') }}" rel="stylesheet">
@endpush
@push('script')
  <script src="{{ asset('cv_view_scripts/mdb.min.js?ver=1.2.1') }}"></script>
  <script src="{{ asset('cv_view_scripts/aos.js?ver=1.2.1') }}"></script>
  <script src="{{ asset('cv_view_scripts/main.js?ver=1.2.1') }}"></script>
@endpush