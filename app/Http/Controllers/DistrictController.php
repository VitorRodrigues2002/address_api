<?php
namespace App\Http\Controllers;

use App\Models\District;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DistrictController extends Controller
{
    public function search()
    {
        $success = true;
        $message = null;

        try {
            $district = new District();
            if (request()->code) {
                $district = $district->whereCode(request()->code);
            }
            if (request()->name) {
                $district = $district->whereName(request()->name);
            }
        } catch (\Throwable $th) {
            $success = false;

            $message = $th->getMessage();
        }

        return $this->defaultResponse($success, $message, $district->get() ?? null);
    }

    public function show($id)
    {
        try {
            $show = District::findOrFail($id);
        } catch (ModelNotFoundException) {
            return $this->defaultResponse(false, 'Invalid Id');
        }

        return $this->defaultResponse(true, null, collect($show) ?? null);
    }
}
