<?php

namespace App\Http\Controllers;

use App\Models\User;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Image;

class DashboardController extends Controller
{
    public function index()
    {
        $title = 'لوحة التحكم';
        return view('dashboard.index', compact('title'));
    }
    public function userInfo()
    {
        //Get current user
        $user = auth()->user();
        //Check if user has full name only without first and last name and complete fields if not
        if ($user->name != null & $user->first_name == null) {
            $user->first_name = isset(explode(' ', $user->name)[0]) ? explode(' ', $user->name)[0] : null;
            $user->last_name = isset(explode(' ', $user->name)[1]) ? explode(' ', $user->name)[1] : null;
            $user->save();
        }
        //End check if user has full name only without first and last name and complete fields if not
        $title = 'تعديل بيانات المستخدم';
        //Giving the value of the avatar to new property called image to be easly used with image component
        $user->image = $user->avatar;
        //End giving the value of the avatar to new property called image to be easly used with image component
        return view('dashboard.profile.userInfo', compact('user', 'title'));
    }
    public function update_user_info(Request $request)
    {
        //Get current user
        $user = auth()->user();
        //Initiate new variable to take request items to be able to modify what we need
        $data = $request->all();
        //Remove items from request to prevent errors from creating model because they are not found in the columns of the table represented by this model
        if (!$data['password']) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }
        //End remove items from request to prevent errors from creating model because they are not found in the columns of the table represented by this model

        //Uploding Image
        if ($request->hasFile('image')) {
            $up_file = 'uploads/profile/';
            $img_name = $data['first_name'] . '_' . $data['last_name'] . hexdec(uniqid()) . '.' . strtolower($request->file('image')->getClientOriginalExtension());
            Image::make($request->file('image'))->resize(200, 200)->save($up_file . $img_name);
            $data['avatar'] = $up_file . $img_name;
            if (file_exists($user->avatar)) {
                unlink($user->avatar);
            }
        }
        //End uploding Image

        //Complete user full name from first and last name
        $data['name'] = $data['first_name'] . ' ' . $data['last_name'];
        //End complete user full name from first and last name
        $user->update($data);

        return redirect()->back()->with('success', 'تم تعديل البيانات بنجاح');
    }

    public function delete_user_image(Request $request)
    {
        //Get current user
        $user = auth()->user();
        //Remove user's image file first
        if (file_exists($user->avatar)) {
            unlink($user->avatar);
        }
        //End remove user's image file first
        $user->avatar = null;
        $user->save();
        return response()->json([
            'success' => true,
        ]);
    }

    public function delete_user(Request $request)
    {
        //Get the id of selected user to be removed
        $id = $request->id;
        //End get the id of selected user to be removed
        $user = User::find($id);
        //Remove user's image file first
        if (file_exists($user->avatar)) {
            unlink($user->avatar);
        }
        //End remove user's image file first
        $user->delete();
        return response()->json([
            'success' => true,
            'message'=>'تم حذف المستخدم بنجاح'
        ]);
    }
    public function usersList(Request $request)
    {
        $role = $request->role;
        $title = 'المستخدمون والصلاحيات';
        //Sending GET Response to show items in datatables
        if ($request->ajax()) {
            //Get list acccording to role
            switch ($role) {
                case '0':
                    $users = User::where('id', '<>', auth()->user()->id)->with('beinCards')->get();
                    break;
                case '1':
                    $users = User::where('id', '<>', auth()->user()->id)->whereNull('role')->with('beinCards')->get();
                    break;
                case '2':
                    $users = User::where('id', '<>', auth()->user()->id)->whereRole('admin')->with('beinCards')->get();
                    break;
            }
            //End get list acccording to role
            return DataTables()->of($users)->addIndexColumn()->make(true);
        }
        //End sending GET Response to show items in datatables
        return view('dashboard.profile.usersList', compact('title'));
    }
    public function changeUserRole(Request $request)
    {
        //Get the id of selected user to change his role
        $id = $request->id;
        //End get the id of selected user to change his role
        //Get the new role of selected user
        $newRole = $request->role;
        //End get the new role of selected user
        $user = User::find($id);
        if ($user->role == $newRole) {
            return response()->json([
                'success' => false,
                'message' => 'لقد قمت باختيار نفس الصلاحية الموجودة',
            ]);
        }
        $user->role = $newRole;
        $user->save();
        return response()->json([
            'success' => true,
            'message' => 'تم تغيير الصلاحية',
        ]);
    }

}
