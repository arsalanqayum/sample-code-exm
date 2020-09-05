<?php

namespace App\Services\Company;

use App\CellCerifications;
use Illuminate\Support\Str;

class RegisterService
{
    /**
     * Create Cell Cerification
     *
     * @param \App\User $user
     * @param boolean $saveVerification
     * @return boolean
     */
    public function createVerification($user, $random_number)
    {
        $verification = new CellCerifications();
        $verification->user_id = $user->id;
        $verification->cerification_code = $random_number;

        return $verification->save();
    }

    /**
     * Create company unique slug
     *
     * @param string $title
     * @param string $model
     * @return mixed
     */
    public function unique_slug($title = '', $model = 'Company')
    {
        $slug = Str::slug($title);
        if ($slug === ''){
            $string = mb_strtolower($title, "UTF-8");;
            $string = preg_replace("/[\/\.]/", " ", $string);
            $string = preg_replace("/[\s-]+/", " ", $string);
            $slug = preg_replace("/[\s_]/", '-', $string);
        }

        //get unique slug...
        $nSlug = $slug;
        $i = 0;

        $model = str_replace(' ','',"\App\ ".$model);
        while( ($model::where('slug', $nSlug)->count()) > 0){
            $i++;
            $nSlug = $slug.'-'.$i;
        }
        if($i > 0) {
            $newSlug = substr($nSlug, 0, strlen($slug)) . '-' . $i;
        } else
        {
            $newSlug = $slug;
        }
        return $newSlug;
    }
}