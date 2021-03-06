<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->middleware('auth');
        $this->userRepository = $userRepository;
    }

    public function index($userId)
    {
        $user = $this->userRepository->byId($userId);
        return view('user.index', compact('user'));
    }

    public function avatar()
    {
        return view('user.avatar');
    }

    public function upload(Request $request)
    {
        $file = $request->file('img');
        $fileName = 'avatars/' . md5(time() . user()->id) . '.' . $file->getClientOriginalExtension();

        // 本地存储
        // $file->move(public_path('avatars'), $fileName);
        // user()->avatar = '/avatars/' . $fileName;

        // 七牛云
        Storage::disk('qiniu')->writeStream($fileName, fopen($file->getRealPath(), 'r'));
        user()->avatar = 'http://' . config('filesystems.disks.qiniu.domain') . '/' . $fileName;

        user()->save();

        return ['url' => user()->avatar];
    }
}
