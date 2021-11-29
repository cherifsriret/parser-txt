
@extends('frontend.layouts.master')
@section('title','File Parser || HOME PAGE')

@section('main-content')
<script>
    $('.preloader').hide();
</script>
    <div class="container">
            <div class="row">
                <div class="col-lg-8 col-12 mx-auto">
                    <div class="inner">
                        <h3>{{$document->file_name}}</h3>
                        {{ $document->text}}
                    </div>
            </div>
        </div>
    </div>
