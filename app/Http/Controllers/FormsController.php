<?php

namespace App\Http\Controllers;

use App\Mail\MailForms;
use App\Mail\MailFormsForAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use stdClass;

class FormsController extends Controller
{
    public function checkForm(Request $request)
    {
        if ($request->has('token') && empty($request->input('token'))) {
            echo json_encode(['success' => false]);
        }
        //send admin
        $obj = new stdClass();
        $obj->name = (string) $request->input('first_name');
        $obj->email = $request->input('email');
        $obj->link = (string) $request->input('link');
        $obj->name_project = (string) $request->input('name_project');
        $obj->budjet = $request->input('MinRage') . " $ - " . $request->input('MaxRage') . ' $';
        $obj->sender = "Administration";
        Mail::to("bmo.ossystem@gmail.com")->send(new MailFormsForAdmin($obj));

        //send user
        $obj = new stdClass();
        $obj->name = (string) $request->input('first_name');
        $obj->lang = (string) $request->input('lang');
        $obj->sender = "Administration";
        Mail::to((string) $request->input('email'))->send(new MailForms($obj));
        echo json_encode(['success' => true]);
        // return response()->json(['status' => "ok"]);
    }
}
