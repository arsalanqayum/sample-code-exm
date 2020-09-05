<?php


namespace App\Services\Product;


use App\Automative;
use App\ComputerElectronic;
use App\Fitness;
use App\Healthcare;
use App\Home_RealState;
use App\HomeImprovement;
use App\InsuranceFinance;
use App\kid;
use App\Local_Business;
use Illuminate\Support\Facades\Auth;

class ProductListingService
{
    /**
     * health care product
     *
     * @return mixed
     */
    public function getHealthCareProduct()
    {
       return $healthCare=Healthcare::when(Auth::user()->type!='admin',function($q){
            $q->where('user_id',Auth::user()->id);
    })->orderBy('id', 'desc')->get();
    }

    /**
     * home real estate product
     *
     * @return mixed
     */
    public function getHomeRealStateListingProduct()
    {
       return $homeRealEstate=Home_RealState::when(Auth::user()->type!='admin',function($q){
            $q->where('user_id',Auth::user()->id);
        })->orderBy('id', 'desc')->get();
    }

    /**
     * local business product
     *
     * @return mixed
     */
    public function getLocalBusinessListingProduct()
    {
        return $localBusiness=Local_Business::when(Auth::user()->type!='admin',function($q){
            $q->where('user_id',Auth::user()->id);
        })->orderBy('id', 'desc')->get();
    }

    /**
     * fitness product
     *
     * @return mixed
     */
    public function getFitnessListingProduct()
    {
       return $fitness=Fitness::when(Auth::user()->type!='admin',function($q){
            $q->where('user_id',Auth::user()->id);
        })->orderBy('id', 'desc')->get();
    }

    /**
     * computer electronic product
     *
     * @return mixed
     */
    public function getComputerElectronicProduct()
    {
       return $computerElectronics = ComputerElectronic::when(Auth::user()->type!='admin',function($q){
            $q->where('user_id',Auth::user()->id);
        })->orderBy('id', 'desc')->get();
    }

    /**
     * kids product
     *
     * @return mixed
     */
    public function getKidsListingProduct()
    {
       return $kid = kid::when(Auth::user()->type!='admin',function($q){
            $q->where('user_id',Auth::user()->id);
        })->orderBy('id', 'desc')->get();
    }

    /**
     * Insurance product
     *
     * @return mixed
     */
    public function getInsuranceFinanceListingProduct()
    {
       return $insuranceFinance =InsuranceFinance::when(Auth::user()->type!='admin',function($q){
            $q->where('user_id',Auth::user()->id);
        })->orderBy('id', 'desc')->get();

    }

    /**
     * Automotive product
     *
     * @return mixed
     */
    public function getAutomotiveProduct()
    {
        return $automotive = Automative::when(Auth::user()->type!='admin',function($q){
            $q->where('user_id',Auth::user()->id);
        })->orderBy('id', 'desc')->get();
    }

    /**
     * home real estate product
     *
     * @return mixed
     */
    public function getHomeImprovement()
    {
        return $automotive = HomeImprovement::when(Auth::user()->type!='admin',function($q){
            $q->where('user_id',Auth::user()->id);
        })->orderBy('id', 'desc')->get();
    }
}
