<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use User;

class StudentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function addStudent(Request $request)
    {
        $validator = Validator::make($request->all(), ['firstname'=>'string|required',
                                                        'lastname'=>'string|required',
                                                        'cne'=>'required',
                                                        'email'=>'email|required',
                                                        'password'=>'string|required',
                                                        'gsm'=>'required']);

        if($validator->fails())
            return $this->sendError("Veuillez remplir correctement tous les champs", 400);
    
        if(DB::table('users')->where(['userType'=>'student', 'cne'=>$request->cne])->exists())
            return $this->sendError('Un étudiant avec ce cne existe déjà', 403);
        
        if(DB::table('users')->where(['userType'=>'student', 'email'=>$request->email])->exists())
            return $this->sendError('Un étudiant avec ce email existe déjà', 403);
        
        try{
            DB::table('users')->insert(['firstname'=>$request->firstname,
                        'lastname'=>$request->lastname,
                        'cne'=>$request->cne,
                        'email'=>$request->email,
                        'password'=>Hash::make($request->password),
                        'userType'=>'student',
                        'pp'=>'/storage/default.png',
                        'gsm'=>$request->gsm]);
        }
        catch(\Exception $e)
        {
            return $this->sendError($e->getMessage(), 403);
        }


        return $this->sendConfirmation("L'utilisateur a été enregistré avec succès", 201);
    }


    public function updateStudent(Request $request)
    {
        $validator = Validator::make($request->all(), ['firstname'=>'string|required',
                                                        'lastname'=>'string|required',
                                                        'cne'=>'required',
                                                        'email'=>'email|required',
                                                        'password'=>'string|required',
                                                        'gsm'=>'required',
                                                        'id'=>'numeric|required']);

        if($validator->fails())
            return $this->sendError("Veuillez remplir correctement tous les champs", 400);

        $student = DB::table('users')->where(['id'=>$request->id, 'userType'=>'student'])->first();
        //return $student;
        if(is_null($student))
            return $this->sendError('Ce étudiant n\'existe pas dans le système', 404);

        $emailOwner = DB::table('users')->where(['email'=>$request->email, 'userType'=>'student'])->first();
        if($emailOwner->id!=$student->id)
            return $this->sendError('Un étudiant avec cet email existe déjà', 403);
        
        $cneOwner = DB::table('users')->where(['cne'=>$request->cne, 'userType'=>'student'])->first();
        if($cneOwner->id!=$student->id)
            return $this->sendError('Un étudiant avec cet cne existe déjà', 404);
    
            $student->firstname=$request->firstname;
            $student->lastname=$request->lastname;
            $student->cne=$request->cne;
            $student->email=$request->email;
            $student->password=Hash::make($request->password);
            $student->userType='student';
            $student->gsm=$request->gsm;

            DB::table('users')->where('id', $student->id)->update(['firstname'=>$request->firstname,
                                                                    'lastname'=>$request->lastname,
                                                                    'gsm'=>$request->gsm,
                                                                    'email'=>$request->email,
                                                                    'password'=>Hash::make($request->password),
                                                                    'cne'=>$request->cne
                                                                    ]);
      
        return $this->sendConfirmation("L'utilisateur a modifié avec succès enregistré avec succès", 200);
    }

    public function getStudentInfos($studentId)
    {
        $student = DB::table('users')->where(['userType'=>'student', 'id'=>$studentId])->first();
        return $this->sendResult($student, 200);
    }

    public function getAllStudents()
    {
        $students = DB::table('users')->where('userType', 'student')->get();
        return $this->sendResult($students, 200);
    }

    public function searchStudent(Request $request)
    {
        $students = DB::table('users')->where([['firstname', 'like', $request->q.'%'], ['userType', '=', 'student']])
                                            ->orWhere([['lastname', 'like', $request->q.'%',], ['userType', '=', 'student']])
                                            ->orWhere([['cne', 'like', $request->q.'%'], ['userType', '=', 'student']])
                                            ->get();

        return $this->sendResult($students, 200);
    }

    public function deleteStudent($studentId)
    { 
        if(!(DB::table('users')->where('id', $studentId)->exists()))
            return $this->sendError("Cet étudiant n'existe pas", 404);
        DB::table('users')->where('id', $studentId)->delete();
        return $this->sendConfirmation("L'étudiant a été supprimé avec succès", 200);
    }
    
}
