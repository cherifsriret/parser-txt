<?php

namespace App\Http\Controllers;
use App\Models\Word;
use App\User;
use Auth;
use Session;
use DB;
use Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FrontendController extends Controller
{
    public function home(){
      
        return view('frontend.index')->with('documents',null);
    }

     public function indexationTEXTE(Request $request)
    {
        try {
            $niceNames = [
                'word_search'=>"Document"
            ];
            $validator = Validator::make($request->all(), [
                'word_search' => 'required',
            ],[], $niceNames);
            if ($validator->fails()) {
                $errors = [];
                foreach ($validator->errors()->all() as $error) {
                    $errors[] = $error;
                }
                request()->session()->flash('error',implode("<br>", $errors));
            } else {

                $word_search =  $request->word_search;
                $documents = Word::where('words.text', 'LIKE', '%' . $word_search . '%')->join('document_word', 'words.id', '=', 'document_word.word_id')->join('documents', 'documents.id', '=', 'document_word.document_id')->select('documents.id','documents.file_name','documents.extension','documents.excerpt',"document_word.occurence")->orderBy("document_word.occurence", 'desc')->get();
                
               return view('frontend.index')->with('word_search',$word_search)->with('documents',$documents);

            }
        } catch (\Exception $e) {
           
        }
    }
}
