
@extends('frontend.layouts.master')
@section('title','File Parser || HOME PAGE')
@section('main-content')
<section class="search-word-document section">
    <div class="container">
        <div class="inner-top">
            <div class="row">
                <div class="col-lg-8 col-12 mx-auto">
                    <div class="inner">
                        <h4>Search a word</h4>
                        <form action="{{route('search')}}" method="post" class="document-word-inner">
                            @csrf
                            <input name="word_search" placeholder="Enter word to search" required value="{{$word_search??''}}" type="text">
                            <button class="btn" type="submit">Search</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@if($documents)
<div class="table-responsive">

    <ul>
        @foreach($documents as $document)

        <li>
            <div style="padding: 0 50px 50px 100px;">
                <h3>{{$document->id}} - <a target="_blank" href="{{route('indexation.show',$document->id)}}">{{$document->file_name}}</a></h3>
                <p>{{$document->excerpt}}</p>
            </div>

        </li>
        @endforeach
    </ul>
{{--

        <table class="table table-bordered" id="user-dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
            <th>S.N.</th>
              <th>Nom fichier</th>
              <th>Extrait</th>
              <th>Extension</th>
              <th>Occuernce</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
                <th>S.N.</th>
                <th>Nom fichier</th>
                <th>Extrait</th>
                <th>Extension</th>
                <th>Occuernce</th>
              </tr>
          </tfoot>
          <tbody>
            @foreach($documents as $document)
                <tr>
                    <td>{{$document->id}} </td>
                    <td><a target="_blank" href="{{route('indexation.show',$document->id)}}">{{$document->file_name}}</a></td>
                    <td>{{$document->excerpt}}</td>
                    <td>{{$document->extension}}</td>
                    <td>{{$document->occurence}}


                    </td>
                </tr>
            @endforeach
          </tbody>
        </table>
        --}}
      </div>
@endif

@endsection
