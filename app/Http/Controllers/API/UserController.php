<?php
namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use App\UserConversations;
use App\UserEmotions;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Validator;
use DB;

use Illuminate\Support\Str;

class UserController extends Controller
{

    public function register(Request $request)
    {

        $code = $this->errorCode;
        $msg = "Invalid request!";
        $resp = new \stdClass();
        $input = $request->all();

        $validator = Validator::make($request->all(), ['name' => 'required|min:3',
            
           
            // 'password' => 'required|min:6',
        ]);
        if ($validator->fails()) {
            $msg = implode("\n", $validator->messages()->all());

        } else {

            $credentials = [
                'name' => $request->name,
                // 'password' => $request->password
            ];
            $credentials['password'] = 123456;

            // $email_exist = User::select("id")->where("name", $credentials['name'])->get()->whereNull('deleted_at')->first();

            // if (!empty($email_exist->id)) {
            //     $user = User::find($email_exist->id);

             

            //     $token = $user->createToken('TutsForWeb')->accessToken;

            //     //$token = auth()->user()->createToken('TutsForWeb')->accessToken;
            //     $resp->token = $token;

            //     $resp->user = $user;
            //     $msg = 'Successfully login';
            //     $code = $this->successCode;
            // } else {

            //     if (!empty($input['name'])) {
            //         $email_exist = User::select("id")->where("name", $credentials['name'])->get()->whereNull('deleted_at')->first();
            //         if (!empty($email_exist)) {
            //             $code = $this->errorCode;
            //             $msg = "Name already exist";
            //             return response()->json(["data" => $resp, "code" => $code, "message" => $msg], $this->httpStatus);
            //         }
            //     }
                $uuid =  Str::uuid()->toString();

                $user = User::create([
                    'name' => $request->name,                   
                    'password' => bcrypt(123456),
                    'uuid' => $uuid
                ]);

                $token = $user->createToken('TutsForWeb')->accessToken;
                $user->roles()->attach(Role::where('name', $this->userRole)->first());
                $user = User::find($user->id);
                $resp->user = $user;
                $resp->token = $token;
                $code = $this->successCode;
                $msg = 'Registration done Successfully';
            //}
        }

        return response()->json(["data" => $resp, "code" => $code, "message" => $msg], $this->httpStatus);
    }

    /**
     * Handles Login Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {

        $code = $this->errorCode;
        $msg = "Invalid request!";
        $resp = new \stdClass();
        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',

        ]);
        if ($validator->fails()) {
            $msg = implode("\n", $validator->messages()->all());

        } else {

            $credentials = [
                'email' => $request->email,
                // 'password' => $request->password
            ];
            $credentials['password'] = 123456;

            if (auth()->attempt($credentials)) {
                $token = auth()->user()->createToken('TutsForWeb')->accessToken;
                $resp->token = $token;
                $user = Auth::user();
                $resp->user = $user;
                $msg = 'Successfully login';
                $code = $this->successCode;
            } else {

                $code = 401;
                $msg = 'Unauthorized';

                return response()->json(["data" => $resp, "code" => $code, "message" => $msg], $this->httpStatus);
            }

        }

        return response()->json(["data" => $resp, "code" => $code, "message" => $msg], $this->httpStatus);
    }


     /**
     * Mark Conversion
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function mark_conversation(Request $request)
    {

        $code = $this->errorCode;
        $msg = "Invalid request!";
        $resp = new \stdClass();
        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'user_id' => 'required',


        ]);
        if ($validator->fails()) {
            $msg = implode("\n", $validator->messages()->all());

        } else {

            $user = User::select("*")->where("uuid",$request->user_id)->get()->first();

            if(empty($user->id))
            {
                $msg = 'User details does not exist';

                $code = $this->errorCode;
            }
            else
            {
              
                $conver_data['conversation_id'] = $string =  Str::random(16);
                $conver_data['conversation_submitted_time'] = now();
                $conver_data['user_id'] = $user->id;
                $conversation_data = UserConversations::create($conver_data);

                if(!empty($conversation_data->id))
                {
                    $msg = 'Mark conversation end Successfully';
                    $code = $this->successCode;
                }
                else
                {
                    $msg = 'Some error occued';
                    $code = $this->errorCode;
                }
            }

        }

        return response()->json(["data" => $resp, "code" => $code, "message" => $msg], $this->httpStatus);
    }

     /**
     * Add Emotion
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function add_emotion(Request $request)
    {

        $code = $this->errorCode;
        $msg = "Invalid request!";
        $resp = new \stdClass();
        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'emotion' => 'required',
            


        ]);
        if ($validator->fails()) {
            $msg = implode("\n", $validator->messages()->all());

        } else {

             $user = User::select("*")->where("uuid",$request->user_id)->get()->first();

            if(empty($user->id))
            {
                $msg = 'User details does not exist';

                $code = $this->errorCode;
            }
            else
            {

                $emotion_data['emotion'] = $request->emotion;            
                $emotion_data['user_id'] = $user->id;
                $created_emotion_data = UserEmotions::create($emotion_data);

                if(!empty($created_emotion_data->id))
                {
                    $msg = 'Emotion added Successfully';
                    $code = $this->successCode;
                }
                else
                {
                    $msg = 'Some error occued';
                    $code = $this->errorCode;
                }
            }

        }

        return response()->json(["data" => $resp, "code" => $code, "message" => $msg], $this->httpStatus);
    }


     /**
     * Add Emotion
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_user_stats(Request $request)
    {

        $code = $this->errorCode;
        $msg = "Invalid request!";
        $resp = new \stdClass();
        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
          

        ]);
        if ($validator->fails()) {
            $msg = implode("\n", $validator->messages()->all());

        } else {

             $user = User::select("*")->where("uuid",$request->user_id)->get()->first();

            if(empty($user->id))
            {
                $msg = 'User details does not exist';

                $code = $this->errorCode;
            }
            else
            {

                $emotion_data =  UserEmotions::select("emotion", DB::raw("count(*) as emotion_count"))->where("user_id",$user->id)->groupBy('emotion')->get();

               

                $conversation_data =  $workouts_plan = DB::select("SELECT count(id) as conversation_count,date(conversation_submitted_time) as conversation_date_time from users_conversations where user_id = ".$user->id." group by date(conversation_submitted_time) ");
                $conversation_arr = array();
                if(!empty($conversation_data))
                {
                    foreach ($conversation_data as $key => $value) {
                        
                        $conver_data['conversation_count'] = $value->conversation_count;
                        $conver_data['conversation_date_time'] = strtotime($value->conversation_date_time)*1000;
                        $conversation_arr[] = $conver_data;
                    }
                }

                 $data['emotion_stats'] = $emotion_data;

                 $data['conversion_stats'] = $conversation_arr;

                 $msg = 'User stats information';

                 $code = $this->successCode;

                 $resp = $data;

             }
             

        }

        return response()->json(["data" => $resp, "code" => $code, "message" => $msg], $this->httpStatus);
    }




}