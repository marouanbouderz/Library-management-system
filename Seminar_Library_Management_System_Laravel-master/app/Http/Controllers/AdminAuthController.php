<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Mail\ForgetPassEmail;
use Session;
use DB;
use Hash;
use Illuminate\Support\Facades\Redirect;


class AdminAuthController extends Controller
{
    public function sign_in_show()
    {
        return Redirect::to('/');
    }

    public function unified_login_show()
    {
        if (Session::has('Admin_ID') && Session::get('Admin_ID'))   return Redirect::to('/admin/dashboard');
        if (Session::has('Student_ID') && Session::get('Student_ID')) return Redirect::to('/student/dashboard');
        return view('student.sign_up_page');
    }

    public function unified_login_process(Request $req)
    {
        $identifier = $req->email;
        $password   = $req->password;

        // Check admins first
        $admin = DB::table('admins')->where('Email', $identifier)->first()
              ?? DB::table('admins')->where('Username', $identifier)->first();

        if ($admin && (Hash::check($password, $admin->Password) || $password == $admin->Password)) {
            Session::put('Admin_ID', $admin->id);
            return Redirect::to('/admin/dashboard');
        }

        // Check students
        $student = DB::table('students')->where('Email', $identifier)->first()
                ?? DB::table('students')->where('Username', $identifier)->first();

        if ($student) {
            if (!Hash::check($password, $student->Password)) {
                return back()->with(['message' => 'Mot de passe incorrect !', 'alert-type' => 'error']);
            }
            if ($student->Verify == 'No') {
                $code = rand(1000, 9999);
                DB::table('students')->where('id', $student->id)->update(['Confirmation_Code' => $code]);
                $details = ['title' => 'Bibliotheque', 'body' => 'Votre code de verification : ' . $code];
                \Mail::to($student->Email)->send(new \App\Mail\VerifyEmail($details));
                return Redirect::to('student/verify-email/' . $student->id);
            }
            if ($student->Verify == 'Panding') {
                return back()->with(['mess3' => true]);
            }
            Session::put('Student_ID', $student->id);
            return Redirect::to('/student/dashboard');
        }

        return back()->with(['message' => 'Email, nom d\'utilisateur ou mot de passe incorrect.', 'alert-type' => 'error']);
    }

    public function forget_password()
    {
        return view('admin.forget_password');
    }

    public function forget_password_process(Request $req)
    {
        $email=DB::table('admins')->where('Email',$req->email)->count();

        if($email == 0)
        {
            $notification = array(
                'message' => 'Email is not registered !',
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
        $auto_number=rand(10000000,9999999999);

        Session::put('Admin_Email',$req->email);
        Session::put('link_number_admin',$auto_number);

        $details2 = [
            'title' => 'Seminar Library Management System',
            'body' => 'Please quickly change your password by link (Between 30 Minutes) - http://localhost:8000/admin/recover-password/'.$auto_number
        ];
        \Mail::to($req->email)->send(new \App\Mail\ForgetPassEmail($details2));

        $notification = array(
            'message' => 'Successfully Email Sent ! Check your Email',
            'alert-type' => 'info'
        );
        return back()->with($notification);
    }

    public function recover_password()
    {
        return view('admin.change_password');
    }

    public function recover_password_process(Request $req)
    {
        $email=Session::get('Admin_Email');

        $student=DB::table('admins')->where('Email',$email)->first();

        if($req->new_password == $req->confirm_password)
        {
            $data=array();
            $pass=Hash::make($req->new_password);
            $data['Password']=$pass;
            $update_password=DB::table('admins')->where('Email',$email)->update($data);

            if($update_password)
            {
                $notification = array(
                    'mess2' => 'Sucessfully Change Password !',
                );
                Session::put('link_number_admin',null);
                return Redirect::to('/')->with($notification);
            }
            else
            {
                $notification = array(
                    'message' => 'Time is over !',
                    'alert-type' => 'error'
                );
                return back()->with($notification);
            }
        }
        else
        {
            $notification = array(
                'message' => 'Password do not match !',
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function sign_in_process(Request $req)
    {
        $email = DB::table('admins')->where('Email',$req->email)->count();
        $username = DB::table('admins')->where('Username',$req->email)->count();

        if($email > 0 || $username > 0)
        {
            if($email > 0)
            {
                $admin = DB::table('admins')->where('Email',$req->email)->first();
            }
            if($username > 0)
            {
                $admin = DB::table('admins')->where('Username',$req->email)->first();
            }

            if(Hash::check($req->password,$admin->Password) || $req->password==$admin->Password)
            {
                Session::put('Admin_ID',$admin->id);
                return Redirect::to('/admin/dashboard');
            }
            else
            {
                $notification = array(
                    'message' => 'Wrong Password !',
                    'alert-type' => 'error'
                );
                return back()->with($notification);
            }
        }
        else
        {
            $notification = array(
                'message' => 'Wrong Username or Email !',
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function dashboard()
    {
        $admin_status=Session::get('Admin_ID');

        if(! $admin_status)
        {
            return Redirect::to('/');
        }

        // Core counts
        $total_student  = DB::table('students')->where('Verify','Approve')->count();
        $total_book     = DB::table('books')->sum('Amounts');
        $total_shelf    = DB::table('shelfs')->count();
        $total_order    = DB::table('records')->where('Submission_Status','No')->count();

        // Badge stats
        $pending_students  = DB::table('students')->where('Verify','Pending')->count();
        $borrowed_books    = DB::table('records')->where('Submission_Status','No')->count();
        $active_shelves    = DB::table('books')->distinct()->count('Shelf_ID');
        $returned_orders   = DB::table('records')->where('Submission_Status','Yes')->count();

        // Progress bar widths
        $students_borrowing = DB::table('records')->where('Submission_Status','No')->distinct('Student_ID')->count('Student_ID');
        $student_bar = $total_student  > 0 ? min(100, round($students_borrowing / $total_student * 100)) : 0;
        $book_bar    = $total_book     > 0 ? min(100, round($borrowed_books    / $total_book     * 100)) : 0;
        $shelf_bar   = $total_shelf    > 0 ? min(100, round($active_shelves    / $total_shelf    * 100)) : 0;
        $total_all_records = DB::table('records')->count();
        $order_bar   = $total_all_records > 0 ? min(100, round($total_order / $total_all_records * 100)) : 0;

        $records = DB::table('records')->where('Submission_Status','No')->orderBy('id','desc')->paginate(3);

        return view('admin.dashboard', compact(
            'total_student','total_book','total_shelf','total_order',
            'pending_students','borrowed_books','active_shelves','returned_orders',
            'students_borrowing','total_all_records',
            'student_bar','book_bar','shelf_bar','order_bar',
            'records'
        ));
    }

    public function log_out()
    {
        Session::forget('Admin_ID');
        Session::flush();
        return Redirect::to('/');
    }

    public function student_request()
    {
        $admin_status=Session::get('Admin_ID');

        if(! $admin_status)
        {
            return Redirect::to('/');
        }

        $student=DB::table('students')->where('Verify','Panding')->get();

        return view('admin.student_request',compact('student'));
    }

    public function change_password()
    {
        $admin_status=Session::get('Admin_ID');

        if(! $admin_status)
        {
            return Redirect::to('/');
        }

        return view('admin.change_auth_password');
    }

    public function change_password_process(Request $req)
    {
        $admin=Session::get('Admin_ID');

        $admin_account=DB::table('admins')->where('id',$admin)->first();

        if(Hash::check($req->old_password,$admin_account->Password) || $req->old_password==$admin_account->Password)
        {
            if($req->new_password==$req->confirm_password)
            {
                $req->new_password=Hash::make($req->new_password);

                $data=array();
                $data['Password']=$req->new_password;

                $update_password=DB::table('admins')->where('id',$admin)->update($data);

                if($update_password)
                {
                    $notification = array(
                        'message' => 'Successfully change password !',
                        'alert-type' => 'success'
                    );
                    return back()->with($notification);
                }
                else
                {
                    $notification = array(
                        'message' => 'Same password is exits !',
                        'alert-type' => 'error'
                    );
                    return back()->with($notification);
                }
            }
            else
            {
                $notification = array(
                    'message' => 'Password do not match !',
                    'alert-type' => 'error'
                );
                return back()->with($notification);
            }
        }
        else
        {
            $notification = array(
                'message' => 'Wrong Old Password !',
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function edit_info()
    {
        $admin_status=Session::get('Admin_ID');

        if(! $admin_status)
        {
            return Redirect::to('/');
        }

        $admin=DB::table('admins')->where('id',$admin_status)->get();

        return view('admin.edit_info',compact('admin'));
    }

    public function update_info_process(Request $req)
    {
        $data=array();

        $admin_status=Session::get('Admin_ID');

        $data['Username']=$req->username;

        $check_username=DB::table('admins')->where('Username',$req->username)->count();

        if($check_username > 0)
        {
            $notification = array(
                'message' => 'Username already exits !',
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }

        $update_info=DB::table('admins')->where('id',$admin_status)->update($data);

        if($update_info)
        {
            $notification = array(
                'message' => 'Successfully updated info !',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }
    }
}
