<?php

use http\Client\Request;

class UserManager {
    public function destroy(User $referent)
    {
        $connectedUser= Auth::user();

        if($referent->id != $connectedUser->id){
            $company = Auth::user()->active_company;
            $referent->detach_company($company->id);
        }
        else{
            return response(['errors' => 'Vous ne pouvez pas vous supprimer vous même'], 403);
        }
    }

    public function update(Request $request, User $user)
    {
        $activeCompany = $user->active_company()->first();
        if(isset($request->user['firstname'])) $user->firstname = $request->user['firstname'];
        if(isset($request->user['lastname'])) $user->lastname = $request->user['lastname'];
        if(isset($request->user['email'])) $user->email = $request->user['email'];
        /* if(isset($request->user['phone_number'])) */ $user->phone_number = $request->user['phone_number'];
        if(isset($request->user['address'])) $user->address = $request->user['address'];
        if(isset($request->user['company'])) $activeCompany->name = $request->user['company'];
        if(isset($request->user['ape'])) $activeCompany->ape = $request->user['ape'];
        if(isset($request->user['siret'])) $activeCompany->siret = $request->user['siret'];
        if(isset($request->user['password']) && $request->user['password'] != '' && $request->user['password'] != null){
            $user->password = Hash::make($request->user['password']);
        }
        if(isset($request->user['companies'][0]['pivot']['function']) && $user->active_company()->count() > 0){
            $user->active_company()->updateExistingPivot($activeCompany, ['function' => $request->user['companies'][0]['pivot']['function']], false);
        }

        if(isset($request->user['role'])){
            if($user->defaultRole()->first() != null){
                $user->removeRole($user->defaultRole()->first()->name);
            }
            if($user->mainRole()->first() != null){
                $user->removeRole($user->mainRole()->first()->name);
            }
            if($request->user['role'] != ''){
                if(in_array($request->user['role'], [User::ROLE_ADMIN_PAYEUR, User::ROLE_ADMIN_ENTREPRISE, User::ROLE_REFERENT, User::ROLE_BENEFICIARY])){
                    $user->assignMainRole($request->user['role']);
                }else{
                    $user->assignMainRole(User::ROLE_REFERENT);
                    $user->assignDefaultRole($request->user['role']);
                }
            }
        }
        $activeCompany->save();
        $user->save();
    }
}
