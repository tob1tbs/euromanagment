@extends('layout.layout')

@section('css')

@endsection

@section('content')
<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <div class="toggle-wrap nk-block-tools-toggle">
                                <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                                <div class="toggle-expand-content" data-content="pageMenu">
                                    <ul class="nk-block-tools g-3">
                                        <li class="nk-block-tools-opt">
                                            <div class="drodown">
                                                <a href="#" class="dropdown-toggle btn btn-icon btn-primary" data-toggle="dropdown"><em class="icon ni ni-plus"></em></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <ul class="link-list-opt no-bdr font-helvetica-regular">
                                                        <li><a href="{{ route('actionOrdersAdd') }}"><span>ახალი შეკვეთი დამატება</span></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle btn btn-light font-helvetica-regular ml-2" data-toggle="dropdown">ექსპორტი</a>
                                                <div class="dropdown-menu" style="min-width: 300px;">
                                                    <ul class="link-check font-helvetica-regular">
                                                        <li><span>Excel</span></li>
                                                        <li><a href="javascript:;" onclick="ProductBalanceDownload()">
                                                            <em class="icon ni ni-download"></em><span>არსებული შეკვეთების ჩამოტვირთვა</span></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="nk-block">
                    <div class="card card-bordered card-stretch">
                        <div class="card-inner-group">
                            <div class="card-inner position-relative card-tools-toggle">
                                <div class="card-title-group">
                                    <div class="card-tools">
                                        <div class="nk-block-head-content">
                                            <h3 class="nk-block-title page-title font-neue">შეკვეთების ჩამონათვალი</h3>
                                        </div>
                                    </div>
                                    <div class="card-tools mr-n1">
                                        <ul class="btn-toolbar gx-1">
                                            <li>
                                                <div class="toggle-wrap">
                                                    <a href="#" class="btn btn-icon btn-trigger toggle" data-target="cardTools"><em class="icon ni ni-menu-right"></em></a>
                                                    <div class="toggle-content" data-content="cardTools">
                                                        <ul class="btn-toolbar gx-1">
                                                            <li class="toggle-close">
                                                                <a href="#" class="btn btn-icon btn-trigger toggle" data-target="cardTools"><em class="icon ni ni-arrow-left"></em></a>
                                                            </li>
                                                            <li>
                                                                <div class="dropdown">
                                                                    <a href="#" class="btn btn-trigger btn-icon dropdown-toggle" data-toggle="dropdown">
                                                                        <div class="dot dot-primary"></div>
                                                                        <em class="icon ni ni-filter-alt"></em>
                                                                    </a>
                                                                    <div class="filter-wg dropdown-menu dropdown-menu-xl dropdown-menu-right">
                                                                        <div class="dropdown-head">
                                                                            <span class="sub-title dropdown-title font-neue">შეკვეთების ფილტრი</span>
                                                                            <div class="dropdown">
                                                                                <a href="#" class="btn btn-sm btn-icon">
                                                                                    <em class="icon ni ni-more-h"></em>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="dropdown-body dropdown-body-rg">
                                                                            <form method="get" class="row gx-6 gy-3">
                                                                                <div class="col-6">
                                                                                    <div class="form-group">
                                                                                        <label class="font-helvetica-regular overline-title overline-title-alt">შეკვეთის ნომერი</label>
                                                                                        <input type="text" class="form-control" name="search_query">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <div class="form-group">
                                                                                        <label class="font-helvetica-regular overline-title overline-title-alt">სტატუსი</label>
                                                                                        <select class="form-select form-select-sm" name="category_active">
                                                                                            
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-12">
                                                                                    <div class="form-group">
                                                                                        <label class="font-helvetica-regular overline-title overline-title-alt">კლიენტის პირადი ნომერი / საიდენტიფიკაციო კოდი</label>
                                                                                        <select class="form-select form-select-sm" name="category_active">
                                                                                            
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-12">
                                                                                    <div class="form-group">
                                                                                        <button type="submit" class="btn btn-secondary font-neue">გაფილტვრა</button>
                                                                                        <a href="" class="btn btn-primary font-neue">ფილტრის გასუფთავება</a>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="card-inner">
                                <div class="nk-block">
	                                <div class="card card-bordered card-stretch">
	                           			<div class="card-inner p-0">
                                            <div class="nk-tb-list nk-tb-ulist">
                                                <div class="nk-tb-item nk-tb-head font-helvetica-regular">
                                                    <div class="nk-tb-col"><span>შეკვეთის #</span></div>
                                                    <div class="nk-tb-col tb-col-mb"><span>მომხმარებელი</span></div>
                                                    <div class="nk-tb-col tb-col-md"><span>ღირებულება</span></div>
                                                    <div class="nk-tb-col tb-col-lg"><span>თარიღი</span></div>
                                                    <div class="nk-tb-col tb-col-md"><span>სტატუსი</span></div>
                                                    <div class="nk-tb-col tb-col-lg"><span>შეკვეთის ავტორი</span></div>
                                                    <div class="nk-tb-col nk-tb-col-tools">&nbsp;</div>
                                                </div>
                                                <div class="nk-tb-item">
                                                    <div class="nk-tb-col">
                                                        <div class="user-card">
                                                            <div class="user-info">
                                                                <span class="tb-lead">Abu Bin Ishtiyak <span class="dot dot-success d-md-none ml-1"></span></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="nk-tb-col tb-col-mb">
                                                        <span class="tb-lead-sub">Passport</span>
                                                    </div>
                                                    <div class="nk-tb-col tb-col-md">
                                                        <ul class="list-inline list-download">
                                                            <li>Front Side <a href="#" class="popup"><em class="icon ni ni-download"></em></a></li>
                                                            <li>Back Side <a href="#" class="popup"><em class="icon ni ni-download"></em></a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="nk-tb-col tb-col-lg">
                                                        <span class="tb-date">18 Dec, 2019 01:02 PM</span>
                                                    </div>
                                                    <div class="nk-tb-col tb-col-md">
                                                        <span class="tb-status text-success">Approved</span>
                                                    </div>
                                                    <div class="nk-tb-col tb-col-lg">
                                                        <div class="user-card">
                                                            <div class="user-name">
                                                                <span class="tb-lead">Janet Snyder</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="nk-tb-col nk-tb-col-tools">
                                                        <ul class="nk-tb-actions gx-1">
                                                            <li>
                                                                <div class="drodown">
                                                                    <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                    <div class="dropdown-menu dropdown-menu-right" style="min-width: 250px; width: 100%;">
                                                                        <ul class="link-check">
																	      <li><span>Show</span></li>
																	      <li class="active"><a href="#">10 Items</a></li>
																	      <li><a href="#">20 Items</a></li>
																	      <li><a href="#">50 Items</a></li>
																	  	</ul>
																	  	<ul class="link-check">
																	      <li><span class="font-neue">მოქმედება</span></li>
																	      @foreach($order_action_list as $action_item)
																	      <li class="font-helvetica-regular"><a href="javascript:;" onclick="MakeOrderAction({{ $action_item->id }}, 1)">{{ $action_item->name }}</a></li>
																	      @endforeach
																	  	</ul>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>         
	                                </div>
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
<script type="text/javascript" src="{{ url('assets/js/jquery-ui.min.js') }}"></script>
<script src="{{ url('assets/scripts/orders_scripts.js') }}"></script>
@endsection
