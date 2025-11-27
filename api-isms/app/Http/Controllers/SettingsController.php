<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class SettingsController extends BaseController
{
    public function updateEditorKey($key)
    {
        DB::table('isms_settings')
            ->where('key_type', 'tinymce')
            ->update([
                'token_key' => $key,
            ]);
        return "Key Updated Succesully";
    }

    public function TinyMce()
    {
        if (Schema::hasTable('tinymce_master')) {
            $records = DB::table('tinyMCE_master')->get();
            return view('tinyMCE', compact('records'));
            return response()->json($records);
        } else {
            echo 'Table does not exist';
        }
        exit;
    }

    public function TinyMceUpdateStatus(Request $request)
    {
        // $this->WriteFileLog($request);
        DB::table('tinymce_master')
            ->update([
                'status' => 0,
            ]);

        DB::table('tinymce_master')
            ->where('id', $request->id)
            ->update([
                'status' => 1,
            ]);

        $editor_key = DB::table('tinymce_master')
            ->where('id', $request->id)
            ->value('editor_key');

        DB::table('isms_settings')
            ->where('key_type', 'tinymce')
            ->update([
                'token_key' => $editor_key,
            ]);
        return response()->json(['status' => 'success']);
    }
    public function TinyMceAddRecord(Request $request)
    {

        if ($request->enable == 1) {
            DB::table('tinymce_master')
                ->update([
                    'status' => 0,
                ]);

            DB::table('isms_settings')
                ->where('key_type', 'tinymce')
                ->update([
                    'token_key' => $request->key,
                ]);

            $tinymce_id = DB::table('tinymce_master')
                ->insertGetId([
                    'registered_email' => $request->email,
                    'editor_key' => $request->key,
                    'status' => $request->enable,
                    'last_active_from' => now()
                ]);
        } else {

            $tinymce_id = DB::table('tinymce_master')
                ->insertGetId([
                    'registered_email' => $request->email,
                    'editor_key' => $request->key,
                    'status' => $request->enable
                ]);
        }

        $last_active_from = DB::table('tinymce_master')
            ->where('id', $tinymce_id)
            ->value('last_active_from');

        return response()->json([
            "status" => "success",
            "data" => [
                "id" => $tinymce_id,
                "registered_email" => $request->email,
                "last_active_from" => ($request->enable == 1 ? $last_active_from : '-'),
                "last_active_to" => "-"
            ]
        ]);
    }
}
