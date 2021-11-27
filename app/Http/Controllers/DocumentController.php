<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Word;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
class DocumentController extends Controller
{
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $documents=Document::orderBy('id','ASC')->paginate(10);
        return view('backend.documents.index')->with('documents',$documents);
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.documents.create');
    }


    function store(Request $request)
    {

        try {
            $niceNames = [
                'document'=>"Document"
            ];
            $validator = Validator::make($request->all(), [
               // 'document' => 'mimes:txt,html,htm|max:8000|required',
            ],[], $niceNames);
            if ($validator->fails()) {
                $errors = [];
                foreach ($validator->errors()->all() as $error) {
                    $errors[] = $error;
                }
                request()->session()->flash('error','Error occurred while adding document');
            } else {
                $upload_file = $request->file('document');
                $txt_file    = file_get_contents($upload_file);
                $realExtension = $request->file('document')->getClientOriginalExtension();
                $filename = "document-" . Carbon::now()->timestamp. "." . $realExtension;
                $excerpt= $this->excerpt($txt_file, 20);
                //create document
                $document = new Document();
                $document->file_name =  $filename;
                $document->text =  $txt_file;
                $document->excerpt =  $excerpt;
                $document->extension =  $realExtension;
                $document->save();
                //parse words of document
                $rows        = explode("\n", $txt_file);
                array_shift($rows);
                foreach($rows as $row => $data)
                {
                    foreach (explode(' ',$data) as $key => $word) {
                        if(strlen($word)>2 )
                        {
                             $word_model = Word::firstOrCreate(
                                ['text' =>  $word],
                            );
                            if($document->words()->where('text',$word)->count()>0)
                            {
                                $document_word = $document->words()->where('text',$word)->first();
                                $document_word->pivot->occurence = $document_word->pivot->occurence+1;
                                $document_word->pivot->save();
                            }
                            else{
                                $document->words()->attach($word_model,['occurence'=>1]);
                            }
                        }
                    }
                }
            request()->session()->flash('success','Successfully added document');
               return redirect()->route('documents.index');

            }
        } catch (\Exception $e) {
            dd($e->getMessage());
            request()->session()->flash('error','Error occurred while adding document');
        }
    }



    function excerpt($paragraph, $limit)
    {
        $text="";
        $words=0;
        $tok = strtok($paragraph, " ");
        while ($tok !== false) {
            $text .= " ".$tok;
            $words++;
            if (($words >= $limit) && ((substr($tok, -1) == "!") || (substr($tok, -1) == ".") || (substr($tok, -1) == "?"))) {
            break;
            }
            $tok = strtok(" ");
        }
        return ltrim($text);
    }

}
