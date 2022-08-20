<?php

namespace App\Http\Controllers;

use App\Countries;
use App\Education;
use App\Employer;
use App\Experience;
use App\Institute;
use App\Faculty;
use App\Cv;
use App\Mail\ResetPasswordMail;
use App\Surrender;
use App\User;
use App\Role;
use App\Phone;
use App\Social_site;
use App\User_role;
use function foo\func;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Mail\SendQueuedMailable;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Redirect;
//use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\MessageBag;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Http\Requests\CreateCvRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Validation\Rules\In;
use Session;

class UserController extends Controller
{
    private $count;

    function __construct()
    {
        $this->count = Employer::count();
    }

    public function login(Request $request)
    {

        $validator = Validator::make($request->all(),
            [
                'email' => 'required|email',
                'pass' => 'required'
            ],
            [
                'email.required' => 'Այս դաշտը պարտադիր է',
                'email.email' => 'Այս դաշտը պետք է լինի Էլ․ փոստ',
                'pass.required' => 'Այս դաշտը պարտադիր է'
            ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return redirect()->back()->withErrors($errors)->withInput();
        }
        $user = User::where('email', addslashes(htmlspecialchars($request->email)))->first();
        $errors = new MessageBag();

        if (!$user) {
            $errors->add('email', 'Օգտատեր չի գտնվել');
//            dd($errors);
            return redirect()->back()->withErrors($errors)->withInput($request->only('email'));
        }
        if (!Hash::check($request->pass, $user->password)) {
            $errors->add('pass', 'Սխալ գաղտնաբառ');
            return redirect()->back()->withErrors($errors)->withInput($request->only('email'));
        }
        /* if($user->verified != 1){
             $errors->add('email','Այս էջը վավերացված չէ։');
             return Redirect::back()->withErrors($errors)->withInput($request->only('email'));
         }*/
        Auth::login($user, true);
        return redirect()->route('dashboard');

    }

    public function logout1()
    {
        Auth::logout();
        return response()->json();
//        return redirect('/');
    }

    public function Add_cv(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'date_interview' => 'required|date_format:d/m/Y|after_or_equal:application_date,birth_date|before_or_equal:today',
                'application_date' => 'required|date_format:d/m/Y|before_or_equal:date_interview,today|after:birth_date',
                'name_surname' => 'required',
                'birth_date' => 'required|date_format:d/m/Y|before:16 years ago|before:application_date,date_interview',
                'proffession' => 'required',
                'phones.*.phone_number' => 'required|regex:/^[0-9 ]+$/',
                'social_sites.*' => 'required|url',
                'files' => 'required',
                'files.*' => 'required|mimes:pdf,docx',
                'faculties.*' => 'required',
                'exp.*.name_company' => 'required',
                'exp.*.work_start' => 'required|date_format:d/m/Y|before:exp.*.work_end',
                'exp.*.work_end' => 'required|date_format:d/m/Y|after:exp.*.work_start',
                'exp.*.salary' => 'required|numeric'
            ],
            [
                'application_date.required' => 'Այս դաշտը պարտադիր է',
                'application_date.before_or_equal' => 'Դիմելու ամսաթիվը պետք է լինի հարցազրույցի ամսաթվից առաջ',
                'application_date.after' => 'Դիմելու ամսաթիվը պետք է լինի ծննդյան ամսաթվից առաջ',
                'application_date.date_format' => 'Այս ամսաթիվը վավեր չէ',
                'date_interview.required' => 'Այս դաշտը պարտադիր է',
                'date_interview.after_or_equal' => 'Հարցազրույցի ամսաթիվը պետք է լինի դիմելու ամսաթվից հետո',
                'date_interview.after_or_equal:birth_date' => 'Հարցազրույցի ամսաթիվը պետք է լինի ծննդյան ամսաթվից հետո',
                'date_interview.before_or_equal' => 'Հարցազրույցի ամսաթիվը պետք է լինի այսօրվանից առաջ կամ հավաասար',
                'date_interview.date_format' => 'Այս ամսաթիվը վավեր չէ',
                'name_surname.required' => 'Այս դաշտը պարտադիր է',
                'birth_date.required' => 'Այս դաշտը պարտադիր է',
                'birth_date.date_format' => 'Այս ամսաթիվը վավեր չէ',
                'birth_date.before:application_date' => 'Այս ամսաթիվը պետք է լինի դիմելու ամսաթվից առաջ',
                'birth_date.before:date_interview' => 'Այս ամսաթիվը պետք է լինի հարցազրույցի ամսաթվից առաջ',
                'birth_date.before' => 'Այս ամսաթիվը վավեր չէ',
                'proffession.required' => 'Այս դաշտը պարտադիր է',
                'phones.*.phone_number.required' => 'Այս դաշտը պարտադիր է',
                'phones.*.phone_number.regex' => 'Այս դաշտը պետք է պարունակի միայն թվեր',
                'social_sites.*.required' => 'Այս դաշտը պարտադիր է',
                'social_sites.*.url' => 'Այս դաշտը վավեր չէ',
                'files.required' => 'Այս դաշտը պարտադիր է',
                'files.*.mimes' => 'Այս դաշտը պետք է պարունակի միայն pdf, docx տիպերի ֆայլեր',
                'faculties.*.required' => 'Համալսարան ընտրված չէ',
                'exp.*.name_company.required' => 'Այս դաշտը պարտադիր է',
                'exp.*.work_start.required' => 'Այս դաշտը պարտադիր է',
                'exp.*.work_start.before' => 'Այս ամսաթիվը պետք է լինի աշխատանքի ավարտի ամսաթվից առաջ',
                'exp.*.work_start.date_format' => 'Այս ամսաթիվը վավեր չէ',
                'exp.*.work_end.required' => 'Այս դաշտը պարտադիր է',
                'exp.*.work_end.after' => 'Այս ամսաթիվը պետք է լինի աշխատանքի սկզբի ամսաթվից հետո',
                'exp.*.work_end.date_format' => 'Այս ամսաթիվը վավեր չէ',
                'exp.*.salary.required' => 'Այս դաշտը պարտադիր է',
                'exp.*.salary.numeric' => 'Այս դաշտը պետք է պարունակի միայն թվեր'
            ]
        );
        $errors = [];
        $errors = array_merge($errors, $validator->errors()->toArray());
        if (count($errors) > 0) {
            return response()->json(['error' => $errors]);
        }
        DB::beginTransaction();
        try {
            $employer = new  Employer();


            $employer->application_date = (($request->input('application_date')) ? date('Y-m-d', strtotime(str_replace('/', '-', $request->input('application_date')))) : null);
            $employer->date_interview = (($request->input('date_interview')) ? date('Y-m-d', strtotime(str_replace('/', '-', ($request->input('date_interview'))))) : null);
            $employer->name_surname = $request->input('name_surname');
            $employer->birth_date = (($request->input('birth_date')) ? date('Y-m-d', strtotime(str_replace('/', '-', ($request->input('birth_date'))))) : null);
            $employer->proffession = $request->input('proffession');
            $employer->expected_salary = $request->input('expected_salary');
            $employer->comments = $request->input('comments');

            if ($employer->save()) {
                if ($request['phones']) {
                    foreach ($request['phones'] as $item) {
                        $phone = new Phone();
                        $phone->country_id = $item['country_id'];
                        $phone->phone_code = $item['phone_code'];
                        $phone->phone_number = $item['phone_number'];
                        $employer->phone()->save($phone);

                    }
                }
                if ($request['social_sites']) {
                    foreach ($request['social_sites'] as $value) {
                        $social_site = new Social_site();
                        $social_site->link = $value;
                        $employer->social_site()->save($social_site);
                    }
                }

                if ($request['faculties']) {
                    foreach ($request['faculties'] as $value) {
                        $education = new Education();
                        $education->faculty_id = $value;
                        $employer->education()->save($education);
                    }
                }

                if ($request['exp']) {
                    foreach ($request['exp'] as $item) {
                        $experience = new Experience();
                        $experience->name_company = $item['name_company'];
                        $experience->work_start = (($item['work_start']) ? date('Y-m-d', strtotime(str_replace('/', '-', ($item['work_start'])))) : null);
                        $experience->work_end = (($item['work_end']) ? date('Y-m-d', strtotime(str_replace('/', '-', ($item['work_end'])))) : null);
                        $experience->salary = $item['salary'];
                        $employer->experience()->save($experience);
                    }
                }
                if ($request->file('files')) {

                    foreach ($request['files'] as $key => $file) {
                        $fileName = Str::random(4) . time() . '.' . $file->getClientOriginalExtension();
                        Storage::disk('local')->put("public/content/file_{$employer->id}/" . $fileName, file_get_contents($file));
                        $filePath = asset("storage/content/file_{$employer->id}/$fileName");

                        $cv = new Cv();

                        $cv->name = $fileName;
                        $cv->path = $filePath;
                        $cv->employer_id = $employer->id;
                        $cv->save();
                    }
                }

            }
            DB::commit();
            return response()->json(['url' => url('/dashboard')]);
        } catch (\Exception $err) {
            DB::rollBack();
            dd($err->getMessage());
        }
    }

    public function Edit_cv($id)
    {
        $employ = Employer::with('phone', 'social_site', 'cv', 'education.faculty.institute.faculty')->where('id', $id)->first();
//        dd($employ->toArray());
        $experience = Experience::where('employer_id', $id)->get();
        $countries = Countries::get();

        $institute = Institute::get();
//        dd($employ->education->toArray());
        $faculty = Faculty::get();
        return view('editCV', ['employ' => $employ, 'experience' => $experience, 'institute' => $institute, 'faculty' => $faculty, 'countries' => $countries, 'employers_count' => $this->count]);
    }

    public function Update_cv(Request $request, $id)
    {
        $cvs = Cv::where('employer_id', $id)->get();
        if (count($cvs) == 0) {
            $validator = Validator::make($request->all(),
                [
                    'date_interview' => 'required|date_format:d/m/Y|after_or_equal:application_date',
                    'application_date' => 'required|date_format:d/m/Y|before_or_equal:date_interview|after:birth_date',
                    'name_surname' => 'required',
                    'birth_date' => 'required|date_format:d/m/Y|before:16 years ago|before:application_date,date_interview',
                    'proffession' => 'required',
                    'phones.*.phone_number' => 'required|regex:/^[0-9 ]+$/',
                    'social_sites.*' => 'required|url',
                    'files' => 'required',
                    'files.*' => 'required|mimes:pdf,docx',
                    'faculties.*' => 'required',
                    'exp.*.name_company' => 'required',
                    'exp.*.work_start' => 'required|date_format:d/m/Y|before:exp.*.work_end',
                    'exp.*.work_end' => 'required|date_format:d/m/Y|after:exp.*.work_start',
                    'exp.*.salary' => 'required|numeric'
                ],
                [
                    'application_date.required' => 'Այս դաշտը պարտադիր է',
                    'application_date.before_or_equal' => 'Դիմելու ամսաթիվը պետք է լինի հարցազրույցի ամսաթվից առաջ',
                    'application_date.after' => 'Դիմելու ամսաթիվը պետք է լինի ծննդյան ամսաթվից առաջ',
                    'application_date.date_format' => 'Այս ամսաթիվը վավեր չէ',
                    'date_interview.required' => 'Այս դաշտը պարտադիր է',
                    'date_interview.after_or_equal' => 'Հարցազրույցի ամսաթիվը պետք է լինի դիմելու ամսաթվից հետո',
                    'date_interview.date_format' => 'Այս ամսաթիվը վավեր չէ',
                    'name_surname.required' => 'Այս դաշտը պարտադիր է',
                    'birth_date.required' => 'Այս դաշտը պարտադիր է',
                    'birth_date.date_format' => 'Այս ամսաթիվը վավեր չէ',
                    'birth_date.after:application_date' => 'Այս ամսաթիվը պետք է լինի դիմելու ամսաթվից առաջ',
                    'birth_date.after:date_interview' => 'Այս ամսաթիվը պետք է լինի հարցազրույցի ամսաթվից առաջ',
                    'birth_date.before' => 'Այս ամսաթիվը վավեր չէ',
                    'proffession.required' => 'Այս դաշտը պարտադիր է',
                    'phones.*.phone_number.required' => 'Այս դաշտը պարտադիր է',
                    'phones.*.phone_number.regex' => 'Այս դաշտը պետք է պարունակի միայն թվեր',
                    'social_sites.*.required' => 'Այս դաշտը պարտադիր է',
                    'social_sites.*.url' => 'Այս դաշտը վավեր չէ',
                    'files.required' => 'Այս դաշտը պարտադիր է',
                    'files.*.mimes' => 'Այս դաշտը պետք է պարունակի միայն pdf, docx տիպերի ֆայլեր',
                    'faculties.*.required' => 'Համալսարան ընտրված չէ',
                    'exp.*.name_company.required' => 'Այս դաշտը պարտադիր է',
                    'exp.*.work_start.required' => 'Այս դաշտը պարտադիր է',
                    'exp.*.work_start.before' => 'Այս ամսաթիվը պետք է լինի աշխատանքի ավարտի ամսաթվից առաջ',
                    'exp.*.work_start.date_format' => 'Այս ամսաթիվը վավեր չէ',
                    'exp.*.work_end.required' => 'Այս դաշտը պարտադիր է',
                    'exp.*.work_end.after' => 'Այս ամսաթիվը պետք է լինի աշխատանքի սկզբի ամսաթվից հետո',
                    'exp.*.work_end.date_format' => 'Այս ամսաթիվը վավեր չէ',
                    'exp.*.salary.required' => 'Այս դաշտը պարտադիր է',
                    'exp.*.salary.numeric' => 'Այս դաշտը պետք է պարունակի միայն թվեր'
                ]
            );
        } else {
            $validator = Validator::make($request->all(),
                [
                    'date_interview' => 'required|date_format:d/m/Y|after_or_equal:application_date',
                    'application_date' => 'required|date_format:d/m/Y|before_or_equal:date_interview',
                    'name_surname' => 'required',
                    'birth_date' => 'required|date_format:d/m/Y|before:16 years ago|before:application_date,date_interview',
                    'proffession' => 'required',
                    'phones.*.phone_number' => 'required|regex:/^[0-9 ]+$/',
                    'social_sites.*' => 'required|url',
                    'files.*' => 'required|mimes:pdf,docx',
                    'faculties.*' => 'required',
                    'exp.*.name_company' => 'required',
                    'exp.*.work_start' => 'required|date_format:d/m/Y|before:exp.*.work_end',
                    'exp.*.work_end' => 'required|date_format:d/m/Y|after:exp.*.work_start',
                    'exp.*.salary' => 'required|numeric'
                ],
                [
                    'application_date.required' => 'Այս դաշտը պարտադիր է',
                    'application_date.before_or_equal' => 'Դիմելու ամսաթիվը պետք է լինի հարցազրույցի ամսաթվից առաջ',
                    'application_date.date_format' => 'Այս ամսաթիվը վավեր չէ',
                    'date_interview.required' => 'Այս դաշտը պարտադիր է',
                    'date_interview.after_or_equal' => 'Հարցազրույցի ամսաթիվը պետք է լինի դիմելու ամսաթվից հետո',
                    'date_interview.date_format' => 'Այս ամսաթիվը վավեր չէ',
                    'name_surname.required' => 'Այս դաշտը պարտադիր է',
                    'birth_date.required' => 'Այս դաշտը պարտադիր է',
                    'birth_date.date_format' => 'Այս ամսաթիվը վավեր չէ',
//                    'birth_date.after:application_date' => 'Այս ամսաթիվը պետք է լինի դիմելու ամսաթվից առաջ',
//                    'birth_date.after:date_interview' => 'Այս ամսաթիվը պետք է լինի հարցազրույցի ամսաթվից առաջ',
                    'birth_date.after:application_date' => 'Այս ամսաթիվը պետք է լինի դիմելու ամսաթվից առաջ',
                    'birth_date.after:date_interview' => 'Այս ամսաթիվը պետք է լինի հարցազրույցի ամսաթվից առաջ',
                    'birth_date.before' => 'Այս ամսաթիվը վավեր չէ',
                    'proffession.required' => 'Այս դաշտը պարտադիր է',
                    'phones.*.phone_number.required' => 'Այս դաշտը պարտադիր է',
                    'phones.*.phone_number.regex' => 'Այս դաշտը պետք է պարունակի միայն թվեր',
                    'social_sites.*.required' => 'Այս դաշտը պարտադիր է',
                    'social_sites.*.url' => 'Այս դաշտը վավեր չէ',
                    'files.*.mimes' => 'Այս դաշտը պետք է պարունակի միայն pdf, docx տիպերի ֆայլեր',
                    'faculties.*.required' => 'Համալսարան ընտրված չէ',
                    'exp.*.name_company.required' => 'Այս դաշտը պարտադիր է',
                    'exp.*.work_start.required' => 'Այս դաշտը պարտադիր է',
                    'exp.*.work_start.before' => 'Այս ամսաթիվը պետք է լինի աշխատանքի ավարտի ամսաթվից առաջ',
                    'exp.*.work_start.date_format' => 'Այս ամսաթիվը վավեր չէ',
                    'exp.*.work_end.required' => 'Այս դաշտը պարտադիր է',
                    'exp.*.work_end.after' => 'Այս ամսաթիվը պետք է լինի աշխատանքի սկզբի ամսաթվից հետո',
                    'exp.*.work_end.date_format' => 'Այս ամսաթիվը վավեր չէ',
                    'exp.*.salary.required' => 'Այս դաշտը պարտադիր է',
                    'exp.*.salary.numeric' => 'Այս դաշտը պետք է պարունակի միայն թվեր'
                ]
            );
        }

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }
        DB::beginTransaction();
        try {
            $employer = Employer::find($id);

            $employer->application_date = (($request->input('application_date')) ? date('Y-m-d', strtotime(str_replace('/', '-', $request->input('application_date')))) : null);
            $employer->date_interview = (($request->input('date_interview')) ? date('Y-m-d', strtotime(str_replace('/', '-', ($request->input('date_interview'))))) : null);
            $employer->name_surname = $request->input('name_surname');
            $employer->birth_date = (($request->input('birth_date')) ? date('Y-m-d', strtotime(str_replace('/', '-', ($request->input('birth_date'))))) : null);
            $employer->proffession = $request->input('proffession');
            $employer->expected_salary = $request->input('expected_salary');
            $employer->comments = $request->input('comments');
//            $employer->updated_at = date('d-m-y h:i:s');

            if ($employer->update()) {
                $employer->touch();
                $val = Phone::where('employer_id', $id);
                if ($val)
                    $val->delete();
                if ($request['phones']) {
                    foreach ($request['phones'] as $item) {
                        $phone = new Phone();
                        $phone->phone_code = $item['phone_code'];
                        $phone->phone_number = $item['phone_number'];
                        $phone->country_id = $item['country_id'];
                        $phone->employer_id = $employer->id;

                        $phone->save();
                    }
                }

                $val = Social_site::where('employer_id', $employer->id);
                if ($val)
                    $val->delete();

                if ($request['social_sites']) {
                    foreach ($request['social_sites'] as $value) {
                        $social_site = new Social_site();
                        $social_site->link = $value;
                        $social_site->employer_id = $employer->id;
                        $social_site->save();
                    }
                }

                $val = Education::where('employer_id', $employer->id);
                if ($val)
                    $val->delete();
                if ($request['faculties']) {
                    foreach ($request['faculties'] as $value) {
                        $education = new Education();
                        $education->faculty_id = $value;
                        $education->employer_id = $employer->id;
                        $education->save();
                    }
                }

                $val = Experience::where('employer_id', $employer->id);
                if ($val)
                    $val->delete();
                if ($request['exp']) {
                    foreach ($request['exp'] as $item) {
                        $experience = new Experience();
                        $experience->name_company = $item['name_company'];
                        $experience->work_start = (($item['work_start']) ? date('Y-m-d', strtotime(str_replace('/', '-', ($item['work_start'])))) : null);
                        $experience->work_end = (($item['work_end']) ? date('Y-m-d', strtotime(str_replace('/', '-', ($item['work_end'])))) : null);
                        $experience->salary = $item['salary'];
                        $experience->employer_id = $employer->id;
                        $experience->save();
                    }
                }


                if ($request->file('files')) {

                    foreach ($request['files'] as $key => $file) {
                        $fileName = Str::random(4) . time() . '.' . $file->getClientOriginalExtension();
                        Storage::disk('local')->put("public/content/file_{$employer->id}/" . $fileName, file_get_contents($file));
                        $filePath = asset("storage/content/file_{$employer->id}/$fileName");

                        $cv = new Cv();

                        $cv->name = $fileName;
                        $cv->path = $filePath;
                        $cv->employer_id = $employer->id;
                        $cv->save();
                    }
                }

            }
            DB::commit();
            if (Session::get('dashboard_url')) {
                return response()->json(['url' => Session::get('dashboard_url')]);
            }

            return response()->json(['url' => url('/dashboard')]);
//            return redirect()->route('dashboard');
        } catch (\Exception $err) {
            DB::rollBack();
            dd($err->getMessage());
        }
    }

    public function Delete_cv($id)
    {

        $employ = Employer::find($id);

        $ed = Education::where('employer_id', $id);
        if ($ed)
            $ed->delete();
        $exp = Experience::where('employer_id', $id);
        if ($exp)
            $exp->delete();

        $phone = Phone::where('employer_id', $id);
        if ($phone)
            $phone->delete();

        $social_site = Social_site::where('employer_id', $id);
        if ($social_site)
            $social_site->delete();

        $path = storage_path("app\public\content\\file_{$employ->id}");

        if (File::exists($path)) {
            try {
                File::deleteDirectory($path);
                Cv::where('employer_id', $employ->id)->delete();

            } catch (\Error $exp) {
                return Response::json(['success' => false, 'err' => $exp->getMessage()], 400);
            }

        }
        $employ->delete();

        return response()->json(['success' => 'Ռեզյումեն հաջողությամբ ջնջված է:']);
    }

    public function delete_file($id)
    {


        $file = Cv::find($id);

        $path = storage_path("app\public\content\\file_{$file->employer_id}\\{$file->name}");

        $path2 = storage_path("app\public\content\\file_{$file->employer_id}");

        if (File::exists($path)) {
            try {
                File::delete($path);
                $file->delete();


            } catch (\Error $exp) {
                return response()->json(['success' => false, 'err' => $exp->getMessage()], 400);
            }

        }
        if (count(glob("$path2/*")) === 0) {
            File::deleteDirectory($path2);

        }
        return response()->json(['success' => true], 200);
    }

    public function viewCv($id)
    {

        $employ = Employer::with('phone', 'social_site', 'cv', 'education.faculty.institute', 'experience')->where('id', $id)->first();
        return view('cv_view', ['employ' => $employ, 'employers_count' => $this->count]);
    }

    public function AddEducation(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'institute.*' => 'required'
            ],
            [
                'institute.*.required' => 'Այս դաշտը պարտադիր է'
            ]
        );
        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()]);
        }
        DB::beginTransaction();
        try {
            $ed = $request->institute;
            foreach ($ed as $item) {
                $find_institute = Institute::where('institute_name', $item)->first();
                if (!$find_institute)
                    $find_institute = new Institute();
                $find_institute->institute_name = $item;
                $find_institute->save();
//                $find_faculty = Faculty::where(['faculty_name' => $item['faculty'], 'institute_id' => $find_institute->id])->first();
//                if (!$find_faculty)
//                    $find_faculty = new Faculty();
//                $find_faculty->faculty_name = $item['faculty'];
//                $find_faculty->institute_id = $find_institute->id;
//                $find_faculty->save();
            }
            DB::commit();
            return response()->json(["errors" => []]);
//            return redirect()->route('education_dash')->with('message', 'Կրթական համալիրը ավելացված է');
        } catch (\Exception $err) {
            DB::rollBack();
            dd($err->getMessage());
        }
    }

    public function DeleteFac(Request $request, $id)
    {
        if (!$request->vals) {
            return response()->json(['error' => 'Ֆակուլտետները նշված չեն']);

        }
        foreach ($request->vals as $fac_id) {
            Faculty::where('id', $fac_id)->delete();
            $ed = Education::where('faculty_id', $id);
            if ($ed)
                $ed->delete();
        }


        return response()->json(['success' => 'Ֆակուլտետները հաջողությամբ ջնջված են']);
    }

    public function dashboard()
    {
        Session::put('dashboard_url', request()->fullUrl());

        $data = Employer::with('phone', 'social_site', 'cv', 'education.faculty.institute', 'experience');

        if (Session::get("searchName")) {

            $data = $data->where('name_surname', 'LIKE', '%' . Session::get('searchName') . '%');
        }
        if (Session::get("searchProffession")) {
            $data = $data->where('proffession', 'LIKE', '%' . Session::get('searchProffession') . '%');
        }
        if (Session::get("searchEducation")) {
            $data = $data->whereHas('education.faculty', function ($query) {
                $query->where('faculty.faculty_name', 'LIKE', '%' . Session::get('searchEducation') . '%');
            });
        }
        if (Session::get("searchPhone")) {
            $data = $data->whereHas('phone', function ($query) {
                $query->where('phone.phone_number', 'LIKE', '%' . Session::get('searchPhone') . '%');
            });
        }
        if (Session::get("searchExperience")) {
            $data = $data->whereHas('experience', function ($query) {
                $query->where('experience.name_company', 'LIKE', '%' . Session::get('searchExperience') . '%');
            });
        }

        if (Session::get('searchBirthStart') && Session::get('searchBirthEnd')) {
            $data = $data->whereYear('birth_date', '>=', Session::get('searchBirthStart'))
                ->whereYear('birth_date', '<=', Session::get('searchBirthEnd'));
        }

        if (Session::get('searchApplicationStart') && Session::get('searchApplicationEnd')) {
            $data = $data->whereYear('application_date', '>=', Session::get('searchApplicationStart'))
                ->whereYear('application_date', '<=', Session::get('searchApplicationEnd'));
        }

        if (Session::get('searchDateInterviewStart') && Session::get('searchDateInterviewEnd')) {
            $data = $data->whereYear('date_interview', '>=', Session::get('searchDateInterviewStart'))
                ->whereYear('date_interview', '<=', Session::get('searchDateInterviewEnd'));
        }


        $data = $data->orderBy('updated_at', 'DESC')->paginate(5);
        return view('dashboard', ['employers' => $data, 'employers_count' => $this->count]);
    }

    public function sort(Request $request)
    {
        $data = Employer::with('phone', 'social_site', 'cv', 'education.faculty.institute', 'experience');

        if (Session::get("searchName")) {

            $data = $data->where('name_surname', 'LIKE', '%' . Session::get('searchName') . '%');
        }
        if (Session::get("searchProffession")) {
            $data = $data->where('proffession', 'LIKE', '%' . Session::get('searchProffession') . '%');
        }
        if (Session::get("searchEducation")) {
            $data = $data->whereHas('education.faculty', function ($query) {
                $query->where('faculty.faculty_name', 'LIKE', '%' . Session::get('searchEducation') . '%');
            });
        }
        if (Session::get("searchPhone")) {
            $data = $data->whereHas('phone', function ($query) {
                $query->where('phone.phone_number', 'LIKE', '%' . Session::get('searchPhone') . '%');
            });
        }
        if (Session::get("searchExperience")) {
            $data = $data->whereHas('experience', function ($query) {
                $query->where('experience.name_company', 'LIKE', '%' . Session::get('searchExperience') . '%');
            });
        }

        if (Session::get('searchBirthStart') && Session::get('searchBirthEnd')) {
            $data = $data->whereYear('birth_date', '>=', Session::get('searchBirthStart'))
                ->whereYear('birth_date', '<=', Session::get('searchBirthEnd'));
        }

        if (Session::get('searchApplicationStart') && Session::get('searchApplicationEnd')) {
            $data = $data->whereYear('application_date', '>=', Session::get('searchApplicationStart'))
                ->whereYear('application_date', '<=', Session::get('searchApplicationEnd'));
        }

        if (Session::get('searchDateInterviewStart') && Session::get('searchDateInterviewEnd')) {
            $data = $data->whereYear('date_interview', '>=', Session::get('searchDateInterviewStart'))
                ->whereYear('date_interview', '<=', Session::get('searchDateInterviewEnd'));
        }
        if ($request->ajax()) {
            $sort_by = $request->get("sortby");
            $sort_type = $request->get("sorttype");
            if ($sort_type === "0") {
                $data = $data->orderBy("updated_at", "desc")->paginate(5);
            } else {
                $data = $data->orderBy($sort_by, $sort_type)->paginate(5);
            }
            return view('layouts.dashboard_data', ['employers' => $data, 'employers_count' => $this->count])->render();
        }
    }

    public function search(Request $request)
    {
//        dd($request->all());
        $data = Employer::with('phone', 'education.faculty', 'experience');
        if ($request->submit_btn) {


            if ($request->has('filter_application_date')) {
                Session::put('filter_application_date', (($request->has('filter_application_date') AND $request->filter_application_date) ? $request->filter_application_date : ""));
            } else {
                Session::forget('filter_application_date');
            }

            if ($request->has('filter_date_interview')) {
                Session::put('filter_date_interview', (($request->has('filter_date_interview') AND $request->filter_date_interview) ? $request->filter_date_interview : ""));
            } else {
                Session::forget('filter_date_interview');
            }
            if ($request->has('filter_phone')) {
                Session::put('filter_phone', (($request->has('filter_phone') AND $request->filter_phone) ? $request->filter_phone : ""));
            } else {
                Session::forget('filter_phone');
            }
            if ($request->has('filter_birth_date')) {
                Session::put('filter_birth_date', (($request->has('filter_birth_date') AND $request->filter_birth_date) ? $request->filter_birth_date : ""));
            } else {
                Session::forget('filter_birth_date');
            }
            if ($request->has('filter_expected_salary')) {
                Session::put('filter_expected_salary', (($request->has('filter_expected_salary') AND $request->filter_expected_salary) ? $request->filter_expected_salary : ""));
            } else {
                Session::forget('filter_expected_salary');
            }
            if ($request->has('filter_proffession')) {
                Session::put('filter_proffession', (($request->has('filter_proffession') AND $request->filter_proffession) ? $request->filter_proffession : ""));
            } else {
                Session::forget('filter_proffession');
            }
            if ($request->has('filter_education')) {
                Session::put('filter_education', (($request->has('filter_education') AND $request->filter_education) ? $request->filter_education : ""));
            } else {
                Session::forget('filter_education');
            }
            if ($request->has('filter_experience')) {
                Session::put('filter_experience', (($request->has('filter_experience') AND $request->filter_experience) ? $request->filter_experience : ""));
            } else {
                Session::forget('filter_experience');
            }
            if ($request->has('filter_social_sites')) {
                Session::put('filter_social_sites', (($request->has('filter_social_sites') AND $request->filter_social_sites) ? $request->filter_social_sites : ""));
            } else {
                Session::forget('filter_social_sites');
            }
            if ($request->has('filter_files')) {
                Session::put('filter_files', (($request->has('filter_files') AND $request->filter_files) ? $request->filter_files : ""));
            } else {
                Session::forget('filter_files');
            }
            if ($request->has('filter_comments')) {
                Session::put('filter_comments', (($request->has('filter_comments') AND $request->filter_comments) ? $request->filter_comments : ""));
            } else {
                Session::forget('filter_comments');
            }
        }

        if ($request->has('searchName')) {
            Session::put('searchName', (($request->has('searchName') AND $request->searchName) ? $request->searchName : ""));
        }
        if ($request->has('searchProffession')) {
            Session::put('searchProffession', (($request->has('searchProffession') AND $request->searchProffession) ? $request->searchProffession : ""));
        }
        if ($request->has('searchEducation')) {
            Session::put('searchEducation', (($request->has('searchEducation') AND $request->searchEducation) ? $request->searchEducation : ""));
        }
        if ($request->has('searchPhone')) {
            Session::put('searchPhone', (($request->has('searchPhone') AND $request->searchPhone) ? $request->searchPhone : ""));
        }
        if ($request->has('searchExperience')) {
            Session::put('searchExperience', (($request->has('searchExperience') AND $request->searchExperience) ? $request->searchExperience : ""));
        }
        if ($request->has('searchBirthStart')) {
            Session::put('searchBirthStart', (($request->has('searchBirthStart') AND $request->searchBirthStart) ? $request->searchBirthStart : now()->year() - 50));
        }
        if ($request->has('searchBirthEnd')) {
            Session::put('searchBirthEnd', (($request->has('searchBirthEnd') AND $request->searchBirthEnd) ? $request->searchBirthEnd : now()->year() - 18));
        }
        if ($request->has('searchDateInterviewStart')) {
            Session::put('searchDateInterviewStart', (($request->has('searchDateInterviewStart') AND $request->searchDateInterviewStart) ? $request->searchDateInterviewStart : now()->year() - 50));
        }
        if ($request->has('searchDateInterviewEnd')) {
            Session::put('searchDateInterviewEnd', (($request->has('searchDateInterviewEnd') AND $request->searchDateInterviewEnd) ? $request->searchDateInterviewEnd : now()->year()));
        }

        if (Session::get("searchName")) {

            $data = $data->where('name_surname', 'LIKE', '%' . Session::get('searchName') . '%');
        }
        if (Session::get("searchProffession")) {
            $data = $data->where('proffession', 'LIKE', '%' . Session::get('searchProffession') . '%');
        }
        if (Session::get("searchEducation")) {
            $data = $data->whereHas('education.faculty', function ($query) {
                $query->where('faculty.faculty_name', 'LIKE', '%' . Session::get('searchEducation') . '%');
            });
        }
        if (Session::get("searchPhone")) {
            $data = $data->whereHas('phone', function ($query) {
                $query->where('phone.phone_number', 'LIKE', '%' . Session::get('searchPhone') . '%');
            });
        }
        if (Session::get("searchExperience")) {
            $data = $data->whereHas('experience', function ($query) {
                $query->where('experience.name_company', 'LIKE', '%' . Session::get('searchExperience') . '%');
            });
        }

        if ($request->has('searchApplicationStart')) {
            Session::put('searchApplicationStart', (($request->has('searchApplicationStart') AND $request->searchApplicationStart) ? $request->searchApplicationStart : now()->year() - 50));
        }
        if ($request->has('searchApplicationEnd')) {
            Session::put('searchApplicationEnd', (($request->has('searchApplicationEnd') AND $request->searchApplicationEnd) ? $request->searchApplicationEnd : now()->year()));
        }

        $data = $data->whereYear('birth_date', '>=', Session::get('searchBirthStart'))
            ->whereYear('birth_date', '<=', Session::get('searchBirthEnd'));

        $data = $data->whereYear('application_date', '>=', Session::get('searchApplicationStart'))
            ->whereYear('application_date', '<=', Session::get('searchApplicationEnd'));

        $data = $data->whereYear('date_interview', '>=', Session::get('searchDateInterviewStart'))
            ->whereYear('date_interview', '<=', Session::get('searchDateInterviewEnd'));

        $data = $data->orderBy('updated_at', 'DESC')->paginate(5);
        return view('dashboard', ['employers' => $data, 'employers_count' => $this->count]);

    }

    public function newEmployerEducation($id)
    {

        $faculty = Faculty::where('institute_id', $id)->get();

        return response()->json($faculty);
    }

    public function create_cv()
    {
        $data = Institute::get(['id', 'institute_name']);
        $countries = Countries::get();
        return view('create_cv', ['countries' => $countries, 'institute' => $data, 'faculty' => [], 'ed' => [], 'exp' => [], 'employers_count' => $this->count]);

    }

    public function forgotPassword()
    {
        return view('forgot_password');
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'email' => 'required|email'
            ],
            [
                'email.required' => 'Այս դաշտը պարտադիր է',
                'email.email' => 'Այս դաշտը պետք է լինի Էլ․ փոստ'
            ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return redirect()->back()->withErrors($errors)->withInput();
        }

        $user = User::where('email', addslashes(htmlspecialchars($request->email)))->first();
        $errors = new MessageBag();
        if (!$user) {
            $errors->add('email', 'Այսպիսի Էլ․ փոստով օգտատեր գոյություն չունի');
            return redirect()->back()->withErrors($errors)->withInput();
        }
        $subject = "ITResources - Դուք ստացել եք նոր հաղորդագրություն։";
        $body = [
            '_token' => $user->remember_token,
        ];
//        dd($body);
        Mail::to([$request->email])->send(new ResetPasswordMail($body, null, $subject));
//        Mail::to([env('MAIL_FROM_ADDRESS')])->send(new NotifyMail($body,null,$subject[app()->getLocale()]));

        return redirect()->back()->with(['success' => 'Լինքը հաջողությամբ ուղարկվեց ձեր էլ․ փոստին']);
    }

    public function CreateEducation()
    {
        return view('create_education', ['employers_count' => $this->count]);
    }

    public function EducationDashboard()
    {
        $education = Institute::with('faculty')->get();
        return view('education_dashboard', ['education' => $education, 'employers_count' => $this->count]);
    }

    public function editEducationForm($id)
    {
        $education = Institute::with('faculty')->where('id', $id)->first();
        return view('editEducation', ['education' => $education, 'employers_count' => $this->count]);
    }

    public function editEducation(Request $request, $id)
    {
        $validator = Validator::make($request->all(),
            [
                'faculty.*' => 'required',
                'university' => 'required'
            ],
            [
                'faculty.*.required' => 'Այս դաշտը պարտադիր է',
                'university.required' => 'Այս դաշտը պարտադիր է'
            ]
        );

        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()]);
        }

        DB::beginTransaction();
        try {
            $ed = $request->faculty;

            $institute = Institute::where('id', $id)->first();
            $institute->institute_name = $request->university;
            $institute->save();
            $faculty = Faculty::where('institute_id', $id)->get();
            $faculty_count = count($faculty);
            foreach ($ed as $key => $item) {
                if ($key < $faculty_count) {
                    $faculty[$key]->faculty_name = $item;
                    $faculty[$key]->institute_id = $id;
                    $faculty[$key]->save();
                } else {
                    $faculty = new Faculty();
                    $faculty->faculty_name = $item;
                    $faculty->institute_id = $id;
                    $faculty->save();
                }
            }
            DB::commit();
            return response()->json(["errors"=>[]]);
        } catch (\Exception $err) {
            DB::rollBack();
            dd($err);
        }
    }

    public function DeleteEdu($id)
    {
        Institute::find($id)->delete();
        Faculty::with('education')->where('institute_id', $id)->delete();
        return response()->json(['success' => 'Համալսարանը հաջողությամբ ջնջված է:']);
    }

    public function roles()
    {
        $roles = Role::get();
        $user_role = User::with('Role')->get();
        return view('roles', ['roles' => $roles, 'user_role' => $user_role, 'employers_count' => $this->count]);
    }

    public function find_roles(Request $request)
    {

        if ($request->role_id) {
            $roles = Role::get();
            $user_role = User::with(['Role' => function ($q) use ($request) {
                $q->where('role.id', $request->role_id);
            }])->whereHas('Role', function ($q) use ($request) {
                $q->where('role.id', $request->role_id);
            })->get();
            return view('/roles', ['roles' => $roles, 'user_role' => $user_role, 'employers_count' => $this->count]);
        }
        return redirect()->back();
    }

    public function terminal()
    {
        return view('terminal', ['Values' => [], 'employers_count' => $this->count]);
    }

    public function payTerminal(Request $request)
    {
        $request->validate([
            'paymentAmount' => 'required|numeric|min:100',
            'incomingAmount' => 'required|numeric|min:100'
        ],
            [
                'paymentAmount.required' => 'Այս դաշտը դատարկ է',
                'incomingAmount.required' => 'Այս դաշտը դատարկ է',
                'paymentAmount.numeric' => 'Այս դաշտը չպետք է պարունակի տառեր',
                'incomingAmount.numeric' => 'Այս դաշտը չպետք է պարունակի տառեր',
                'paymentAmount.min' => 'Այս դաշտի արժեքը պետք է լինի 100-ից մեծ',
                'incomingAmount.min' => 'Այս դաշտի արժեքը պետք է լինի 100-ից մեծ',
            ]);
        $money = Surrender::orderBy('value', 'DESC')->get();
//        if($request->paymentAmount % 100 !== 0 || $request->incomingAmount % 100 !== 0)
//            return redirect()->back()->with('message','Սխալ');
        if ($request->incomingAmount >= $request->paymentAmount) {
            $difference = $request->incomingAmount - $request->paymentAmount;
            if ($difference === 0)
                return redirect()->back()->with('success', 'Մանր չկա');
            $values = [];
            foreach ($money as $row) {
                $count = floor($difference / $row->value);
                if ($count >= 1) {
                    if ($count <= $row->quantity) {
                        $values = array_pad($values, count($values) + $count, $row->value);
                        $difference = $difference - ($row->value * $count);
                        $row->quantity -= $count;
                    } else {
                        $values = array_pad($values, count($values) + $row->quantity, $row->value);
                        $difference = $difference - ($row->value * $row->quantity);
                        $row->quantity = 0;
                    }
                }
                $row->save();
            }
            if ($difference > 0) {
                $str = "Մենք ձեզ պարտք ենք $difference!";
                redirect()->back()->with('message', $str);
            }
//            dd($values, Surrender::get()->toArray());
            return view('terminal', ['Values' => $values, 'employers_count' => $this->count]);
        }
        return redirect()->back()->with('message', 'Մուտքագրվող գումարը պետք է մեծ լինի վճարվող գումարից!');
    }

    public function phoneCode()
    {
        $country = Countries::get();
        return response()->json($country);
    }
}
