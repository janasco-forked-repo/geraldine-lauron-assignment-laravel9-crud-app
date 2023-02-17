<?php

namespace App\Http\Controllers;

use App\Models\Hat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HatController extends Controller
{
    // set index page view
    public function index() {
        return view('index');
    }

    // handle fetch all eamployees ajax request
    public function read() {
        $read_hats = Hat::all();
        $output = '';
        if ($read_hats->count() > 0) {
            $output .= '<table class="table table-striped table-sm text-center align-middle">
            <thead>
              <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Hat Name</th>
                <th>Hat Desc</th>
                <th>Hat Link</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>';
            foreach ($read_hats as $read_hat) {
                $output .= '<tr>
                <td>' . $read_hat->id . '</td>
                <td><img src="storage/images/' . $read_hat->hat_image . '" width="50" class="img-thumbnail "></td>
                <td>' . $read_hat->hat_name . '</td>
                <td>' . $read_hat->hat_desc . '</td>
                <td><a href="' . $read_hat->hat_link . '">Go visit link</a></td>
                <td>
                  <a href="#" id="' . $read_hat->id . '" class="text-success mx-1 viewIcon" data-bs-toggle="modal" data-bs-target="#viewHatModal"><i class="bi-info-circle h4"></i></a>
                  
                  <a href="#" id="' . $read_hat->id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editHatModal"><i class="bi-pencil-square h4"></i></a>

                  <a href="#" id="' . $read_hat->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>
                </td>
              </tr>';
            }
            $output .= '</tbody></table>';
            echo $output;
        } else {
            echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
        }
    }

    // handle insert a new hat ajax request
    public function create(Request $request) {
        $file = $request->file('hat_image');
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/images', $fileName);

        $hatData = ['hat_name' => $request->hat_name, 'hat_desc' => $request->hat_desc, 'hat_link' => $request->hat_link, 'hat_image' => $fileName];
        Hat::create($hatData);
        return response()->json([
            'status' => 200,
        ]);
    }

    // handle edit an hat ajax request
    public function edit(Request $request) {
        $id = $request->id;
        $edit_hat = Hat::find($id);
        return response()->json($edit_hat);
    }

    // handle view an hat ajax request
    public function view(Request $request) {
        $id = $request->id;
        $view_hat = Hat::find($id);
        return response()->json($view_hat);
    }

    // handle update an hat ajax request
    public function update(Request $request) {
        $fileName = '';
        $update_hat = Hat::find($request->update_hat_id);
        if ($request->hasFile('hat_image')) {
            $file = $request->file('hat_image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/images', $fileName);
            if ($update_hat->hat_image) {
                Storage::delete('public/images/' . $update_hat->hat_image);
            }
        } else {
            $fileName = $request->update_hat_image;
        }

        $hatData = ['hat_name' => $request->hat_name, 'hat_desc' => $request->hat_desc, 'hat_link' => $request->hat_link, 'hat_image' => $fileName];

        $update_hat->update($hatData);
        return response()->json([
            'status' => 200,
        ]);
    }

    // handle delete an hat ajax request
    public function delete(Request $request) {
        $id = $request->id;
        $delete_hat = Hat::find($id);
        if (Storage::delete('public/images/' . $delete_hat->hat_image)) {
            Hat::destroy($id);
        }
    }
}
