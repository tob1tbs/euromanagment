@extends('layout.layout')

@section('css')

@endsection

@section('content')
<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-inner">
            <div class="nk-block-head">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <h4 class="nk-block-title font-neue">თანამშრომლების ჩამონათვალი</h4>
                    </div>        
                    <div class="nk-block-head-content">
                        <ul class="nk-block-tools g-3">
                            <li>
                                <a href="{{ route('actionUsersAdd') }}" class="btn btn-white btn-outline-light">
                                    <em class="icon ni ni-plus"></em>
                                    <span class="font-helvetica-regular">ახალი მომხმარებელი</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="nk-content-body">
                <div class="nk-block nk-block-lg">
                    <div class="card card-bordered">
                        <div class="row">
                            <div class="col-lg-9">
                                <div class="card-inner">
                                    <table class="datatable-init nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                                        <thead>
                                            <tr class="nk-tb-item nk-tb-head font-neue">
                                                <th class="nk-tb-col"><span class="sub-text">სახელი გვერი</span></th>
                                                <th class="nk-tb-col"><span class="sub-text">ტელეფონის ნომერი</span></th>
                                                <th class="nk-tb-col"><span class="sub-text">ელ-ფოსტა</span></th>
                                                <th class="nk-tb-col"><span class="sub-text">წვდომის ჯგუფი</span></th>
                                                <th class="nk-tb-col"><span class="sub-text">რეგისტრაციის თარიღი</span></th>
                                                <th class="nk-tb-col"><span class="sub-text">სტატუსი</span></th>
                                                <th class="nk-tb-col nk-tb-col-tools text-right"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($user_list as $user_item)
                                            <tr class="nk-tb-item font-helvetica-regular">
                                                <td class="nk-tb-col">
                                                    <div class="user-card">
                                                        <div class="user-info">
                                                            <span class="tb-lead">{{ $user_item->name }} {{ $user_item->lastname }}</span>
                                                            <span>{{ $user_item->personal_id }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="nk-tb-col tb-col-mb">
                                                    <span class="tb-amount">{{ $user_item->phone }}</span>
                                                </td>
                                                <td class="nk-tb-col tb-col-lg">
                                                    <span class="tb-amount">{{ $user_item->email }}</span>
                                                </td>
                                                <td class="nk-tb-col tb-col-lg">

                                                </td>
                                                <td class="nk-tb-col tb-col-md">
                                                    <span>{{ \Carbon\Carbon::parse($user_item->created_at)->format('Y-m-d') }}</span>
                                                </td>
                                                <td class="nk-tb-col tb-col-md">
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input" id="user_active_{{ $user_item->id }}" onclick="ProductActiveChange({{ $user_item->id }}, this)" @if($user_item->active == 1) checked @endif>
                                                        <label class="custom-control-label" for="user_active_{{ $user_item->id }}"></label>
                                                    </div>
                                                </td>
                                                <td class="nk-tb-col nk-tb-col-tools">
                                                    <ul class="nk-tb-actions gx-1">
                                                        <li>
                                                            <div class="drodown">
                                                                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <ul class="link-list-opt no-bdr">
                                                                        <li><a href="{{ route('actionUsersView', $user_item->id) }}"><em class="icon ni ni-focus"></em><span>პროფილი</span></a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="card-inner">
                                    asdasd
                                </div>
                            </div>
                        </div>
                    </div>
                </div>            
            </div>
        </div>
    </div>
</div>  
@endsection

@section('js')

@endsection