<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    protected $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = Gate::inspect('view', User::class);
        if ($response->denied()) {
            return view('admin.dashboard')->withError($response->message());
        }

        $users = $this->userService->getAllUsersWithQueryString();

        $filtered = $this->userService->filterThroughTheGate('viewAdmin', $users);

        $paginated = $this->userService->paginateUsers($filtered);

        return view('admin.users.all', ['users' => $paginated]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $create_user = Gate::inspect('create', User::class);
        $create_admin = Gate::inspect('createAdmin', User::class);

        if ($create_user->allowed() || $create_admin->allowed()) {
            $admin_permissions = $this->userService->adminPermissions();
            return view('admin.users.create', compact('admin_permissions'));
        }

        return view('admin.dashboard')->withError('شما به این بخش دسترسی ندارید');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(StoreUserRequest $request)
    {
        if ($request->has('is_admin')) {
            $this->authorize('createAdmin', User::class);
            $request['is_admin'] = 1;
        }

        $this->userService->storeUser($request->all());

        return redirect(route('admin.users.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User $user
     */
    public function edit(User $user)
    {
        if ($user->isAdmin()) {
            $this->authorize('updateAdmin', $user);
        } else {
            $this->authorize('update', $user);
        }

        $admin_permissions = $this->userService->adminPermissions();
        return view('admin.users.edit', compact(['admin_permissions', 'user']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User $user
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        if ($user->isAdmin() || $request->has('is_admin')) {
            $this->authorize('updateAdmin', $user);

        } else {
            $this->authorize('update', $user);
        }

        $this->userService->updateUser($request, $user);

        alert()->success('اطلاعات کاربر موردنظر با موفقیت ویرایش شد.', 'تبریک')->persistent('بسیار خب');
        return redirect(route('admin.users.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User $user
     */
    public function destroy(User $user)
    {
        if ($user->isAdmin()) {
            $this->authorize('deleteAdmin', $user);
        } else {
            $this->authorize('delete', $user);
        }

        $this->userService->removeUser($user);

        alert()->success(' کاربر موردنظر با موفقیت حذف شد.', 'تبریک')->persistent('متوجه شدم!');
        return back();
    }
}
