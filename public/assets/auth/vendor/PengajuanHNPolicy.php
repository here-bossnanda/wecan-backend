<?php

namespace App\Policies;

use App\User;
use App\PengajuanLiburNasional;
use Illuminate\Auth\Access\HandlesAuthorization;

class PengajuanHNPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the pengajuan libur nasional.
     *
     * @param  \App\User  $user
     * @param  \App\PengajuanLiburNasional  $pengajuanLiburNasional
     * @return mixed
     */
    public function view(User $user)
    {
        //
    }

    /**
     * Determine whether the user can create pengajuan libur nasionals.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the pengajuan libur nasional.
     *
     * @param  \App\User  $user
     * @param  \App\PengajuanLiburNasional  $pengajuanLiburNasional
     * @return mixed
     */
    public function update(User $user)
    {
        //
    }

    /**
     * Determine whether the user can delete the pengajuan libur nasional.
     *
     * @param  \App\User  $user
     * @param  \App\PengajuanLiburNasional  $pengajuanLiburNasional
     * @return mixed
     */
    public function delete(User $user)
    {
        //
    }

    /**
     * Determine whether the user can restore the pengajuan libur nasional.
     *
     * @param  \App\User  $user
     * @param  \App\PengajuanLiburNasional  $pengajuanLiburNasional
     * @return mixed
     */
    public function restore(User $user)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the pengajuan libur nasional.
     *
     * @param  \App\User  $user
     * @param  \App\PengajuanLiburNasional  $pengajuanLiburNasional
     * @return mixed
     */
    public function forceDelete(User $user)
    {
        //
    }
    public function crud(User $user)
    {
      return $this->getPermission($user,31);
    }
    protected function getPermission($user,$p_id)
   {
       foreach ($user->roles as $role) {
           foreach ($role->permissions as $permission) {
               if ($permission->id == $p_id) {
                   return true;
               }
           }
       }
       return false;
   }
}
