<?php

namespace App\Policies;

use App\Lagu;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LaguPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
      return $this->getPermission($user,80);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Role  $role
     * @return mixed
     */
    public function view(User $user)
    {
     return $this->getPermission($user,77);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
      return $this->getPermission($user,76);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Role  $role
     * @return mixed
     */
    public function update(User $user)
    {
      return $this->getPermission($user,78);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Role  $role
     * @return mixed
     */
    public function delete(User $user)
    {
      return $this->getPermission($user,79);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Role  $role
     * @return mixed
     */
    public function restore(User $user)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Role  $role
     * @return mixed
     */
    public function forceDelete(User $user)
    {
        //
    }
    protected function getPermission($user, $p_id){
        foreach ($user->roles as $role ) {
            foreach ($role->permissions as $permission) {
                if($permission->id == $p_id){
                    return true;
                }
            }
        }
        return false;
    }
}
