<?php
/**
 * @return mixed
 * Custom functions made by ownerschaat
 * Auther: Sikandar Hayat
 */
use Illuminate\Database\Eloquent\Model;

function unique_slug($title = '', $model = ''){
    $slug = str_slug($title);
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


function unique_slug_with_underscore($title = ''){

    $slug = str_slug_custom($title);

    if ($slug === ''){
        $string = mb_strtolower($title, "UTF-8");;
        $string = preg_replace("/[\/\.]/", " ", $string);
        $string = preg_replace("/[\s_]+/", " ", $string);
        $slug = preg_replace("/[\s_]/", '_', $string);
    }

    //get unique slug...

    return $slug;
}

function str_slug_custom($title, $separator = '_', $language = 'en')
{
    return Str::slug($title, $separator, $language);
}

if(!function_exists('parseTemplate')) {
    /**
     * Replace pattern inside Curly Brace {}
     *
     * @param string $body
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return string|string[]|null|mixed
     */
    function replaceTemplate($body, $model) {
        if(!$model instanceof Model) {
            throw new Error("{$model} is Not instance of \Illuminate\Database\Eloquent\Model");
        }

        $pattern = "/\{([^}]+)\}/"; //The Pattern to replace "{replace_this}"

        preg_match_all($pattern, $body, $placeholders);

        $placeholders = $placeholders[1]; //get identity inside curly brace in array

        for ($i= 0; $i < count($placeholders) ; $i++) {
            if($model[$placeholders[$i]]) {
                $body = preg_replace("/{{$placeholders[$i]}}/", $model[$placeholders[$i]], $body);
            }
        }

        return $body;
    }
}

if(!function_exists('company')) {
    /**
     * Get auth user company
     *
     * @return \App\Company
     */
    function company($guard = 'api') {
        $user = auth($guard)->user();

        return $user->company;
    }
}