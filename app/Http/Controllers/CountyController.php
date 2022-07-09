<?php
namespace App\Http\Controllers;

use App\Models\County;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CountyController extends Controller
{
    /**
     * params name, code, dist_code
     *
     * @param [type] $findName
     * @return void
     */
    public function search()
    {
        $success = true;
        $message = null;

        try {
            $county = new County;
            if (request()->code) {
                $county = $county->whereCode(request()->code);
            }
            if (request()->name) {
                $county = $county->whereName(request()->name);
            }
            if (request()->code_district) {
                $county = $county->whereCode_district(request()->code_district);
            }
        } catch (\Throwable $th) {
            $success = false;

            $message = $th->getMessage();
        }

        return $this->defaultResponse($success, $message, $county->get() ?? null);
    }

    public function show($id)
    {
        try {
            $show = County::findOrFail($id);
        } catch (ModelNotFoundException) {
            return $this->defaultResponse(false, 'Invalid Id');
        }

        return $this->defaultResponse(true, null, collect($show) ?? null);
    }
}
