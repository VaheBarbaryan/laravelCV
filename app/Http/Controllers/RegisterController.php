<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\User;
use Illuminate\Support\Str;
use Session;

class RegisterController extends Controller
{
    public function registerForm() {
        return view('register_form');
    }

    public function register(Request $request) {
        $validator = Validator::make($request->all(),
            [
                'name' => [
                    'required',
                    'regex:/^([^0-9]*)$/',
                ],
                'email' => 'required|email',
                'pass' => [
                    'required',
                    'regex:/[a-z]/',
                    'regex:/[A-Z]/',
                    'regex:/[0-9]/',
                    'min:8',
                ],
                'c_pass' => 'required|same:pass'
            ],
            [
                'name.required' => 'Այս դաշտը պարտադիր է',
                'name.regex' => 'Այս դաշտը չպետք է պարունակի անօրինական նիշեր',
                'email.required' => 'Այս դաշտը պարտադիր է',
                'email.email' => 'Այս դաշտը պետք է լինի Էլ․ փոստ',
                'pass.required' => 'Այս դաշտը պարտադիր է',
                'pass.min' => 'Այս դաշտը պետք է պարունակի առնվազն 8 նիշ',
                'pass.regex' => 'Այս դաշտը վավեր չէ',
                'c_pass.required' => 'Այս դաշտը պարտադիր է',
                'c_pass.same' => 'Գաղտնաբառերը չեն համընկնում',
            ]
        );
        $errors = [];
        if(preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/',$request->name) || preg_match('~[0-9]+~',$request->name)) {
            $errors['name'][0] = 'Այս դաշտը չպետք է պարունակի անօրինական նիշեր կամ թվեր';
        }

        $errors = array_merge($errors,$validator->errors()->toArray());


        if(count($errors) > 0) {
            $errors = $validator->errors()->toArray();
            return redirect()->back()->withErrors($errors)->withInput();
        }

        DB::beginTransaction();

        try {
            $user = User::where('email',addslashes(htmlspecialchars($request->email)))->first();
            if($user) {
                return redirect()->back()->withInput()->with('error','Այսպիսի Էլ․ փոստով օգտատեր արդեն գոյություն ունի');
            }

            $user = new User();

            $user->name = addslashes(htmlspecialchars(trim($request->name)));
            $user->email = addslashes(htmlspecialchars($request->email));
            $user->password = Hash::make(trim($request->pass));
            $user->remember_token = Str::random(35);

            $user->save();
            DB::commit();

            return redirect()->back()->with('success','Դուք հաջողությամբ գրանցվեցիք');

        }catch(\Exception $err) {
            DB::rollBack();
            dd($err);
        }
    }

    public function recreatePassword($token) {
        $user = User::where('remember_token',$token)->first();
        if(!$user)
            return redirect()->back();

        return view('reset_password', ['token' => $user->remember_token]);
    }

    public function updatePassword(Request $request, $token) {
        $validator = Validator::make($request->all(),
            [
                'pass' => [
                    'required',
                    'regex:/[a-z]/',
                    'regex:/[A-Z]/',
                    'regex:/[0-9]/',
                    'min:8',
                ],
                'c_pass' => 'required|same:pass'
            ],
            [
                'pass.required' => 'Այս դաշտը պարտադիր է',
                'pass.min' => 'Այս դաշտը պետք է պարունակի առնվազն 8 նիշ',
                'pass.regex' => 'Այս դաշտը վավեր չէ',
                'c_pass.required' => 'Այս դաշտը պարտադիր է',
                'c_pass.same' => 'Գաղտնաբառերը չեն համընկնում',
            ]
        );
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        $user = User::where('remember_token', $token)->first();
        $user->password = Hash::make(trim($request->pass));
        $user->save();
        return view('email.success_message');
    }
}
