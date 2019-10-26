@extends('layouts.BootStrapBody')
@section('title','informacion del projecto')

@section('MainContent')

<h2>@lang('parkinsoft.infoProjTag')</h2>
<br>
<div>
    @lang('parkinsoft.infoProjBody1') <br><br>
    @lang('parkinsoft.infoProjBody2') <br><br>

    @lang('parkinsoft.infoProjList1Title')
    <ul>
    <li>@lang('parkinsoft.infoProjList1Bullet1')</li>
    <li>@lang('parkinsoft.infoProjList1Bullet2')</li>
    </ul>  

    @lang('parkinsoft.infoProjList2Title')
    <ul>
    <li>@lang('parkinsoft.infoProjList2Bullet1')</li>
    </ul>  

    @lang('parkinsoft.infoProjList3Title')
    <ul>
    <li>@lang('parkinsoft.infoProjList3Bullet1')</li>
    <li>@lang('parkinsoft.infoProjList3Bullet2')</li>
    </ul>  

    @lang('parkinsoft.infoProjList4Title')
    <ul>
    <li>@lang('parkinsoft.infoProjList4Bullet1')</li>
    <li>@lang('parkinsoft.infoProjList4Bullet2')</li>
    <li>@lang('parkinsoft.infoProjList4Bullet3')</li>
    <li>@lang('parkinsoft.infoProjList4Bullet4')</li>
    </ul>  

</div>

@endsection