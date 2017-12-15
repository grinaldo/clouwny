@extends('layouts.master')

@section('page-title')
Clouwny | FAQ
@endsection

@section('content')
<section class="section pad-vertical-hero">
    <div class="container container--mid-container">
        <div class="row">
            <div class="col m12 s12">
                <center><h2>FAQ</h2></center>
                <div class="divider"></div>
            </div>
        </div>
        <div class="row">
            <div class="col s12">
                <ul class="collapsible" data-collapsible="accordion">
                    @if(!empty($faqs) && count($faqs))
                    @foreach($faqs as $faq)
                    <li>
                        <div class="collapsible-header"><i class="fa fa-icon fa-question"></i>
                            <b>{!! $faq->name !!}</b>
                        </div>
                        <div class="collapsible-body">
                            <p>
                                <b>Question: </b> 
                                <span>{!! $faq->question !!}</span>
                            </p>
                            <p>
                                <b>Answer: </b> 
                                <span>{!! $faq->ansewr !!}</span>
                            </p>
                        </div>
                    </li>
                    @endforeach
                    @else
                    <li>
                        <div class="collapsible-header"><i class="fa fa-icon fa-question"></i>
                            <b>No Listed FAQ</b>
                        </div>
                        <div class="collapsible-body">
                            -
                        </div>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</section>
@endsection


@section('page-script')
@endsection