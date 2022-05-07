<?php
namespace App\Repositories\Eloquent;
use App\Helpers\PaginationHelper;
use \App\Models\User;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Gate;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * UserRepository constructor.
     *
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function searchQuery($query, string $keyword)
    {
        return $query->where(function ($q) use ($keyword) {
            $q->where('name', 'LIKE', "%{$keyword}%")
                ->orWhere('id', 'LIKE', "%{$keyword}%");
        });
    }

    public function adminQuery($query)
    {
        return $query->where(function ($q){
            $q->where('is_admin', 1);
        });
    }

    public function getAllUsersWithQueryString()
    {
        $query = $this->model->query();

        if ($keyword = request('search')) {
            $query = $this->searchQuery($query, $keyword);
        }

        if (request('admin')) {
            $query = $this->adminQuery($query);
        }
        return $query->get();
    }

    public function filterThroughTheGate(string $ability, $users)
    {
        return $users->filter(function ($user) use ($ability) {

            if ($user->isAdmin()) {
                $response = Gate::inspect($ability, [User::class, $user]);
                if ($response->denied()) {
                    return false;
                }
            }
            if ($user->id == auth()->user()->id)
                return false;

            return $user;
        });
    }

    public function paginateUsers($users, $perPage = 10)
    {
        return PaginationHelper::paginate($users, $perPage);
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function update($user, $data)
    {
        $user->update($data);
    }

    public function delete($user)
    {
        $deleted_title = $user->title . '_deleted_' . $user->id;
        $user->update([
            'title' => $deleted_title
        ]);
        $user->delete($user);
    }
}
