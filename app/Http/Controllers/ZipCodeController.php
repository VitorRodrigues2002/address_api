<?php
namespace App\Http\Controllers;

use App\Models\ZipCode;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ZipCodeController extends Controller
{
    public function zipCode(string $zipCode)
    {
        try {
            [$number, $extension] = explode('-', $zipCode, 2);
        } catch (\Throwable $th) {
            return $this->defaultResponse(false, 'Invalid Zip Code', null, 404);
        }

        if (!is_numeric($number) && !is_numeric($extension)) {
            return $this->defaultResponse(false, 'Invalid Zip Code', null, 404);
        }

        if (strlen($number) != 4) {
            return $this->defaultResponse(false, 'Invalid first half', null, 404);
        }

        if (strlen($extension) != 3) {
            return $this->defaultResponse(false, 'Invalid second half', null, 404);
        }

        $success = true;
        $message = null;

        try {
            $addresses = ZipCode::with('county', 'district')
                ->where('number', $number)
                ->where('extension', $extension)
                ->get();
        } catch (\Throwable $th) {
            $success = false;

            $message = $th->getMessage();
        }

        return $this->defaultResponse($success, $message, $addresses ?? null);
    }

    public function show($id)
    {
        try {
            $show = ZipCode::findOrFail($id);
        } catch (ModelNotFoundException) {
            return $this->defaultResponse(false, 'Invalid Id');
        }

        return $this->defaultResponse(true, null, collect($show) ?? null);
    }
}
